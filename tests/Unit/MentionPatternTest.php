<?php

it('extracts usernames using the mention pattern', function () {
    $content = "Hello there, @Mohamad and @Frans_01";

    preg_match_all(
        '(\@(?P<username>[a-zA-Z0-9\-\_]+))',
        $content,
        $matches,
        PREG_SET_ORDER
    );

    $usernames = collect($matches)->pluck('username')->all();

    expect($usernames)->toBe(['Mohamad', 'Frans_01']);
});

it('returns empty array when there are no mentions', function () {
    $content = "Hello there, no mentions in here";

    preg_match_all(
        '(\@(?P<username>[a-zA-Z0-9\-\_]+))',
        $content,
        $matches,
        PREG_SET_ORDER
    );

    $usernames = collect($matches)->pluck('username')->all();

    expect($usernames)->toBe([]);
});
