<?php

use App\Jobs\ImportProductsJob;
use App\Mail\WelcomeEmail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/404', function () {
    return ['oi'];
});

Route::get('/403', function () {
    abort_if(true, 403);

    return ['oi'];
});


Route::get('/products', function () {
    return view('products', [
        'products' => Product::all()
    ]);
});

Route::post('/products', function () {

    request()->validate([
        'title' => ['required', 'max:255']
    ]);

    Product::query()
        ->create(request()->only('title'));

    return response()->json('', 201);
})->name('product.store');

Route::put('/products/{product}', function (Product $product) {
    $product->title = request()->get('title');
    $product->save();

})->name('product.update');

Route::delete('/products/{product}', function (Product $product) {
    $product->forceDelete();
})->name('product.destroy');

Route::delete('/products/{product}/soft-delete', function (Product $product) {
    $product->delete();
})->name('product.soft-delete');


Route::post('/import-products', function() {
    $data = request()->get('data');

    ImportProductsJob::dispatch($data);
})->name('product.import');

Route::post('/sending-email/{user}', function (User $user) {
    Mail::to($user)->send(new WelcomeEmail($user));
})->name('sending-email');
