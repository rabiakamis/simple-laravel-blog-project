<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
      return view('back.categories.index',compact('categories'));
    }

    public function create(Request $request){
        // Slug oluşturma için Str::slug kullanıyoruz
        $slug = Str::slug($request->category);
        
        $isExist = Category::whereSlug($slug)->first();
        if ($isExist) {
            toastr()->error($request->category . ' adında bir kategori zaten mevcut!');
            return redirect()->back();
        }

        $category = new Category;
        $category->name = $request->category;
        $category->slug = $slug; // Slug'ı atıyoruz
        $category->save();

        toastr()->success('Kategori Başarıyla Oluşturuldu');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        // Slug'ı ve kategori adını kontrol et
        $isSlug = Category::whereSlug(Str::slug($request->slug))->where('id', '!=', $request->id)->first();
        $isName = Category::where('name', $request->category)->where('id', '!=', $request->id)->first();

        // Eğer slug veya isim mevcutsa hata ver
        if ($isSlug || $isName) {
            toastr()->error($request->category . ' adında bir kategori zaten mevcut!');
            return redirect()->back();
        }

        // Kategoriyi güncelle
        $category = Category::find($request->id);
        $category->name = $request->category;
        $category->slug = Str::slug($request->slug); // Slug'ı güncelle
        $category->save();

        toastr()->success('Kategori Başarıyla Güncellendi');
        return redirect()->back();
    }

    public function delete(Request $request){
        $category = Category::findOrFail($request->id);
        
        // Kategori 1 ise hata mesajı göster
        if($category->id == 1){
            toastr()->error('Bu kategori silinemez.');
            return redirect()->back();
        }
    
        $message = '';
        $count = $category->articleCount();
        
        // Kategoriye ait makaleler varsa taşımak için güncelle
        if($count > 0){
            Article::where('category_id', $category->id)->update(['category_id' => 1]);
            $defaultCategory = Category::find(1);
            $message = 'Bu kategoriye ait '.$count.' makale '.$defaultCategory->name.' kategorisine taşındı.';
        }
    
        // Kategoriyi sil
        $category->delete();
    
        // Başarılı mesaj
        toastr()->success('Kategori Başarıyla Silindi');
    
        return redirect()->back();
    }
    


    public function getData(Request $request){
        $category=Category::findOrFail($request->id);
        return response()->json($category);
      }
  

    public function switch(Request $request){
        $category=Category::findOrFail($request->id);
        $category->status=$request->statu=="true" ? 1 : 0 ;
        $category->save();
      }
}
