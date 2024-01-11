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
                                    Numéro : <strong class="text-primary small">2</strong>
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
                                <a href="javascript:void(0);" onclick="history.back();" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                    <em class="icon ni ni-arrow-left"></em>
                                    <span>Retour</span>
                                </a>
                                <a href="javascript:void(0);" onclick="history.back();" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                                    <em class="icon ni ni-arrow-left"></em>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="nk-block mt-5">
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
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Date :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Type :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Lieux :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Détecteur :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Non conformité :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Conséquence(s) :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Cause(s) :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="page-break-inside: avoid;">
                                <div class="col-md-12 col-xxl-12">
                                    <div class="card" style="background: transparent;">
                                        <div class="card-inner">
                                            <div class="card-head">
                                                <h5 class="card-title">
                                                    Action Corrective
                                                </h5>
                                            </div>
                                            <div class="gy-3">
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Action :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Risque :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Processus :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Délai :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Date de réalisation :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Date du suivi :
                                                            </label>
                                                            <span class="form-note">
                                                                Specify the name of your website.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="site-name">
                                                                Statut :
                                                            </label>
                                                            <span class="form-note text-success">
                                                                Specify the name of your website.
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

