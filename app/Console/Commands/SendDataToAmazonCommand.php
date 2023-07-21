<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendDataToAmazonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-data-to-amazon-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Http::withToken('123456')
            ->post('https://api.amazon.com/products', [
                'product' => [
                    'title' => 'Product 1',
                    'owner' => 'Rafael Lunardelli'
                ]
            ]);
    }
}
