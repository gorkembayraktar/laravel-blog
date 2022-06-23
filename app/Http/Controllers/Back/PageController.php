<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;


use Illuminate\Support\Str;

use Illuminate\Support\Facades\File;

use App\Models\UserRole;

use Auth;

class PageController extends Controller
{
    //
    public function index(){
        $pages = Page::orderBy('order')->get();
        return view('back.pages.index',compact('pages'));
    }
    public function create(){
        return view('back.pages.create');
    }
    public function update($id){
        $page = Page::findOrFail($id);

        if( ! UserRole::hasRole("Sayfaları Düzenle",Auth::user()->roleCount)){
            return redirect()->back();
        }
        return view('back.pages.update',compact('page'));
    }
    public function updatePost(Request $request, $id){
        $request->validate([
            'title' => 'min:3'
        ]);

        if($request->hasFile('image')):
            $request->validate([                
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        endif;

        $page = Page::findOrFail($id);


        if( ! UserRole::hasRole("Sayfaları Düzenle",Auth::user()->roleCount)){
            toastr()->error('Sayfayı düzenlemek için yeterli izne sahip değilsiniz.','Başarısız');
            return redirect()->route('admin.page.index');
        }

        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title);
        
        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image = 'uploads/'.$imageName;
        }

        $page->save();
        toastr()->success('Sayfa düzenlendi','Başarılı');
        return redirect()->route("admin.page.index");
    }
    public function post(Request $request){

        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $lastPage = Page::orderBy('order','desc')->first();

        $page = new Page;

        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title);
        $page->order = $lastPage->order + 1;
        
        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image = 'uploads/'.$imageName;
        }

        $page->save();
        toastr()->success('Sayfa başarılı şekilde oluşturuldu','Başarılı');
        return redirect()->route("admin.page.index");

    }
    public function delete($id){
        $page = Page::find($id);



        if( ! UserRole::hasRole("Sayfaları Sil",Auth::user()->roleCount)){
            toastr()->error('Sayfayı silmek için yeterli izne sahip değilsiniz.','Başarısız');
            return redirect()->route('admin.page.index');
        }

        if(File::exists($page->image)){
            File::delete(public_path($page->image));
        }


        $page->forceDelete();
        
        
        toastr()->success('Sayfa başarılı şekilde kaldırıldı.');
        return redirect()->route('admin.page.index');
    }
    public function orders(Request $request){

        if( ! UserRole::hasRole("Sayfaları Düzenle",Auth::user()->roleCount)){
            return response()->json([
                'status' => 'error',
                'message'=>'Sayfayı düzenlemek için yeterli izne sahip değilsiniz.'
            ],403);
        }


        $orders = $request->get('page');
        foreach($orders as $key => $order){
            Page::where('id',$order)->update(['order' => $key]);
        }
        return response()->json([
            'status' => 'ok'
        ],201);
    }
    public function switch(Request $request){

        if( ! UserRole::hasRole("Sayfaları Düzenle",Auth::user()->roleCount)){
            return response()->json([
                'status' => 'error',
                'message'=>'Sayfayı düzenlemek için yeterli izne sahip değilsiniz.'
            ],403);
        }
        
        $page = Page::findOrFail($request->id);
        $page->status = $page->status == 1 ? 0 : 1;
        $page->save();
        return response()->json([
            'status' => 'ok',
            'data' => $page
        ],201);
        
    }
}
