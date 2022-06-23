<?php

namespace App\Models;

class UserRole
{
     public static $roles = [
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

    public static function hasRole($name,$userRoleCount){
        if($userRoleCount == 0) return false;

        $indis = array_search($name,UserRole::$roles);

        if($indis === false) {
             throw new Exception('Element not found');
             return false;
        }
        if($indis == 0) $indis = 1;
        else $indis = 2 << ($indis - 1);


        
        return ($userRoleCount &  $indis) == $indis;
    }

}
