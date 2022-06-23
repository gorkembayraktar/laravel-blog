<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;

use Illuminate\Support\Str;
use App\Models\UserRole;
use Auth;
class ConfigController extends Controller
{
    //
    public function index(){
        if( ! UserRole::hasRole("Admin Ayarlarını Görüntüle",Auth::user()->roleCount)){
            return redirect()->route('admin.dashboard');
        }
        $config = Config::find(1);
        return view('back.config.index',compact('config'));
    } 
    public function update(Request $request){
        if( ! UserRole::hasRole("Admin Ayarlarını Düzenle",Auth::user()->roleCount)){
            toastr()->error('Bu işlemi yapmak için yetkiniz bulunmamaktadır.');

            return redirect()->back();
        }
       $config = Config::find(1);
       $config->title = $request->title;
       $config->active = $request->active;
       $config->facebook = $request->facebook;
       $config->youtube = $request->youtube;
       $config->instagram = $request->instagram;
       $config->github = $request->github;

       if($request->hasFile('logo')){
           $logo = Str::slug($request->title). '-logo.'.$request->logo->getClientOriginalExtension();
           $request->logo->move(public_path('uploads'), $logo);
           $config->icon = 'uploads/'.$logo;
       }

       if($request->hasFile('favicon')){
            $favicon = Str::slug($request->title).'-favicon.'.$request->favicon->getClientOriginalExtension();
            $request->favicon->move(public_path('uploads'), $favicon);
            $config->favicon = 'uploads/'.$favicon;
        }

        $config->save();
        toastr()->success('Ayarlar başarıyla güncellendi.');

        return redirect()->back();

    }
}
