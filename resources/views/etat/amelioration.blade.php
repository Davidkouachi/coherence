@extends('app')

@section('titre', 'Etat')

@section('option_btn')

    <li class="dropdown chats-dropdown">
        <a href="{{ route('index_accueil') }}" class="dropdown-toggle nk-quick-nav-icon">
            <div class="icon-status icon-status-na">
                <em class="icon ni ni-home"></em>
            </div>
        </a>
    </li>

@endsection


@section('content')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    <div class="nk-block-head">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">
                                    Numéro : <strong class="text-primary small">{{ $am->id }}</strong>
                                </h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="list-inline">
                                        <li>
                                            Date de création :
                                            <span class="text-base">
                                                {{ \Carbon\Carbon::now()->translatedFormat('j F Y H:i') }}
                                            </span>
                                        </li>
                                        <li>
                                            <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" id="btn_download">
                                                <em class="icon ni ni-printer-fill"></em>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="{{ route('index_amelioration_liste') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                    <em class="icon ni ni-arrow-left"></em>
                                    <span>Retour</span>
                                </a>
                                <a href="{{ route('index_amelioration_liste') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                                    <em class="icon ni ni-arrow-left"></em>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="nk-block mt-3">
                        <div class="bg-white">

                            <div class="row g-gs" id="cadre" style="margin-top: -30px;">

                                <div class="col-md-12 col-xxl-12" style="margin-top: -1px;">
                                    <div class="card" style="background: transparent;">
                                        <div class="card-inner text-center">
                                            <img src="images/logo.png" height="100" width="120">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xxl-12" style="margin-top: -40px;">
                                    <div class="card" style="background: transparent;">
                                        <div class="card-inner text-center">
                                            <h3 class="text-dark">Fiche d'incident </h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xxl-12" style="margin-top: -30px;">
                                    <div class="card" style="background: transparent;">
                                        <div class="card-inner">
                                            <div class="gy-3">
                                                <div class="row g-3 align-center text-center">
                                                    @if( $am->date_cloture1 != null)
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="site-name">
                                                                    Statut :
                                                                </label>
                                                                <span class="form-note text-success fw-bold">
                                                                    Terminé
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="site-name">
                                                                    Date de réalisation :
                                                                </label>
                                                                <span class="form-note">
                                                                    {{ \Carbon\Carbon::parse($am->date_fiche)->translatedFormat('j F Y ') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        @if($am->statut === 'valider')
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="site-name">
                                                                        Statut :
                                                                    </label>
                                                                    <span class="form-note text-primary">
                                                                        Validé
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="site-name">
                                                                        Date de validation :
                                                                    </label>
                                                                    <span class="form-note">
                                                                        {{ \Carbon\Carbon::parse($am->date_fiche)->translatedFormat('j F Y ') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @elseif($am->statut === 'non-valider' || $am->statut === 'update' || $am->statut === 'modif')
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="site-name">
                                                                        Statut :
                                                                    </label>
                                                                    <span class="form-note text-danger">
                                                                        Non Validé
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @elseif($am->statut === 'soumis')
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="site-name">
                                                                        Statut :
                                                                    </label>
                                                                    <span class="form-note text-danger">
                                                                        En attente de validation
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xxl-12" style="margin-top: -20px;">
                                    <div class="card" style="background: transparent; ">
                                        <div class="card-inner">
                                            <div class="gy-3">
                                                <div class="row g-1 align-center"style="border: 1px solid black; border-radius: 10px; padding-left: 10px;">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Date de réception :
                                                            </label>
                                                            <span class="form-note">
                                                                {{ \Carbon\Carbon::parse($am->date_fiche)->translatedFormat('j F Y ') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Type :
                                                            </label>
                                                            <span class="form-note">
                                                                {{$am->type}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Lieux :
                                                            </label>
                                                            <span class="form-note">
                                                                {{$am->lieu}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Détecteur :
                                                            </label>
                                                            <span class="form-note">
                                                                {{$am->detecteur}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Non conformité :
                                                            </label>
                                                            <span class="form-note">
                                                                {{$am->non_conformite}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Conséquence(s) :
                                                            </label>
                                                            <span class="form-note">
                                                                {{$am->consequence}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Cause(s) :
                                                            </label>
                                                            <span class="form-note">
                                                                {{$am->cause}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @foreach($actionsData[$am->id] as $key => $actions)
                                <div style="page-break-inside: avoid; margin-top: -10px;" >
                                    <div class="col-md-12 col-xxl-12">
                                        <div class="card" style="background: transparent;">
                                            <div class="card-inner" >
                                                <div class="card-head">
                                                    <h5 class="card-title text-dark">
                                                        Action Corrective {{ $key+1 }}
                                                        @if($actions['date_action'] === null)
                                                            ( <em class="text-danger"> Non Réaliser </em> )
                                                        @else
                                                            ( <em class="text-success"> Réaliser </em> )
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="gy-3">
                                                    <div class="row g-1 align-center" style="border: 1px solid black; border-radius: 10px;padding-left: 10px;">
                                                        <div class="col-lg-4 ">
                                                            <div class="form-group">
                                                                <label class="form-label" for="site-name">
                                                                    Action :
                                                                </label>
                                                                <span class="form-note">
                                                                    {{ $actions['action'] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label class="form-label" for="site-name">
                                                                    Risque :
                                                                </label>
                                                                <span class="form-note">
                                                                    {{ $actions['risque'] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label class="form-label" for="site-name">
                                                                    Processus :
                                                                </label>
                                                                <span class="form-note">
                                                                    {{ $actions['processus'] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="site-name">
                                                                    Délai :
                                                                </label>
                                                                <span class="form-note">
                                                                    {{ \Carbon\Carbon::parse($actions['delai'])->translatedFormat('j F Y ') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        @if($actions['statut'] === 'realiser')
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="site-name">
                                                                        Date de réalisation :
                                                                    </label>
                                                                    @if($actions['delai'] >= $actions['date_action'])
                                                                        <span class="form-note text-success">
                                                                            {{ \Carbon\Carbon::parse($actions['date_action'])->translatedFormat('j F Y ') }}
                                                                        </span>
                                                                    @else
                                                                        <span class="form-note text-danger">
                                                                            {{ \Carbon\Carbon::parse($actions['date_action'])->translatedFormat('j F Y ') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="site-name">
                                                                        Date du suivi :
                                                                    </label>
                                                                    <span class="form-note">
                                                                        {{ \Carbon\Carbon::parse($actions['date_suivi'])->translatedFormat('j F Y H:i') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="site-name">
                                                                        Efficacitée :
                                                                    </label>
                                                                    @if($actions['efficacite'] === 'efficace')
                                                                        <span class="form-note text-success">
                                                                            Oui
                                                                        </span>
                                                                    @else
                                                                        <span class="form-note text-danger">
                                                                            Non
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="site-name">
                                                                        Commentaire :
                                                                    </label>
                                                                    <span class="form-note">
                                                                        {{ $actions['commentaire'] }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .form-label{
            color: black;
            font-size:17px;
        }
        .form-note{
            color: black;
            font-size:15px;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <script>
        window.onload = function() {
            document.getElementById('btn_download').addEventListener('click', function() {
                // Sélection du formulaire à imprimer
                const form = document.getElementById('cadre');

                // Configuration pour la génération PDF
                const opt = {
                    margin: 10,
                    filename: 'mon_formulaire.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }, // Gestion des sauts de page
                    header: [
                        {
                            content: 'Mon Header',
                            height: '50mm',
                            styles: {
                                textAlign: 'center',
                            },
                        }
                    ],
                    footer: [
                        {
                            content: 'Page {page}/{total}',
                            height: '50mm',
                            styles: {
                                textAlign: 'center',
                            },
                        }
                    ],
                };

                // Génération du PDF à partir du formulaire
                html2pdf().from(form).set(opt).save();
            });
        };
    </script>


@endsection

