<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//Models
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Contact;

class Homepage extends Controller
{

    public function __construct(){
        view()->share('categories',Category::inRandomOrder()->get());
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
    public function contact(){
        return view('front.contact');
    }
    public function contactpost(Request $request){

        $rules = [
            "name"=>'required|min:5',
            "email"=>'required|email',
            "topic"=>'required',
            "message"=>'required|min:5'
        ];

        $validate = Validator::make($request->post(),$rules);

        if($validate->errors()){
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }


        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->topic = $request->topic;
        $contact->message = $request->message;
        $contact->save();
        return redirect()->route('contact')->with('success','Mesajınız bize iletildi.');

    }

   
}
