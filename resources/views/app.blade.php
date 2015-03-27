<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Kundendatenbank</title>

	<link href="{{asset('/css/app.css')}}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<nav class="navbar navbar-default navbar-static-top well well-sm" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('index') }}">Projektname</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            @if (Auth::check())

                <ul class="nav navbar-nav">
                    <li><a href="{{ route('index') }}"> <i class="fa fa-btn fa-home"></i> Startseite </a></li>
                </ul>

                <ul class="nav navbar-nav navbar-left">

                </ul>


                <ul class="nav navbar-nav navbar-right">

                    @if(hasResource('acl.allRoles') || hasResource('acl.allResources') || hasResource('user.all') ||
                        hasResource('acl.role') || hasResource('acl.resource') || hasResource('user.create'))
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administration<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                @if(hasResource('acl.allRoles') || hasResource('acl.allResources') || hasResource('user.all'))
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Übersicht</a>
                                        <ul class="dropdown-menu">
                                            @if(hasResource('acl.allRoles'))
                                                <li><a href="{{ route('acl.allRoles') }}" ><i class="fa fa-btn fa-list"></i> Rollen </a></li>
                                            @endif
                                            @if(hasResource('acl.allResources'))
                                                <li><a href="{{ route('acl.allResources') }}" ><i class="fa fa-btn fa-list"></i> Rechte </a></li>
                                            @endif
                                            @if(hasResource('user.all'))
                                                <li><a href="{{ route('user.all') }}" ><i class="fa fa-btn fa-list"></i> User </a></li>
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                                @if(hasResource('acl.role') || hasResource('acl.resource') || hasResource('user.create'))
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Anlegen</a>
                                        <ul class="dropdown-menu">
                                            @if(hasResource('acl.role'))
                                                <li><a href="{{ route('acl.role') }}" ><i class="fa fa-btn fa-plus"></i> Rolle </a></li>
                                            @endif
                                            @if(hasResource('acl.resource'))
                                                <li><a href="{{ route('acl.resource') }}" ><i class="fa fa-btn fa-plus"></i> Recht </a></li>
                                            @endif
                                            @if(hasResource('user.create'))
                                                <li><a href="{{ route('user.create') }}" ><i class="fa fa-btn fa-plus"></i> User </a></li>
                                            @endif
                                        </ul>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="https://www.gravatar.com/avatar/{{{ md5(strtolower(Auth::user()->email)) }}}?s=35" height="35" width="35" class="navbar-avatar">
                            {{ Auth::user()->name }} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('auth.logout') }}"><i class="fa fa-btn fa-sign-out"></i> Abmelden</a></li>
                        </ul>
                    </li>
                </ul>

            @else
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('auth.login') }}"><i class="fa fa-btn fa-sign-in"></i>Anmelden</a></li>
                </ul>
            @endif
        </div>
    </div>
</nav>

@yield('content')

<footer class="container-fluid text-center">
    <p>&copy; </p>
</footer>
<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
