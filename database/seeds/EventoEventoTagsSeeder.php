<?php

use App\Models\Evento\EventoTag;
use Illuminate\Database\Seeder;

class EventoEventoTagsSeeder extends Seeder
{
    public function run()
    {
        $unigueIds = [];
        foreach(range(1,10) as $k){
            $unigueIds[] = random_int(1,10);
        }
        $unigueIds = array_unique($unigueIds);

        // its just don't working xD
        foreach($unigueIds as $id){
            factory(EventoTag::class, 1)->create()->each(function(EventoTag $eventoTag, int $id) {
                $eventoTag->tag_id = $id;
            });
        }
    }
}
