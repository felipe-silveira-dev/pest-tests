<?php


use App\Actions\CreateProductAction;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

it('should call the action to create a product', function () {
    Notification::fake();

    // Assert
    $this->mock(CreateProductAction::class)
        ->shouldReceive('handle')
        ->atLeast()->once();

    // Arrange
    $user = User::factory()->create();
    $title = 'Product 1';

    actingAs($user);

    // Act
    postJson(route('product.store'), ['title' => $title]);

});
