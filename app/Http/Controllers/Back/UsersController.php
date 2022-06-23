<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Admin;
use App\Models\UserRole;

use Auth;

class UsersController extends Controller
{
    //



    public function index(){
       
        if( ! UserRole::hasRole('Kullanıcıları Görüntüle',Auth::user()->roleCount)){
            return redirect()->route('admin.dashboard');
        }

        
        $users = DB::table('admins')->get();
        $permission = UserRole::hasRole('Kullanıcıları Yetkilendir',Auth::user()->roleCount);

        return view('back.users.index',compact('users','permission'));

    }

    public function role($id){
    
        
        $user = DB::table('admins')->find($id);
        
        if(!$user){
            return redirect()->route('admin.users.index');
        }
        
        $roles = DB::table('roles')->get();
        

        return view('back.users.roles',compact(['roles','user']));

    }

    public function roleUpdate(Request $request, $id){
        $user = Admin::find($id);

        if(!$user){
            toastr()->error('Bu kullanıcı için işlem gerçekleştirilemedi.','Başarısız');
            return redirect()->back();
        }

      
        if( ! UserRole::hasRole('Kullanıcıları Yetkilendir',Auth::user()->roleCount)){
            toastr()->error('İşlem yapmak için yeterli izne sahip değilsiniz.,','Engellendi.');
            return redirect()->back();
        }

        $sum = $request->roles && count($request->roles)>0 ? array_sum($request->roles) : 0;
        $user->roleCount = $sum;

        $user->save();

        toastr()->success('Profil rolleri güncellendi.','Başarılı');
        return redirect()->back();

    }
}
