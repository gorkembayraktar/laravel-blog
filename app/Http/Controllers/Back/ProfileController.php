<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Config;
use App\Models\Admin;

use Hash;
use Auth;

class ProfileController extends Controller
{
    //

    public function index(){
       

        $config = Config::find(1);


        return view('back.profile.index',compact('config'));

    }

    public function update(){
        $config = Config::find(1);


        return view('back.profile.update',compact('config'));

    }
    public function updatePost(Request $request){
        $rules = [
            "name"=>'required|min:5',
            "email"=>'required|email'
        ];
        $messages = [
            "name.required" => "Ad Soyad gereklidir."
        ];
        $validate = Validator::make($request->post(),$rules,$messages);
     
        if($validate->fails()){
            $validate->customTagName = 'post';
            return redirect()->route('admin.profile.update')->withErrors($validate)->withInput();
        }

        $admin = Admin::find(auth()->user()->id);
        $admin->name = $request->name;
        $admin->email = $request->email;

        $admin->save();

        return redirect()->route('admin.profile.update')->with('success','Bilgiler Kaydedildi.')->with('update',1);

    }

    public function password(Request $request){

        if (!(Hash::check($request->post('oldpw'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("passerror","Mevcut şifrenizi doğru giriniz.");
        }

        if(strcmp($request->post('oldpw'), $request->post('password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("passerror","Yeni şifreniz önceki şifreniz ile aynı olamaz.");
        }


        $rules = [
            'oldpw'=>'required|min:4',
            'password' => 'min:4|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:4'
        ];
    
        
        $validate = Validator::make($request->post(),$rules);
     
        if($validate->fails()){
            $validate->customTagName = 'passwordChange';
            return redirect()->route('admin.profile.update')->withErrors($validate)->with('passwordErrors',1)->withInput();
        }

        $user = Auth::user();
        $user->password = bcrypt($request->post('password'));
        $user->save();

        return redirect()->route('admin.profile.update')->with('success','Şifre değiştirildi.')->with('passwordChange',1);
        
    }
}
