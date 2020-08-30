<?php

use App\Models\Evento\Tag;
use Illuminate\Database\Seeder;

class EventoTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tag::class, 10)->create();
    }
}
