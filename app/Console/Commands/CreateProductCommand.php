<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-product-command {title?} {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle():void
    {
        $title = $this->argument('title');
        $user = $this->argument('user');

        if(!$user) {
            $user = $this->components->ask('Please, provide a valid user id');
        }

        if(!$title) {
            $title = $this->components->ask('Please, provide a title for the product');
        }

        Product::query()
            ->create([
                'title' => $title,
                'owner_id' => $user
            ]);

        $this->components->info('Product created!!');
    }
}
