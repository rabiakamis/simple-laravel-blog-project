<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


//Models
use App\Models\Article;
use App\Models\Category; 
use App\Models\Page;
use App\Models\Config;
use App\Models\Contact;
class Homepage extends Controller
{

    public function __construct()
    {
        if(Config::find(1)->active==0){
            return redirect()->to('site-bakimda')->send();
          }
        view()->share('pages',Page::where('status',1)->orderBy('order','ASC')->get());
        view()->share('categories',Category::where('status',1)->inRandomOrder()->get());
        view()->share('config',Config::find(1));

    }

    public function index(){
        $data['articles']= Article::with('getCategory')->where('status',1)->whereHas('getCategory',function($query){
            $query->where('status',1);
          })->orderBy('created_at','DESC')->paginate(10);
        $data['articles']->withPath(url('sayfa'));
        return view('front.homepage',$data);
    }
    public function single($category,$slug){
    $category=Category::whereSlug($category)->first() ?? abort(403,'Böyle bir yazı bulunamadı');
    $article=Article::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403,'Böyle bir yazı bulunamadı');
    $article->increment('hit');
    $data['article']=$article;
    return view('front.single',$data);
    }

    public function category($slug){
        $category=Category::whereSlug($slug)->first() ?? abort(403,'Böyle bir yazı bulunamadı');
        $data['category']=$category;
        $data['articles']=Article::where('category_id',$category->id)->orderBy('created_at','DESC')->paginate(1);
        return view('front.category',$data);
    }

    public function page($slug){
        $page=Page::whereSlug($slug)->first()  ?? abort(403,'Böyle bir yazı bulunamadı');
        $data['page']=$page;
        return view('front.page',$data);
    }

    public function contact(){
        return view('front.contact');
    }


    public function contactpost(Request $request)
{
    $rules = [
        'name' => 'required|min:5',
        'email' => 'required|email',
        'topic' => 'required',
        'message' => 'required|min:10'
    ];

    $request->validate($rules);

    try {
        Mail::send([], [], function ($message) use ($request) {
            $message->from('iletisim@blogsitesi.com', 'Blog Sitesi')
                    ->to('furkangurel@hotmail.com')
                    ->subject($request->name . ' iletişimden mesaj gönderdi!')
                    ->html('Mesajı Gönderen: ' . $request->name . '<br />
                             Mesajı Gönderen Mail: ' . $request->email . '<br />
                             Mesaj Konusu: ' . $request->topic . '<br />
                             Mesaj: ' . $request->message . '<br /><br />
                             Mesaj Gönderilme Tarihi: ' . now());
        });

        return redirect()->route('contact')->with('success', 'Mesajınız bize iletildi. Teşekkür ederiz!');
    } catch (\Exception $e) {
        return redirect()->route('contact')->with('error', 'Mesaj gönderme sırasında bir hata oluştu: ' . $e->getMessage());
    }
}



}
