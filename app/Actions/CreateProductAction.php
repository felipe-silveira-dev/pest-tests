<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductCreated;

class CreateProductAction
{
    public function handle(
        array $product,
        int   $userId
    ): void
    {
        Product::query()
            ->create(array_merge(
                $product,
                ['owner_id' => $userId]
            ));

        $user = User::find($userId);
        $user->notify(new NewProductCreated());
    }
}
