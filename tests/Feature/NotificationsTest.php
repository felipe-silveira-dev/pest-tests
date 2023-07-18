<?php

use App\Models\User;
use App\Notifications\NewProductCreated;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

it('should send a notification about a new product created', function() {
    Notification::fake();
    $user = User::factory()->create();

    actingAs($user);

    postJson(route('product.store'), [
        'title' => 'product 1'
    ])->assertCreated();

    Notification::assertSentTo(
        [$user], NewProductCreated::class
    );
});
