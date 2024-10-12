<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages=['Hakkımızda','Kariyer','Vizyon','Misyonumuz'];
        $count=0;
        $faker= Faker::create();
        foreach($pages as $page){
            $count++;
            DB::table('pages')->insert([
                'title'=>$page,
                'slug'=>Str::slug($page),
                'image'=>$faker->imageUrl(800,400, 'cats', true,),
                'content'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, cumque quas doloribus ut omnis tempora! Consectetur quis, magni, assumenda officia quae ullam quasi voluptate porro totam voluptatum eius hic dicta.',
                'order'=>$count,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
    }
}
