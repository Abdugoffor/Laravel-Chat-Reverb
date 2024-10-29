<?php

namespace App\Console\Commands;

use App\Events\MessageSent;
use function Laravel\Prompts\text;
use Illuminate\Console\Command;

class SendMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message to all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = text(
            label: 'ismingiz nima ?',
            required: true,
        );

        $text = text(
            label: 'Yaxshi batafsil o`izngiz haqingizda aytib bering',
            required: true,
        );

        MessageSent::dispatch($name, $text);
    }
}
