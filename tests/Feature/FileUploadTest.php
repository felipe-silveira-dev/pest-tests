<?php


use App\Models\User;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\post;

it('should be able to upload an image', function () {
    Storage::fake('avatar');

    $user = User::factory()->create();

    actingAs($user);

    $file = UploadedFile::fake()->image('image.jpg');

    post(route('upload-avatar'), [
        'file' => $file
    ])->assertOk();

    Storage::disk('avatar')->assertExists($file->hashName());
});

it('should be able to upload a csv', function () {
    $user = User::factory()->create();

    actingAs($user);

    $data = <<<txt
project 1,1231231asd
project 2,asdjasdjh
project 3,akjlsdjadsjh
txt;

    $file = UploadedFile::fake()->createWithContent('products.csv', $data);

    post(route('product.import.with-file'), [
        'file' => $file
    ])->assertOk();

    assertDatabaseCount('products', 3);
});
