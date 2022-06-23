<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $liste = [
          "Makaleleri Görüntüle",
          "Makaleleri Düzenle",
          "Makaleleri Sil",
          "Kategorileri Görüntüle",
          "Kategorileri Düzenle",
          "Kategorileri Sil",
          "Sayfaları Görüntüle",
          "Sayfaları Düzenle",  
          "Sayfaları Sil",
          "Kullanıcıları Görüntüle",
          "Kullanıcıları Düzenle",
          "Kullanıcıları Sil",
          "Kullanıcıları Yetkilendir",
          "Admin Ayarlarını Görüntüle",
          "Admin Ayarlarını Düzenle"  
        ];
        DB::table('roles')->truncate();

        foreach($liste as $indis => $item){

            DB::table('roles')->insert([
                'id'=>$indis == 0 ? 1 : (2 << ($indis - 1)),
                'name'=>$item,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
    }
}
