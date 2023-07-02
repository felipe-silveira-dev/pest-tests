<?php

use App\Mail\WelcomeEmail;
use App\Models\User;
use function Pest\Laravel\post;

test('an email was sent', function () {
    Mail::fake();

    $user = User::factory()->create();

    post(route('sending-email', $user))->assertOk();

    Mail::assertSent(WelcomeEmail::class);
});

