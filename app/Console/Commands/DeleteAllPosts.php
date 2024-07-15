<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class DeleteAllPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-all-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (Post::all() as $post) {
            $post->delete();
        }
    }
}
