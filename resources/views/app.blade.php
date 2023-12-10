<!DOCTYPE html>
<html class="js" lang="fr">
<meta content="text/html;charset=utf-8" http-equiv="content-type">

<head>
    <meta charset="utf-8">
    <meta content="Softnio" name="author">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers." name="description">
    <link href="images/logo.png" rel="shortcut icon">
    <title>@yield('titre')</title>
    <link href="assets/css/dashlite0226.css?" rel="stylesheet">
    <link href="assets/css/theme0226.css" rel="stylesheet">
    <script src="{{asset('chart.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('pusher.min.js') }}"></script>
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
                        <div class="nk-menu-trigger me-sm-2 d-lg-none">
                            <a class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav" href="#">
                                <em class="icon ni ni-menu"></em>
                            </a>
                        </div>
                        <div class="nk-header-brand">
                            <a class="logo-link" href="{{ route('index_accueil') }}">
                                <img alt="logo-dark" class="logo-dark logo-img" src="images/logo.png"
                                    srcset="/images/logo.png 2x">
                                </img>
                            </a>
                        </div>
                        <div class="nk-header-menu ms-auto" data-content="headerNav">
                            <div class="nk-header-mobile">
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
                            </div>
                            <ul class="nk-menu nk-menu-main ui-s2">
                                <!--<li >
                                    <a class="nk-menu-link" href="{{ route('index_accueil') }}">
                                        <span class="nk-menu-text">
                                            Accueil
                                        </span>
                                    </a>
                                </li>-->
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-toggle btn " >
                                        <em class="ni ni-building me-2"></em>
                                        <span class="nk-menu-text text-dark">
                                            Administration
                                        </span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_add_resva') }}">
                                                <em class="icon ni ni-user-add me-1"></em>
                                                <span class="nk-menu-text ">
                                                    Nouveau utilisateur
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" data-bs-toggle="modal" data-bs-target="#modalPoste" >
                                                <em class="ni ni-reports-alt me-1"></em>
                                                <span class="nk-menu-text ">
                                                    Nouveau poste
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_liste_poste') }}" >
                                                <em class="ni ni-list me-1"></em>
                                                <span class="nk-menu-text ">
                                                    Liste des postes
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_stat') }}">
                                                <em class="ni ni-bar-chart-alt me-1"></em>
                                                <span class="nk-menu-text ">
                                                    Statistique
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nk-menu-link" href="{{ route('index_historique') }}">
                                                <em class="icon ni ni-property me-1"></em>
                                                <span class="nk-menu-text " >
                                                    Historique
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-toggle btn " >
                                        <em class="ni ni-share-alt me-2"></em>
                                        <span class="nk-menu-text text-dark">
                                            Processus
                                        </span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_add_processus') }}">
                                                <em class="icon ni ni-property-add me-1"></em>
                                                <span class="nk-menu-text ">
                                                    Nouveau processus
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_listeprocessus') }}">
                                                <em class="ni ni-list-index me-1"></em>
                                                <span class="nk-menu-text ">
                                                    Liste des processus
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_evaluation') }}">
                                                <em class="icon ni ni-view-list-sq me-1"></em>
                                                <span class="nk-menu-text ">
                                                    Tableau d'évaluation
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-toggle btn " >
                                        <em class="ni ni-hot-fill me-2"></em>
                                        <span class="nk-menu-text text-dark">
                                            Risques
                                        </span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_add_processuseva') }}">
                                                <em class="icon ni ni-property-add me-1"></em>
                                                <span class="nk-menu-text">
                                                    Nouveau risque
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_liste_risque') }}">
                                                <em class="ni ni-list-index me-1"></em>
                                                <span class="nk-menu-text">
                                                    Liste des risque
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_validation_processus') }}">
                                                <em class="icon ni ni-view-list-sq me-1"></em>
                                                <span class="nk-menu-text">
                                                    Tableau de validation
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_risque_actionup') }}">
                                                <em class="ni ni-box-view-fill me-1"></em>
                                                <span class="nk-menu-text">
                                                    Risque non validé
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-toggle btn " >
                                        <em class="ni ni-box-view-fill me-2"></em>
                                        <span class="nk-menu-text text-dark">
                                            Actions
                                        </span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item has-sub">
                                            <a class="nk-menu-link nk-menu-toggle" href="#">
                                                <span class="nk-menu-text">
                                                    Action Préventive
                                                </span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item">
                                                    <a class="nk-menu-link" href="{{ route('index_suiviaction') }}">
                                                        <em class="icon ni ni-view-list-sq me-1"></em>
                                                        <span class="nk-menu-text">
                                                            Tableau de suivi
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nk-menu-item">
                                                    <a class="nk-menu-link" href="{{ route('index_ap') }}">
                                                        <em class="ni ni-list-index me-1"></em>
                                                        <span class="nk-menu-text">
                                                            Liste des actions
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nk-menu-item has-sub">
                                            <a class="nk-menu-link nk-menu-toggle" href="#">
                                                <span class="nk-menu-text">
                                                    Action Corrective
                                                </span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item">
                                                    <a class="nk-menu-link" href="{{ route('index_suiviactionc') }}">
                                                        <em class="icon ni ni-view-list-sq me-1"></em>
                                                        <span class="nk-menu-text">
                                                            Tableau de suivi
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nk-menu-item">
                                                    <a class="nk-menu-link" href="{{ route('index_ac') }}">
                                                        <em class="ni ni-list-index me-1"></em>
                                                        <span class="nk-menu-text">
                                                            Liste des actions
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-toggle btn " >
                                        <em class="ni ni-share-alt me-2"></em>
                                        <span class="nk-menu-text text-dark">
                                            Amélioration
                                        </span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_amelioration') }}">
                                                <em class="icon ni ni-property-add me-1"></em>
                                                <span class="nk-menu-text ">
                                                    Fiche
                                                </span>
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nk-menu-link" href="{{ route('index_amelioration_liste') }}" >
                                                <em class="ni ni-list-index me-1"></em>
                                                <span class="nk-menu-text ">
                                                    Liste des améliorations
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!--<li class="nk-menu-item has-sub">
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
                                                <div class="user-status text-primary"> </div>
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
                                                <!--<li>
                                                    <a href="{{ route('index_accueil') }}">
                                                        <em class="icon ni ni-home"></em>
                                                        <span>
                                                            Accueil
                                                        </span>
                                                    </a>
                                                </li>-->
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

        <div class="modal fade zoom" tabindex="-1" id="modalPoste">
            <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nouveau Poste</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                    </div>
                    <div class="modal-body">
                        <form class="nk-block" id="processus-form" method="post" action="{{ route('index_add_poste_traitement') }}">
                            @csrf
                            <div class="row g-4 mb-4" id="poste-container">
                                <div class="col-lg-12">
                                    <div class="form-group text-center">
                                        <label class="form-label" for="poste">
                                            Poste(s)
                                        </label>
                                        <div class="form-control-wrap">
                                            <input placeholder="Saisie obligatoire" autocomplete="off" required type="text" class="form-control text-center poste" name="nom[]" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-gs">
                                <div class="col-lg-6">
                                    <div class="form-group text-center">
                                        <button type="button" class="btn btn-lg btn-primary btn-dim" id="ajouter-poste">
                                            <em class="ni ni-plus me-2"></em>
                                            <em>Ajouter</em>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-lg btn-success btn-dim">
                                            <em class="ni ni-check me-2"></em>
                                            <em>Enregistrer</em>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script>
            document.getElementById('ajouter-poste').addEventListener('click', function(event) {
                event.preventDefault();
                const container = document.getElementById('poste-container');
                const div = document.createElement('div');
                div.classList.add('col-lg-12');
                div.innerHTML = `
                <div class="row g-g2" >
                    <div class=" col-md-12 form-group">
                        <div class="form-control-wrap">
                            <input placeholder="Saisie obligatoire" autocomplete="off" required type="text" class="form-control text-center objectif me-2" name="nom[]" oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class=" col-md-12 form-group text-center">
                        <div class="form-control-wrap">
                            <button type="button" class="btn btn-danger btn-dim text-center btn-remove-poste">
                                <em class="ni ni-trash me-2"></em>
                                <em>Supprimer</em>
                            </button>
                        </div>
                    </div>
                </div>
                `;
                container.appendChild(div);

                // Ajouter un écouteur d'événement pour supprimer l'objectif
                div.querySelector('.btn-remove-poste').addEventListener('click', function() {
                    container.removeChild(div);
                });
            });
        </script>

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

</body>
<!-- Mirrored from dashlite.net/demo8/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Mar 2023 15:17:24 GMT -->

</html>
