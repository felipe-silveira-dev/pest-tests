<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-product-command {title} {user}';

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

        $action = app(CreateProductAction::class);
        $action->handle(compact('title'), $user);
    }
}
