<?php

use App\Models\Evento\EventoCategory;
use Illuminate\Database\Seeder;

class EventoEventoCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EventoCategory::class, 2)->create();
    }
}
