<?php

use App\Console\Commands\CreateProductCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use function Pest\Laravel\artisan;

it('should throw an exception when user is not found', function () {
    artisan(
        CreateProductCommand::class,
        ['user' => 999, 'title' => 'Something']
    );
})->throws(ModelNotFoundException::class);
