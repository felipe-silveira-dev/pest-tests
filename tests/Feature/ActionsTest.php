<?php

use App\Actions\CreateProductAction;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;
use function Pest\Laravel\mock;

it('should be called at least once', function () {
    // Assert
    mock(CreateProductAction::class)
        ->shouldReceive('handle')
        ->atLeast()->once();

    // Arrange
    $user = User::factory()->create();
    actingAs($user);

    // Act
    postJson(route('product.store'), ['title' => 'product 1'])
        ->assertCreated();
});
