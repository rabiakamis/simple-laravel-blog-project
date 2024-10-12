<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function index(){
        $pages=Page::orderBy('order', 'ASC')->get();
        return view('back.pages.index',compact('pages'));
    }
    
    public function orders(Request $request) {
      // 'siralama' adında gelen dizi verisini döngü ile işliyoruz
      foreach ($request->get('siralama') as $key => $order) {
          // 'page_' kısmını id'den kaldırıp doğru id'yi güncelliyoruz
          Page::where('id', str_replace('page_', '', $order))->update(['order' => $key]);
      }
      return response()->json(['success' => true]);
  }
  
  
  
  


    public function create(){
        return view('back.pages.create');
      }
      

    public function update($id){
        $page=Page::findOrFail($id);
        return view('back.pages.update',compact('page'));
      }

    
      public function updatePost(Request $request, $id)
    {
      $request->validate([
        'title'=>'min:3',
        'image'=>'image|mimes:jpeg,png,jpg|max:2048'
      ]);

      $page= Page::findOrFail($id);
      $page->title=$request->title;
      $page->content=$request->content;
      $page->slug=Str::slug($request->title);

      if($request->hasFile('image')){
        $imageName=Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('uploads'),$imageName);
        $page->image='uploads/'.$imageName;
      }
      $page->save();
      toastr()->success('Sayfa başarıyla güncellendi.');
      return redirect()->route('admin.page.index');
    }

    public function delete($id){
      $page = Page::findOrFail($id);  // find yerine findOrFail kullanın
      if(File::exists(public_path($page->image))){
        File::delete(public_path($page->image));
      }
      $page->delete();
      toastr()->success('Sayfa başarıyla silindi');
      return redirect()->route('admin.page.index');
   }
    

    public function post(Request $request){
        $request->validate([
          'title'=>'min:3',
          'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
  
        $last=Page::orderBy('order','desc')->first();
        $page= new Page;
        $page->title=$request->title;
        $page->content=$request->content;
        $page->order=$last->order+1;
        $page->slug=Str::slug($request->title);
  
        if($request->hasFile('image')){
          $imageName=Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
          $request->image->move(public_path('uploads'),$imageName);
          $page->image='uploads/'.$imageName;
        }
        $page->save();
        toastr()->success('Sayfa başarıyla oluşturuldu');
        return redirect()->route('admin.page.index');
      }  

    public function switch(Request $request){
        $page=Page::findOrFail($request->id);
        $page->status=$request->statu=="true" ? 1 : 0 ;
        $page->save();
      }
}
