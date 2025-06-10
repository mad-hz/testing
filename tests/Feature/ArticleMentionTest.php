<?php

use App\Models\User;
use App\Notifications\ArticleMention;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Notification;

it('detects and stores mentioned users', function () {
    // The user who creates the article
    $user = User::factory()->create();

    // The mentioned users
    [$firstUser, $secondUser] = User::factory(2)
        ->state(new Sequence(
            ['username' => 'Mohamad'],
            ['username' => 'Frans'],
        ))
        ->create();

    $article = $user->articles()->create([
        'title' => 'Hello there!',
        'content' => "Mentioning @$firstUser->username and @$secondUser->username"
    ]);

    expect($article->mentions)->toHaveCount(2)
        ->pluck('pivot.user_id')->toContain($firstUser->id, $secondUser->id);
});

it('removes users who are unmentioned', function () {
    // The user who creates the article
    $user = User::factory()->create();

    // The mentioned users
    [$firstUser, $secondUser] = User::factory(2)
        ->state(new Sequence(
            ['username' => 'Mohamad'],
            ['username' => 'Frans'],
        ))
        ->create();

    $article = $user->articles()->create([
        'title' => 'Hello there!',
        'content' => "Mentioning @$firstUser->username and @$secondUser->username"
    ]);

    $article->update([
        'title' => 'An update without the second user',
        'content' => "Mentioning @$firstUser->username"
    ]);

    expect($article->mentions)->toHaveCount(1)
        ->pluck('pivot.user_id')->not->toContain($secondUser->id);
});

it('sends a notification to the mentioned user', function () {
    Notification::fake();

    // The user who creates the article
    $user = User::factory()->create();

    // The mentioned users
    [$firstUser, $secondUser] = User::factory(2)
        ->state(new Sequence(
            ['username' => 'Mohamad'],
            ['username' => 'Frans'],
        ))
        ->create();

    $article = $user->articles()->create([
        'title' => 'Hello there!',
        'content' => "Mentioning @$firstUser->username and @$secondUser->username"
    ]);

    Notification::assertSentTo([$firstUser, $secondUser], ArticleMention::class);
});

it('does not send a notification when modifying an article', function () {
    Notification::fake();

    // The user who creates the article
    $user = User::factory()->create();

    $firstUser = User::factory()->create(['username' => 'frans']);

    $article = $user->articles()->create([
        'title' => 'Hello there!',
        'content' => "Mentioning @$firstUser->username"
    ]);

    $article->update([
        'title' => 'Hello there again!',
        'content' => "Mentioning @$firstUser->username with a modified article"
    ]);

    Notification::assertSentTimes(ArticleMention::class, 1);
});
