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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    
                    <div class="nk-block-head">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">ID <strong class="text-primary small me-1">5</strong></h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="list-inline">
                                        <li>Date de création : <span class="text-base">{{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="javascript:void(0);" onclick="history.back();" class="btn btn-danger btn-dim d-none d-sm-inline-flex">
                                    <em class="icon ni ni-arrow-left"></em>
                                    <span>Retour</span>
                                </a>
                                <a href="javascript:void(0);" onclick="history.back();" class="btn btn-danger btn-dim d-inline-flex d-sm-none">
                                    <em class="icon ni ni-arrow-left"></em>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="nk-block">
                        <div class="invoice">
                            <div class="invoice-action">
                                <button class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" id="btn_download">
                                    <em class="icon ni ni-printer-fill"></em>
                                </button>
                            </div>
                            <div class="invoice-wrap" id="cadre">
                                <div class="invoice-brand text-center">
                                    <img src="images/logo.png" srcset="/demo8/images/logo-dark2x.png 2x" alt="">
                                </div>
                                <div class="invoice-brand text-center">
                                    <h3 class="nk-block-title page-title">Fiche d'amélioration </h3>
                                </div>

                                <div class="invoice-head">
                                    <div class="row g-gs">
                                        <div class="col-md-12 col-xxl-12" id="groupesContainer">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="row g-4">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Type
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="Contentieux" readonly type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Date
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="date" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Lieu
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Détecteur
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="detecteur }}" readonly type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Non-conformité
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    Conséquences
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    Causes
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="invoice-bills">
                                    <div class="row g-gs">
                                        <div class="col-md-12 col-xxl-122" id="groupesContainer">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="card-head">
                                                        <h5 class="card-title">
                                                            Action Corrective 1
                                                        </h5>
                                                    </div>
                                                    <div class="row g-4">
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Processus
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    risque
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Action
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Délai
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Date de realisation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Date du Suivi
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <div class="form-control-wrap">
                                                                    <input value="Action Réaliser" readonly type="text" class="form-control text-center bg-success" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <div class="form-control-wrap">
                                                                    <input value="Action Non Réaliser" readonly type="text" class="form-control text-center bg-danger" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    Commentaire
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="invoice-bills">
                                    <div class="row g-gs">
                                        <div class="col-md-12 col-xxl-122" id="groupesContainer">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="card-head">
                                                        <h5 class="card-title">
                                                            Action Corrective 2
                                                        </h5>
                                                    </div>
                                                    <div class="row g-4">
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Processus
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    risque
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Action
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Délai
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Date de realisation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Date du Suivi
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <div class="form-control-wrap">
                                                                    <input value="Action Réaliser" readonly type="text" class="form-control text-center bg-success" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <div class="form-control-wrap">
                                                                    <input value="Action Non Réaliser" readonly type="text" class="form-control text-center bg-danger" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    Commentaire
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea"></textarea>
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
    </div>

    <script>
        document.getElementById('btn_download').addEventListener('click', function() {
            // Sélection du formulaire à imprimer
            const form = document.getElementById('cadre');

            // Configuration pour la génération PDF
            const opt = {
                margin: 10,
                filename: 'mon_formulaire.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all'] }, // Gestion des sauts de page
                header: [
                    {
                        content: '<div style="text-align: center;">Mon Header</div>',
                        height: '50mm'
                    }
                ],
                footer: [
                    {
                        content: '<div style="text-align: center;">Page {page}/{total} </div>',
                        height: '50mm'
                    }
                ],
            };

            // Génération du PDF à partir du formulaire
            html2pdf().from(form).set(opt).save();
        });

    </script>


@endsection

