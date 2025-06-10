<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Article;

class ArticleObserver
{
    /**
     * Detects if a user is mention on creating an article
     */
    public function created(Article $article)
    {
        $this->findAndSyncMentions(
            $article,
        );
    }

    /**
     * Mentions new users that are newly
     * mentioned in the article
     */
    public function updated(Article $article)
    {
        $this->findAndSyncMentions(
            $article,
        );
    }

    /**
     * Find users and sync them
     */
    protected function findAndSyncMentions(Article $article)
    {
        preg_match_all(
            '(\@(?P<username>[a-zA-Z0-9\-\_]+))',
            $article->content,
            $mentions,
            PREG_SET_ORDER
        );

        // Don't sync if there's no mentions
        if (count($mentions) == 0) {
            return;
        }

        $article->mentions()->sync(
            User::whereIn('username', collect($mentions)->pluck('username'))->pluck('id')->toArray(),
        );
    }
}
