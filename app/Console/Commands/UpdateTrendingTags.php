<?php

namespace App\Console\Commands;

use Facades\App\Tag;
use Illuminate\Console\Command;

class UpdateTrendingTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updatetrendingtags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update all the trending tags in the forum.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Tag::updateTrendingTags();
        echo "Successfully updated trending tags at: " . now();
    }
}
