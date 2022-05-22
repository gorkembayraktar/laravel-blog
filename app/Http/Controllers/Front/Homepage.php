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
use App\Models\Config;

use Mail;

class Homepage extends Controller
{

    public function __construct(Request $request){

        if(Config::find(1)->active == 0 ){
            return redirect()->to('site-bakimda')->send();
        }
        //** eğer sınıfan erişmek isteseydik 
        
        // && $request->segment(1) != 'site-bakimda'

        // ile kontrol etmemeiz gerekirdi

        
        // her classta paylaş
        view()->share('categories',Category::where('status',1)->inRandomOrder()->get());
        view()->share('pages',Page::orderBy('order','ASC')->where('status',1)->get());
        view()->share('config',Config::find(1));
    }

    public function index(){
        $data['articles'] = Article::with('getCategory')->whereHas(
            'getCategory',function($query){
                $query->where('status',1);
            }   
        )->orderBy('created_at','DESC')->where('status',1)->paginate(5);
        $data['articles']->withPath(url('sayfa'));
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
        $data['articles'] = Article::where('category_id',$category->id)->where('status',1)->orderBy('created_at','DESC')->paginate(5);

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
        if($validate->fails()){
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }

        Mail::send([],[],function($message) use($request){
            $message->from('iletisim@laravelblog.com','Blog Sitesi');
            $message->to('byrktr.grkm@gmail.com');
            $message->setBody(' Mesajı Gönderen : '.$request->name . " <br />
            Mesajı gönderen mail : $request->email <br />
            Mesaj konusu : $request->topic <br />
            Mesaj : $request->message <br /></br>
            Mesaj Gönderilme Tarihi : $request->created_at
",'text/html');
            $message->subject($request->name. 'İletişimden mesaj gönderdi!');
        });


        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->topic = $request->topic;
        $contact->message = $request->message;
        $contact->save();


        return redirect()->route('contact')->with('success','Mesajınız bize iletildi.');

    }

   
}
