<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Models
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;

class Homepage extends Controller
{

    public function __construct(){
        view()->share('categories',$this->GetCategories());
        view()->share('pages',Page::orderBy('order','ASC')->get());
    }
    
    public function index(){
        $data['articles'] = Article::orderBy('created_at','DESC')->paginate(5);
        
        return view('front.homepage',$data);
    }
    public function single($category,$slug){
        $category = Category::where('slug',$category)->first() ?? abort(403,'Geçerli değil');
        $article = Article::where('slug',$slug)->where('category_id',$category->id)->first() ?? abort(403,'Geçerli değil.');
        $article->increment('hit');
        $data['article'] = $article;

        return view('front.single',$data);
    }
    public function category($category){
        $category = Category::where('slug',$category)->first() ?? abort(403);
        $data['category'] = $category;
        $data['articles'] = Article::where('category_id',$category->id)->orderBy('created_at','DESC')->paginate(5);

        return view('front.category',$data);
    }
    public function page($page){
        $data['page'] = Page::where('slug',$page)->first() ?? abort(404);
        return view('front.page',$data);
    }

    private function GetCategories(){
        return Category::inRandomOrder()->get();
    }
}
