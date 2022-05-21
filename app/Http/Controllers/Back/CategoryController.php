<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;

use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //

    public function index(){
        $categories = Category::all();
        return view('back.categories.index',compact('categories'));
    }

    public function switch(Request $request){
        $category = Category::findOrFail($request->id);
        $category->status = $category->status == 1 ?  0 : 1;
        $category->save();
    }
    public function create(Request $request){
        $isExist = Category::whereSlug(Str::slug($request->category))->first();
        if($isExist){
            toastr()->error($request->category.' adından bir kategori zaten bulunuyor.');
            return redirect()->back();
        }
        $category = new Category;
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori başarılı şekilde oluşturuldu');
        return redirect()->back();

    }
    public function update(Request $request){
        $isSlug = Category::whereSlug(Str::slug($request->slug))->whereNotIn('id',[$request->id])->first();
        $isName = Category::whereName($request->category)->whereNotIn('id',[$request->id])->first();
        if($isSlug || $isName){
            toastr()->error($request->category.' adından bir kategori zaten bulunuyor.');
            return redirect()->back();
        }
        $category = Category::find($request->id);
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori başarılı şekilde güncellendi.');
        return redirect()->back();

    }
    public function delete(Request $request){
        $category = Category::findOrFail($request->id);
        if($category->id == 1){
            toastr()->error('Bu kategori silinemez');
            return redirect()->back();
        }
        $count = $category->articleCount();
        if($count > 0 ){
            Article::where('category_id',$category->id)->update(['category_id' => 1]);
            $defaultCategory = Category::find(1);
            toastr()->success("Kategori başarılı şekilde silindi.","Bu kategoriye ait $count makale  $defaultCategory->name kategorisine taşındı. ");
        }
        $category->delete();
        
        if($count == 0){
            toastr()->success("Kategori başarılı şekilde silindi.");
        }        
        return redirect()->back();
    }

    public function getData(Request $request){
        $category = Category::findOrFail($request->id);
        return response()->json($category);

    }
}
