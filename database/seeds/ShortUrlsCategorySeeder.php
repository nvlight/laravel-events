<?php

use App\Models\ShortUrl\ShortUrlsCategory as Category;
use Illuminate\Database\Seeder;

class ShortUrlsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 10)->create();
    }
}
