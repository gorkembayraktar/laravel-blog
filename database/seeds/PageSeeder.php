<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['Hakkımızda','Kariyer','Vizyonumuz','Misyonumuz','İletişim'];
        foreach($pages as $id => $page){
            DB::table('pages')->insert([
                'title'=>$page,
                'slug'=>Str::slug($page),
                'image'=>'https://miro.medium.com/max/1000/1*pVAtEbTjgBDqBp0OXMxYww.jpeg',
                'content'=>'Lorem ipusm sit maet imet ler imet lorem ipsum sit
                            Lorem ipusm sit maet imet ler imet lorem ipsum sit
                            Lorem ipusm sit maet imet ler imet lorem ipsum sit
                            Lorem ipusm sit maet imet ler imet lorem ipsum sit
                            Lorem ipusm sit maet imet ler imet lorem ipsum sit
                            Lorem ipusm sit maet imet ler imet lorem ipsum sit
                            Lorem ipusm sit maet imet ler imet lorem ipsum sit
                            ',
                'order'=>$id,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
        //
    }
}
