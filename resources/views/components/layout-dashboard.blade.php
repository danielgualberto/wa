<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- 
    
Copyright By Daniel Gualberto, Donens Empreendimentos
Email : atendimento.donens@gmail.com / contato@donens.com.br
WhatsApp : 553192389614
------------------------------------------------------------------
Não compartilhe, venda ou compre este código-fonte sem permissão, chefe! Vamos ser abençoados... Rsrs
--}}

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{__('system.meta_description')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="keywords" content="{{__('system.meta_keywords')}}">
    <meta name="author" content="{{__('system.meta_author')}}">
    <meta name="color-scheme" content="dark light">
    <title>{{ $title }} | {{__('system.brand')}}{{__('system.brand_title')}}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/perfectscroll/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/pace/pace.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/highlight/styles/github-gist.css')}}" rel="stylesheet">
    <script src="{{asset('plugins/jquery/jquery-3.5.1.min.js')}}"></script>
    <link href="{{asset('css/main.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/avatars/avatar2.png')}}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/avatars/avatar.png')}}" />


</head>

<body>
 
<x-sidebar></x-sidebar>
{{ $slot }}


    <!-- Javascripts -->

<script src="{{asset('plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/perfectscroll/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('plugins/highlight/highlight.pack.js')}}"></script>
<script src="{{asset('plugins/blockUI/jquery.blockUI.min.js')}}"></script>
<script src="{{asset('js/main.min.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('js/pages/blockui.js')}}"></script>
<!-- LoopedIn -->
<script>var li_sidebar = { workspace_id : "f022bf3a-555b-45b7-b544-f61262020ac5" };</script>
<script type="text/javascript" src="https://cdn.loopedin.io/js/sidebar.min.js?v=0.1" defer="defer"></script>
</body>

</html>