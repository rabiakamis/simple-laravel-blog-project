<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title') - {{$config->title}}</title>
         <link rel="icon" type="image/x-icon" href="{{ asset('front/assets/favicon.ico') }}" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('front/css/styles.css') }}" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="{{asset($config->favicon)}}"/>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
              <a class="navbar-brand" href="{{route('homepage')}}">
                @if($config->logo!=null)
                  <img src="{{asset($config->logo)}}" width="100" />
                @else
                  {{$config->title}}
                @endif
                </a>
              <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
              </button>
              <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('homepage')}}">Anasayfa</a>
                  </li>
                  @foreach($pages as $page)
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('page',$page->slug)}}">{{$page->title}}</a>
                    </li>
                  @endforeach
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('contact')}}">İletişim</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        <!-- Page Header-->
        <header class="masthead" style="background-image:url('@yield('bg', asset('front/assets/img/home-bg.jpg'))')">

            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>@yield('title')</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">