<?php

use App\User;
use App\Collection;
use Illuminate\Database\Seeder;

class CollectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        if ($users->isNotEmpty()) {
            factory(Collection::class, 10)->create(['user_id' => $users->random()->id]);
        } else {
            factory(Collection::class, 10)->create();
        }
    }
}
