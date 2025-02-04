@extends('back.layouts.master')
@section('title','Tüm Sayfalar')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">@yield('title')
            <span class="float-right">{{$pages->count()}} sayfa bulundu.</strong>
             </h6>
    </div>
    <div class="card-body">
      <div id="orderSuccess" style="display:none;" class="alert alert-success">
        Sıralama başarıyla güncellendi.
      </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                       <th>Sıralama</th>
                        <th>Fotoğraf</th>
                        <th>Sayfa Başlığı</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody id="orders">
                    @foreach($pages as $page)
                    <tr id="page_{{$page->id}}">
                      <td class="text-center" style="width: 3%">
                        <i class="fa fa-arrows-alt-v fa-3x handle" style="cursor:move"></i>
                      </td>
                        <td>
                            <img src="{{asset($page->image)}}" width="200">
                        </td>
                        <td>{{$page->title}}</td>
                        <td>
                            <input class="switch" page-id="{{$page->id}}" type="checkbox" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" @if($page->status==1) checked
                            @endif data-toggle="toggle">
                        </td>
                        <td>
                            <a target="_blank" href="{{route('page', $page->slug)}}" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                            <a href="{{route('admin.page.edit', $page->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                            <a href="{{route('admin.page.delete', $page->id)}}" 
                                title="Sil" 
                                class="btn btn-sm btn-danger" 
                                onclick="return confirm('Bu sayfayı silmek istediğinizden emin misiniz?')">
                                <i class="fa fa-times"></i>
                             </a>
                             
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>
   $('#orders').sortable({
    handle: '.handle',
    update: function() {
        var siralama = $('#orders').sortable('toArray', { attribute: 'id' });
        $.get("{{ route('admin.page.orders') }}", { siralama: siralama }, function(data) {
            if (data.success) {
                $("#orderSuccess").show().delay(1000).fadeOut();
            } else {
                alert("Sıralama güncellenirken bir hata oluştu.");
            }
        });
    }
});



  </script>
  

<script>
    $(function() {
        $('.switch').change(function() {
            var id = $(this).attr('page-id');
            var statu = $(this).prop('checked') ? 'true' : 'false';
            $.get("{{ route('admin.page.switch') }}", { id: id, statu: statu }, function(data, status) {
                console.log(data);
            });
        });
    });
</script>
@endsection
