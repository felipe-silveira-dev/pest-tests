<?php


use App\Console\Commands\ImportProductsFromAmazonCommand;
use App\Console\Commands\SendDataToAmazonCommand;
use Illuminate\Http\Client\Request;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('should import products from amazon', function () {
    Http::fake([
        'https://api.amazon.com/products' => Http::response([
            ['title' => 'Product 1'],
            ['title' => 'Product 2'],
            ['title' => 'Product 3'],
        ])
    ]);

    artisan(ImportProductsFromAmazonCommand::class);

    assertDatabaseCount('products', 3);
    assertDatabaseHas('products', ['title' => 'Product 1']);
    assertDatabaseHas('products', ['title' => 'Product 2']);
    assertDatabaseHas('products', ['title' => 'Product 3']);
});

it('should send data to amazon', function () {
    Http::fake();

    artisan(SendDataToAmazonCommand::class);

    Http::assertSent(function (Request $request): bool {
        return $request->url() == 'https://api.amazon.com/products'
            && $request->header('Authorization') == ['Bearer 123456']
            && json_decode($request->body(), true) == ['product' => ['title' => 'Product 1', 'owner' => 'Rafael Lunardelli']];
    });
});
