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

            if (random_int(0,1)) {
                $childs = factory(Category::class, random_int(1, 10))->create();
                foreach ($childs as $child) {
                    $child->update(['parent_id' => $category->id]);

                    if (random_int(0, 1)) {
                        $agains = factory(Category::class, random_int(1, 3))->create();
                        foreach ($agains as $again) {
                            $again->update(['parent_id' => $child->id]);
                        }
                    }
                }
            }
        }

//        factory(Category::class, 10)->create()->each(function (Category $category){
//            for($i=0; $i<random_int(1, 3); $i++){
//                $GLOBALS['category'] = $category;
//                factory(Category::class)->create()->each(function (Category $category2){
//                    $GLOBALS['category']->update(['parent_id' => $category2->id]);
//                    for($i=0; $i<random_int(2, 3); $i++){
//                        //factory(Category::class)->create()->update(['parent_id' => $category->id]);
//                    }
//                });
//            }
//        });

//        factory(Category::class, 10)->create()->each(function (Category $category){
//            $counts = [0, random_int(3, 7)];
//            $category->children()->saveMany(factory(Category::class, $counts[array_rand($counts)])->create()->each(function(Category $category) {
//                $counts = [0, random_int(3, 7)];
//                $category->children()->saveMany(factory(Category::class, $counts[array_rand($counts)])->create());
//            }));
//        });
    }
}
