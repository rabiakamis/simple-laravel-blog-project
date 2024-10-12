<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles=Article::orderBy('created_at','ASC')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Başlık zorunludur.',
            'title.min' => 'Başlık en az 3 harfli olmalıdır.',
            'image.required' => 'Resim yüklenmesi zorunludur.',
            'image.mimes' => 'Resim dosyası yalnızca jpeg, png veya jpg formatında olmalıdır.',
            'image.max' => 'Resim dosyası en fazla 2MB olmalıdır.',
        ]);
        

         $article=new Article;
         $article->title=$request->title;
         $article->category_id=$request->category;
         $article->content=$request->content;
         $article->slug =Str::slug($request->title);
         
         if($request->hasFile('image')){
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image='uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Makale başarıyla oluşturuldu!');
        return redirect()->route('admin.makaleler.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article=Article::findOrFail($id);
        
        $categories=Category::all();
        return view('back.articles.update',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|min:3|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Başlık zorunludur.',
            'title.min' => 'Başlık en az 3 harfli olmalıdır.',
            'image.required' => 'Resim yüklenmesi zorunludur.',
            'image.mimes' => 'Resim dosyası yalnızca jpeg, png veya jpg formatında olmalıdır.',
            'image.max' => 'Resim dosyası en fazla 2MB olmalıdır.',
        ]);
        

         $article=Article::findOrFail($id);
         $article->title=$request->title;
         $article->category_id=$request->category;
         $article->content=$request->content;
         $article->slug =Str::slug($request->title);
         
         if($request->hasFile('image')){
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image='uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Makale başarıyla güncellendi!');
        return redirect()->route('admin.makaleler.index');

    }

    public function switch(Request $request){
        $article=Article::findOrFail($request->id);
        $article->status=$request->statu=="true" ? 1 : 0;
        $article->save();
    }

    /**
     * Remove the specified resource from storage.
     */


     public function delete( string $id)
     {
        Article::find($id)->delete();
        toastr()->success('Makale, Silinen makalelere taşındı.!');
        return redirect()->route('admin.makaleler.index');

     } 

     public function trashed(){
        $articles=Article::onlyTrashed()->orderBy('deleted_at','desc')->get();
        return view('back.articles.trashed',compact('articles'));
     } 

     public function recover($id){
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Makale başarıyla geri yüklendi!');
        return redirect()->route('admin.makaleler.index');
     }


     public function hardDelete( string $id)
     {
        Article::onlyTrashed()->find($id)->forceDelete();
        toastr()->success('Makale başarıyla silindi!');
        return redirect()->route('admin.makaleler.index');

     } 

    public function destroy(string $id)
    {
        return $id;
    }
}
