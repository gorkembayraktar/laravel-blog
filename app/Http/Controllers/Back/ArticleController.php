<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\File;

use App\Models\UserRole;
use Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( ! UserRole::hasRole("Makaleleri Görüntüle",Auth::user()->roleCount)){
            return redirect()->route('admin.dashboard');
        }
        $articles = Article::orderBy('created_at','ASC')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( ! UserRole::hasRole("Makaleleri Düzenle",Auth::user()->roleCount)){
            return redirect()->route('admin.makaleler.index');
        }
        $categories = Category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( ! UserRole::hasRole("Makaleleri Düzenle",Auth::user()->roleCount)){
            toastr()->error('Bu işlemi yapabilecek yetkiniz bulunmamaktır.','Başarısız');
            return redirect()->route("admin.makaleler.index");
        }

        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $article = new Article;

        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);
        
        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image = 'uploads/'.$imageName;
        }

        $article->save();
        toastr()->success('Makale başarılı şekilde oluşturuldu','Başarılı');
        return redirect()->route("admin.makaleler.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( ! UserRole::hasRole("Makaleleri Düzenle",Auth::user()->roleCount)){
            toastr()->error('Bu işlemi yapabilecek yetkiniz bulunmamaktır.','Başarısız');
            return redirect()->route("admin.makaleler.index");
        }

        $article = Article::findOrFail($id);
        $categories = Category::all();

        return view('back.articles.update',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if( ! UserRole::hasRole("Makaleleri Düzenle",Auth::user()->roleCount)){
            toastr()->error('Bu işlemi yapabilecek yetkiniz bulunmamaktır.','Başarısız');
            return redirect()->route("admin.makaleler.index");
        }

        $request->validate([
            'title' => 'min:3'
        ]);

        if($request->hasFile('image')):
            $request->validate([                
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        endif;

        $article = Article::findOrFail($id);

        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);
        
        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image = 'uploads/'.$imageName;
        }

        $article->save();
        toastr()->success('Makale düzenlendi','Başarılı');
        return redirect()->route("admin.makaleler.index");
    }

    public function switch(Request $request){
        if( ! UserRole::hasRole("Makaleleri Düzenle",Auth::user()->roleCount)){
           
            return;
        }

        $article = Article::findOrFail($request->id);
        $article->status =  $article->status == 0 ? 1 : 0;
        $article->save();
        
        return;
    }

    public function delete($id){

        if( ! UserRole::hasRole("Makaleleri Sil",Auth::user()->roleCount)){
            toastr()->error('Bu işlemi yapabilecek yetkiniz bulunmamaktır.','Başarısız');
            return redirect()->route("admin.makaleler.index");
        }
        Article::find($id)->delete();
        toastr()->success('Makale başarıyla silindi.');
        return redirect()->route('admin.makaleler.index');
    }

    public function trashed(){
        if( ! UserRole::hasRole("Makaleleri Düzenle",Auth::user()->roleCount)){
            return redirect()->route("admin.makaleler.index");
        }
        $articles = Article::onlyTrashed()->orderBy('deleted_at','DESC')->get();
        return view('back.articles.trashed',compact('articles'));
    }

    public function recover($id){
        if( ! UserRole::hasRole("Makaleleri Düzenle",Auth::user()->roleCount)){
            toastr()->error('Bu işlemi yapabilecek yetkiniz bulunmamaktır.','Başarısız');
            return redirect()->route("admin.makaleler.index");
        }
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Makale kurtarıldı');
        return redirect()->route('admin.makaleler.index');
    }
    public function force_delete($id){
        if( ! UserRole::hasRole("Makaleleri Sil",Auth::user()->roleCount)){
            toastr()->error('Bu işlemi yapabilecek yetkiniz bulunmamaktır.','Başarısız');
            return redirect()->route("admin.makaleler.index");
        }
        $article = Article::onlyTrashed()->find($id);
        if(File::exists($article->image)){
            File::delete(public_path($article->image));
        }


        $article->forceDelete();
        
        
        toastr()->success('Makale yeryüzünden kaldırıldı.');
        return redirect()->route('admin.trashed.article');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        echo $id;
    }
}
