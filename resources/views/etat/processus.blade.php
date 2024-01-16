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
                                    Numéro : <strong class="text-primary small">{{ $processu->id }}</strong>
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
                                <a href="{{ route('index_listeprocessus') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                    <em class="icon ni ni-arrow-left"></em>
                                    <span>Retour</span>
                                </a>
                                <a href="{{ route('index_listeprocessus') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                                    <em class="icon ni ni-arrow-left"></em>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="nk-block mt-3 col-lg-8 ms-auto me-auto"  >
                        <div class="bg-white">

                            <div class=" row g-gs" id="cadre" style="margin-top: -30px; ">

                                <div class="col-lg-12 col-xxl-12" style="margin-top: +2px;">
                                    <div class="card" style="background: transparent;">
                                        <div class="card-inner text-center">
                                            <img src="images/logo.png" height="100" width="120">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-xxl-12" style="margin-top: -40px;">
                                    <div class="card" style="background: transparent;">
                                        <div class="card-inner text-center">
                                            <h5 class="text-dark">Fiche Processus </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-xxl-12" style="margin-top: -20px;">
                                    <div class="card" style="background: transparent; ">
                                        <div class="card-inner">
                                            <div class="gy-3">
                                                <div class="row g-1 align-center">
                                                    <div class="col-lg-12 row">
                                                        <div class="col-lg-3">
                                                            <div class="form-group ">
                                                                <label class="form-label" style="font-size: 14px;">
                                                                    Processus :
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="form-group ">
                                                                <span class="fw-normal text-dark" style="font-size: 14px;">
                                                                    {{ $processu->nom }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 row">
                                                        <div class="col-lg-3" >
                                                            <div class="form-group ">
                                                                <label class="form-label" style="font-size: 14px;">
                                                                    Finalité :
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="form-group ">
                                                                <span class="fw-normal text-dark" style="font-size: 14px;">
                                                                    {{ $processu->finalite }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @foreach ($objectifData[$processu->id] as $key => $objectifDat)
                                                    <div class="col-lg-12 row">
                                                        <div class="col-lg-3" >
                                                            <div class="form-group ">
                                                                <label class="form-label" style="font-size: 14px;">
                                                                    Objectif {{$key+1}} :
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="form-group ">
                                                                <span class="fw-normal text-dark" style="font-size: 14px;">
                                                                    {{ $objectifDat['objectif'] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="col-lg-12 row">
                                                        <div class="col-lg-3" >
                                                            <div class="form-group ">
                                                                <label class="form-label" style="font-size: 14px;">
                                                                    Description :
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="form-group ">
                                                                <span class="fw-normal text-dark" style="font-size: 14px;">
                                                                    {{ $processu->description }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                const pdf = html2pdf().from(form).set(opt).save();
            });
        };
    </script>


@endsection

