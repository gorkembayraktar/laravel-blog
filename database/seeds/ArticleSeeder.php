<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('articles')->delete();
        $faker = Faker::create();
        for($i=0;$i<10;$i++):
            $title = $faker->sentence(6);
            DB::table('articles')->insert([
                'category_id'=>rand(1,7),
                'title'=>$title,
                'image'=>$faker->imageUrl(800,400,'cats',true,'Faker'),
                'content'=>$faker->paragraph(6),
                'slug'=>Str::slug($title),
                'created_at'=>$faker->dateTime($max = 'now'),
                'updated_at'=>now()
            ]);
        endfor;
    }
}
