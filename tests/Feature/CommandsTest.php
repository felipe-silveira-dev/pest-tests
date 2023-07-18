<?php

use App\Console\Commands\CreateProductCommand;
use App\Models\User;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseHas;

it('should be able to create a product via command', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    artisan(
        CreateProductCommand::class,
        [
            'title' => 'product a',
            'user' => 1
        ]
    );

    // Assert
    assertDatabaseHas('products', [
        'title' => 'product a',
        'owner_id' => 1
    ]);
});
