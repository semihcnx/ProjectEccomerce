<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $this->call(KategoriTableSeeder::class);
        $this->call(UrunTableSeeder::class);
        $this->call(KullaniciSeed::class);
        // $this->call(UrunTableSeed::class);

    }
}
