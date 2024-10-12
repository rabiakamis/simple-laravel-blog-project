@extends('front.layouts.master')
@section('title','İletişim')
@section('bg','https://t4.ftcdn.net/jpg/03/37/96/33/360_F_337963325_EJuPjWslX3vAFxJ59L3y1cm6IsSfo07s.jpg')
@section('content')

<div class="col-md-8">
    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
    <p>Bizimle iletişime geçebilirsiniz.</p>
    <div class="my-5">
        <form method="post" action="{{route('contact.post')}}">
           @csrf
           <div class="form-group">
            <label for="name">Ad Soyad</label>
            <input class="form-control" name="name" type="text" placeholder="Ad Soyadınız" required/>
        </div>
        
        <div class="form-group">
            <label for="email">Email Adresi</label>
            <input class="form-control" name="email" type="email" placeholder="Email Adresiniz" required/>
        </div>
        
        <div class="form-group">
            <label for="topic">Konu</label>
            <select class="form-control" name="topic" required>
                <option value="">Bir Konu Seçiniz</option> <!-- Boş seçenek ekledim -->
                <option>Bilgi</option>
                <option>Destek</option>
                <option>Genel</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="message">Mesajınız</label>
            <textarea class="form-control" name="message" placeholder="Mesajınız" style="height: 12rem" required></textarea>
        </div>
        

            <br />
            <button class="btn btn-primary text-uppercase" type="submit">Gönder</button>
        </form>
    </div>
</div>
<div class="col-md-4">
    <div class="card card-default">
        <div class="card-body">Panel Content</div>
          Adres:bla bla bla
    </div>

</div>

@endsection
