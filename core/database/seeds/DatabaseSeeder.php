<?php

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
        $this->call([

        	AdminTableSeeder::class,

        ]);

        // factory(App\Parachute::class, 3)->create();
        // factory(App\GemPack::class, 3)->create();
        // factory(App\BoostPack::class, 3)->create();
        
    }
}
