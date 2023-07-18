<?php

use App\Actions\CreateProductAction;
use App\Models\User;
use App\Notifications\NewProductCreated;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\mock;
use function Pest\Laravel\postJson;

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

it('should create a new product', function () {
    // Arrange
    Notification::fake();
    $user = User::factory()->create();

    // Act
    $action = new CreateProductAction();
    $action->handle(['title' => 'product 1'], $user->id);

    // Assert
    assertDatabaseHas('products', [
        'title' => 'product 1',
        'owner_id' => $user->id
    ]);

    Notification::assertSentTo(
        [$user], NewProductCreated::class
    );
});
