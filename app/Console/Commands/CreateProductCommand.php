<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Models\User;
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
     * @throws \Exception
     */
    public function handle(): void
    {
        $title = $this->argument('title');
        $user = $this->argument('user');

        if (!$user) {
            $userName = $this->choice(
                'Please, provide the user Id of the products owner',
                User::all()->pluck('name')->toArray()
            );

           $user = User::whereName($userName)->firstOrFail()->id;
        }

        if (!$title) {
            $title = $this->ask('Please, provide a title for the product');
        }

        $action = app(CreateProductAction::class);
        $action->handle(compact('title'), $user);

        $this->info('Product created!');
    }
}
