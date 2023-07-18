<?php

use App\Jobs\ImportProduct;
use Illuminate\Support\Facades\Queue;
use function Pest\Laravel\postJson;

it('should sends a job to the queue', function() {
    // Arrange
    Queue::fake();

    // Act
    postJson(route('product.import'))
        ->assertOk();

    // Assert
    Queue::assertPushed(ImportProduct::class, 1);
});
