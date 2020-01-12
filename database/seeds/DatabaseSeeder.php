<?php

use App\Models\Tag;
use App\Models\User;
use App\Models\Issue;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
            'email' => 'user@cwsupport.com',
        ]);
        $admin = factory(User::class)->create([
            'email' => 'admin@cwsupport.com',
            'is_admin' => true,
        ]);

        $issues = factory(Issue::class, 10)->create(['user_id' => $user->id]);
        $issues->each(function ($issue) {
            $tags = factory(Tag::class, 3)->create();
            
            $issue->tags()->attach($tags);
        });
    }
}
