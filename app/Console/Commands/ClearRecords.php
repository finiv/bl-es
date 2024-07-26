<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Elastic\Elasticsearch\Client;

class ClearRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all records in users, posts, categories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $classes = [Post::class, Category::class, User::class];

        foreach ($classes as $class) {
            foreach ($class::all() as $instance) {
                $instance->delete();
            }
        }
    }
}
