<?php

use App\Jobs\ImportProduct;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('should sends a job to the queue', function () {
    // Arrange
    Queue::fake();
    $user = User::factory()->create();
    actingAs($user);

    // Act
    postJson(
        route('product.import'),
        ['products' => [0 => 'product 1', 1 => 'product 2']]
    )
        ->assertOk();

    // Assert
    Queue::assertPushed(ImportProduct::class, 1);
});

it('should import product correctly', function () {
    $user = User::factory()->create();

    (new ImportProduct(
        [0 => 'product 1', 1 => 'product 2'],
        $user->id
    ))->handle();

    assertDatabaseCount('products', 2);
    assertDatabaseHas('products', [
        'title' => 'product 1',
        'owner_id' => $user->id
    ]);
});
