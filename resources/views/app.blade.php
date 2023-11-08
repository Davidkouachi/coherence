<!DOCTYPE html>
<html class="js" lang="fr">
<meta content="text/html;charset=utf-8" http-equiv="content-type">

<head>
    <meta charset="utf-8">
    <meta content="Softnio" name="author">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers."
        name="description">
    <link href="images/logo.png" rel="shortcut icon">
    <title>@yield('titre')</title>
    <link href="assets/css/dashlite0226.css?" rel="stylesheet">
    <link href="assets/css/theme0226.css" rel="stylesheet">
    </link>
    </link>
    </link>
    </meta>
    </meta>
    </meta>
    </meta>
</head>

<body class="nk-body bg-lighter ">
    <div class="nk-app-root">
        <div class="nk-wrap ">
            <div class="nk-header is-light nk-header-fixed">
                <div class="container-fluid">
                    <div class="nk-header-wrap">
                        <!--<div class="nk-menu-trigger me-sm-2 d-lg-none">
                            <a class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav" href="#">
                                <em class="icon ni ni-menu"></em>
                            </a>
                        </div>-->
                        <div class="nk-header-brand">
                            <a class="logo-link" href="{{ route('index_accueil') }}">
                                <img alt="logo-dark" class="logo-dark logo-img" src="images/logo.png"
                                    srcset="/images/logo.png 2x">
                                </img>
                            </a>
                        </div>
                        <div class="nk-header-menu ms-auto" data-content="headerNav">
                            <!--<div class="nk-header-mobile">
                                <div class="nk-header-brand">
                                    <a class="logo-link" href="index-2.html">
                                        <img alt="logo-dark" class="logo-dark logo-img" src="images/logo.png"
                                            srcset="/images/logo.png 2x">
                                        </img>
                                        <span><B>COHÉRENCE</B></span>
                                    </a>
                                </div>
                                <div class="nk-menu-trigger me-n2">
                                    <a class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav" href="#">
                                        <em class="icon ni ni-arrow-left"></em>
                                    </a>
                                </div>
                            </div>-->
                            <ul class="nk-menu nk-menu-main ui-s2">
                                <!--<li >
                                    <a class="nk-menu-link" href="{{ route('index_accueil') }}">
                                        <span class="nk-menu-text">
                                            Accueil
                                        </span>
                                    </a>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">
                                            Nouvelle Enregistrement
                                        </span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_add_processus') }}">
                                                <span class="nk-menu-text">
                                                    Fiche Processus
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_add_processuseva') }}">
                                                <span class="nk-menu-text">
                                                    Fiche Risque
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_amelioration') }}">
                                                <span class="nk-menu-text">
                                                    Fiche d'amélioration
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">
                                            Tableau
                                        </span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_validation_processus') }}">
                                                <span class="nk-menu-text">
                                                    Validation
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_suiviaction') }}">
                                                <span class="nk-menu-text">
                                                    Suivi des actions
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_evaluation') }}">
                                                <span class="nk-menu-text">
                                                    Evaluation Processus
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>-->
                                @yield('menu')
                            </ul>
                        </div>
                        <div class="nk-header-tools">
                            <ul class="nk-quick-nav">
                                @yield('option_btn')
                                @if (Auth::check())
                                <li class="dropdown user-dropdown">
                                    <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                        <div class="user-toggle">
                                            <div class="user-avatar">
                                                <em class="icon ni ni-user-alt"></em>
                                            </div>
                                            <div class="user-info">
                                                <div class="user-status text-primary">{{ Auth::user()->poste }}</div>
                                                <div class="user-name dropdown-indicator">
                                                    {{ Auth::user()->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div
                                        class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1 is-light">
                                        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                            <div class="user-card">
                                                <div class="user-avatar">
                                                    <span>
                                                        <em class="icon ni ni-user-alt"></em>
                                                    </span>
                                                </div>
                                                <div class="user-info">
                                                    <span class="lead-text">
                                                        {{ Auth::user()->name }}
                                                    </span>
                                                    <span class="sub-text">
                                                        {{ Auth::user()->email }}
                                                    </span>
                                                </div>
                                                <div class="user-action">
                                                    <a class="btn btn-icon me-n2" href="user-profile-setting.html">
                                                        <em class="icon ni ni-setting"></em>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li>
                                                    <a href="{{ route('index_accueil') }}">
                                                        <em class="icon ni ni-home"></em>
                                                        <span>
                                                            Accueil
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('index_profil') }}">
                                                        <em class="icon ni ni-user-alt"></em>
                                                        <span>
                                                            Voir Profil
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('index_historique_profil')}}">
                                                        <em class="icon ni ni-activity-alt"></em>
                                                        <span>
                                                            Activité
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li>
                                                    <a href="{{ route('logout') }}">
                                                        <em class="icon ni ni-signout"></em>
                                                        <span>
                                                            Se déconnecter
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')

            <div class="nk-footer bg-white">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright">
                            © 2023 Cohérence.
                            <img height="30" width="30" src="/images/logo.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="modal fade" tabindex="-1" id="modalAlert2" aria-modal="true" style="position: fixed;" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body modal-body-lg text-center">
                        <div class="nk-modal">
                            <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                            <h4 class="nk-modal-title">Session Expiré!</h4>
                            <div class="nk-modal-action mt-5">
                                <a href="{{ route('logout') }}" class="btn btn-lg btn-mw btn-light">
                                    ok
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<script>
            let idleTimer;
            const idleTime = 60000; 

            function resetIdleTimer() {
                clearTimeout(idleTimer);
                idleTimer = setTimeout(showLogoutModal, idleTime);
            }

            function showLogoutModal() {
                $('#modalAlert2').modal('show');
            }

            document.addEventListener('mousemove', resetIdleTimer);
            document.addEventListener('keypress', resetIdleTimer);
        </script>-->

    <script src="{{asset('assets/js/bundle0226.js')}}"></script>
    <script src="{{asset('assets/js/scripts0226.js')}}"></script>
    <script src="{{asset('assets/js/demo-settings0226.js')}}"></script>
    <script src="{{asset('assets/js/libs/datatable-btns0226.js')}}"></script>

    <link href="{{asset('notification/toastr.min.css')}}" rel="stylesheet">
    <script src="{{asset('notification/toastr.min.js')}}"></script>

    @if (session('ajouter'))
        <script>
            toastr.success("{{ session('ajouter') }}"," ",
            {positionClass:"toast-top-left",timeOut:5e3,debug:!1,newestOnTop:!0,
            preventDuplicates:!0,showDuration:"300",hideDuration:"1000",extendedTimeOut:"1000",
            showEasing:"swing",showMethod:"fadeIn",hideMethod:"fadeOut"})
        </script>
        {{ session()->forget('ajouter') }}
    @endif
    @if (session('valider'))
        <script>
            toastr.success("{{ session('valider') }}"," ",
            {positionClass:"toast-top-left",timeOut:5e3,debug:!1,newestOnTop:!0,
            preventDuplicates:!0,showDuration:"300",hideDuration:"1000",extendedTimeOut:"1000",
            showEasing:"swing",showMethod:"fadeIn",hideMethod:"fadeOut"})
        </script>
        {{ session()->forget('valider') }}
    @endif
    @if (session('rejet'))
        <script>
            toastr.success("{{ session('rejet') }}"," ",
            {positionClass:"toast-top-left",timeOut:5e3,debug:!1,newestOnTop:!0,
            preventDuplicates:!0,showDuration:"300",hideDuration:"1000",extendedTimeOut:"1000",
            showEasing:"swing",showMethod:"fadeIn",hideMethod:"fadeOut"})
        </script>
        {{ session()->forget('rejet') }}
    @endif

</body>
<!-- Mirrored from dashlite.net/demo8/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Mar 2023 15:17:24 GMT -->

</html>
