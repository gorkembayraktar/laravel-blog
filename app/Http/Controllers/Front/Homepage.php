<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Models
use App\Models\Article;
use App\Models\Category;

class Homepage extends Controller
{

    public function index(){
        $data['articles'] = Article::orderBy('created_at','DESC')->get();
        $data['categories'] = Category::inRandomOrder()->get();
        return view('front.homepage',$data);
    }
    public function single($category,$slug){
        $category = Category::where('slug',$category)->first() ?? abort(403,'Geçerli değil');
        $article = Article::where('slug',$slug)->where('category_id',$category->id)->first() ?? abort(403,'Geçerli değil.');
        $article->increment('hit');
        $data['article'] = $article;
        $data['categories'] = Category::inRandomOrder()->get();
        return view('front.single',$data);
    }
}
