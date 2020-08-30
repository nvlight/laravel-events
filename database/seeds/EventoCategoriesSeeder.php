<?php

use Illuminate\Database\Seeder; 
use App\Models\Evento\Category;

class EventoCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class,11)->create();
    }
}
