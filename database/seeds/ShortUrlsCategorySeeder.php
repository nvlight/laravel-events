<?php

use App\Models\ShortUrl\ShortUrlsCategory as Category;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class ShortUrlsCategorySeeder extends Seeder
{

    public function run()
    {
        DB::table('shorturl_categories')->truncate();

        $categories = factory(Category::class, 10)->create();
        foreach($categories as $category){

            if (random_int(1,2)) {
                $childs = factory(Category::class, random_int(1, 10))->create();
                foreach ($childs as $child) {
                    $child->update(['parent_id' => $category->id]);

                    if (random_int(1, 2)) {
                        $agains = factory(Category::class, random_int(1, 3))->create();
                        foreach ($agains as $again) {
                            $again->update(['parent_id' => $child->id]);
                        }
                    }
                }
            }
        }

    }
}
