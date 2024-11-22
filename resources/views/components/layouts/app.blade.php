@php use Illuminate\Support\Facades\Auth; @endphp
@php
    if (Auth::check()) {
        $videos = \App\Models\Video::where('id_usuario', Auth::id())->get();
    }
@endphp
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transcrição de Audio com IA</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">
</head>
<body class="sidebar-mini layout-fixed" style="height: auto;">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a class="brand-link text-center">
            <img src="{{asset('logo_prado.png')}}" alt="AdminLTE Logo"
                 class="img-circle elevation-2" style="opacity: .8; height: 128px; width: 128px; object-fit: fill">
        </a>

        <!-- Sidebar -->
        <div
            class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
            <div class="os-padding">
                <div class="os-viewport os-viewport-native-scrollbars-invisible"
                     style="overflow-y: scroll; overflow: hidden">
                    <div class="os-content os-viewport-native-scrollbars-invisible" style="">
                        <!-- Sidebar user (optional) -->
                        @if(auth()->check())
                            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="image">
                                    <img src="{{asset('AdminLTE/dist/img/user2-160x160.jpg')}}"
                                         class="img-circle elevation-2" alt="User Image">
                                </div>
                                    <div class="info">
                                        <a class="d-block">{{ Auth::user()->name ?: 'Convidado' }}</a>
                                </div>
                            </div>
                        @endif

                        <!-- Sidebar Menu -->
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                data-accordion="false">
                                @if(Auth::check())
                                    <li class="nav-item">
                                        <a href="{{ route('transcrever-link') }}" class="nav-link">Transcrição por link do Youtube</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('transcrever-audio') }}" class="nav-link">Transcrição de arquivo de áudio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('logout') }}" class="nav-link">Sair</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{  route('cadastro') }}" class="nav-link">Cadastro</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                                    </li>
                                @endif
                            </ul>
                            @if(auth()->check())
                                <nav class="mt-5">
                                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                        data-accordion="false">
                                        <li class="nav-item text-center text-white">
                                            <h4>Histórico</h4>
                                        </li>
                                        @foreach( $videos as $video )
                                            <li class="nav-item">
                                                <a href="{{ route('historico', ['id' => $video->id]) }}" class="nav-link">{{ $video->created_at }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            @endif
                        </nav>
                        <!-- /.sidebar-menu -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1201px;">
        <!-- Main content -->
        <section class="content d-flex align-items-center justify-content-center" style="min-height: 95vh !important;">
            <div class="container-fluid" style="min-height: auto !important;">
                {{ $slot }}
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <div id="sidebar-overlay"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<x-layout.scripts/>
</body>
</html>
