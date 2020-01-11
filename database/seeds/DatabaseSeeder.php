<?php

use App\Models\User;
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
    }
}
