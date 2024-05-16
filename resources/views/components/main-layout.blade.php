<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : 'Home' }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite($resources)
</head>
<body class="app">   	
    <header class="app-header fixed-top">	   	            
        <x-navbar></x-navbar>
        <x-sidebar></x-sidebar>
    </header>
    
	<div class="app-wrapper">
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
				{{$slot}}
			</div>
	    </div>
	    
	    <x-footer></x-footer>
	    
    </div>>
</body>
</html>
