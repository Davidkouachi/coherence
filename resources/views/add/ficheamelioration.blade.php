@extends('app')

@section('titre', 'Nouveau Processus')

@section('menu')
<li class="nk-menu-item ">
                                    <!--<a id="ajouterGroupe" class=" btn btn-sm btn-warning " href="#">
                                        <span class="nk-menu-text">
                                            Ajouter une cause
                                        </span>
                                    </a>
                                </li>
                                <li class="nk-menu-item ">
                                    <a id="ajouterAction" class=" btn btn-sm btn-warning " href="#">
                                        <span class="nk-menu-text">
                                            Ajouter une action
                                        </span>
                                    </a>
                                </li>-->
@endsection

@section('content')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <!--<div class="nk-block-head nk-block-head-sm" >
                                            <div class="nk-block-between">
                                                <div class="nk-block-head-content">
                                                    <h3 class="nk-block-title page-title">

                                                    </h3>
                                                </div>
                                                <div class="nk-block-head-content">
                                                    <div class="toggle-wrap nk-block-tools-toggle">
                                                        <a class="btn btn-icon btn-trigger toggle-expand me-n1"
                                                            data-target="pageMenu" href="#">
                                                            <em class="icon ni ni-more-v"></em>
                                                        </a>
                                                        <div class="toggle-expand-content" data-content="pageMenu">
                                                            <ul class="nk-block-tools g-3">
                                                                <li>
                                                                    <a class="btn btn-white btn-dim btn-outline-primary" href="#">
                                                                        <em class="icon ni ni-reports"></em>
                                                                        <span>
                                                                            Reports
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                    <form class="nk-block" method="post" action="{{ route('add_prc') }}">
                        @csrf
                        <div class="row g-gs">
                            <div class="col-md-12 col-xxl-4" id="groupesContainer">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                            <div class="row g-4">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Date
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input type="date" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="controle">
                                                            Lieu
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="controle">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="controle">
                                                            Détecteur
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="controle">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xxl-4" id="groupesContainer">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Non conformité
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input id="inputMots" type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Conséquence(s)
                                                        </label>
                                                        <div class="form-control-wrap" id="resultat">
                                                            <textarea name="description" class="form-control no-resize" id="default-textarea"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xxl-4" id="groupesContainer">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Cause(s)
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <textarea name="description" class="form-control no-resize" id="default-textarea"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Resumé des cause(s)
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Resumé des risque(s)
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xxl-6" id="groupesContainer">
                                <div class="card card-bordered">
                                    <div class="card-inner text-center">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select class="form-select js-select2 " id="causeSelect" data-search="on" data-placeholder="Recherche Cause">
                                                                <option value="" >

                                                                </option>
                                                                @foreach($causes_selects as $causes_select)
                                                                <option value="{{$causes_select->id}}" >
                                                                    {{$causes_select->nom}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xxl-6" id="groupesContainer">
                                <div class="card card-bordered">
                                    <div class="card-inner text-center">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select class="form-select js-select2" id="risqueSelect" data-search="on" data-placeholder="Recherche Risque">
                                                                <option value="">
                                                                    
                                                                </option>
                                                                @foreach($risques as $risque)
                                                                <option value="{{$risque->id}}">
                                                                    {{$risque->nom}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xxl-4">
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner row g-gs" id="modalContent">
                                        <div class="col-12">
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-lg btn-success btn-dim ">
                                                    <em class="ni ni-check me-2"></em>
                                                    <em>Soumettre</em>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach($risques as $risque)
    <div class="modal fade" id="modalVurisque{{$risque->id}}" tabindex="-1" aria-labelledby="modalVuLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Détails</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em
                                class="icon ni ni-cross"></em></a>
                    </div>
                    <div class="modal-body modal-body-lg">
                        <form class="nk-block" >
                            <div class="row g-gs">
                                <div class="col-md-12 col-xxl-4" id="groupesContainer">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Processus
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $risque->nom_processus }}" disabled type="text" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="controle">
                                                                Risque
                                                                @if ($risque->statut === 'soumis')
                                                                    <span class="text-danger"> ( Non validé )</span>
                                                                @endif
                                                                @if ($risque->statut === 'valider')
                                                                    <span class="text-success"> ( Validé )</span>
                                                                @endif
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $risque->nom }}" disabled type="text" class="form-control" id="controle">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 row g-2" style="margin-left:1px;">
                                    <div class="col-md-12">
                                        <div class="card card-bordered h-100 
                                        @php
                                            if ($risque->evaluation <= 10) {
                                                echo 'bg-success border-white';
                                            } elseif ($risque->evaluation > 10 && $risque->evaluation < 20) {
                                                echo 'bg-warning border-white';
                                            } elseif ($risque->evaluation >= 20 && $risque->evaluation <= 25) {
                                                echo 'bg-danger border-white';
                                        } @endphp">
                                            <div class="card-inner">
                                                <div class="card-head">
                                                    <h5 class="card-title">Evaluation risque inhérent</h5>
                                                </div>
                                                <form action="#">
                                                    <div class="row g-4">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Vraisemblence
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->vraisemblence }}" disabled type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    gravite
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->gravite }}" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Evaluation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->evaluation }}" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Coût
                                                                </label>
                                                                @php
                                                                    $cout = $risque->cout;
                                                                    $formatcommande = number_format($cout, 0, '.', '.');
                                                                @endphp
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $formatcommande }} Fcfa" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($causesData[$caus2->risque_id] as $causesDatas)
                                <div class="col-md-12 col-xxl-4" id="groupesContainer">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Cause
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $causesDatas['cause'] }}" disabled type="text" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="controle">
                                                                Dispositif de Contrôle
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $causesDatas['dispositif'] }}" disabled type="text" class="form-control" id="controle">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-md-12 row g-2" style="margin-left:1px;">
                                    <div class="col-md-12">
                                        <div class="card card-bordered h-100 
                                        @php
                                            if ($risque->evaluation_residuel <= 10) {
                                                echo 'bg-success border-white';
                                            } elseif ($risque->evaluation_residuel > 10 && $risque->evaluation_residuel < 20) {
                                                echo 'bg-warning border-white';
                                            } elseif ($risque->evaluation_residuel >= 20 && $risque->evaluation_residuel <= 25) {
                                                echo 'bg-danger border-white';
                                        } @endphp
                                        " >
                                            <div class="card-inner">
                                                <div class="card-head">
                                                    <h5 class="card-title">Evaluation risque résiduel</h5>
                                                </div>
                                                <form action="#">
                                                    <div class="row g-4">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Vraisemblence
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->vraisemblence_residuel }}" disabled type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    gravite
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->gravite_residuel }}" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Evaluation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->evaluation_residuel }}" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Coût
                                                                </label>
                                                                @php
                                                                    $cout2 = $risque->cout_residuel;
                                                                    $formatcommande2 = number_format($cout2, 0, '.', '.');
                                                                @endphp
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $formatcommande2 }} Fcfa" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($actionsData[$Suivi_action2->risque_id] as $actionsDatas)
                                <div class="col-md-12 col-xxl-4" id="groupesAction">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="corectif">
                                                                Action corrective
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $actionsDatas['actionc'] }}" disabled type="text" class="form-control" id="corectif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="preventif">
                                                                Action préventive
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $actionsDatas['actionp'] }}" disabled type="text" class="form-control" id="preventif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="email-address-1">
                                                                Délai
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionsDatas['delai'] }}" disabled type="date" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="email-address-1">
                                                                Traitement
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionsDatas['traitement'] }}" disabled type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="email-address-1">
                                                                Responsabilité
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionsDatas['responsable'] }}" disabled type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="email-address-1">
                                                                Statut
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionsDatas['statut'] }}" disabled type="text" class="form-control text-white text-center 
                                                                    @php
                                                                        if ($actionsDatas['statut'] ==='non-realiser') {
                                                                            echo 'bg-danger';
                                                                        } elseif ($actionsDatas['statut'] ==='realiser') {
                                                                            echo 'bg-success';
                                                                        }
                                                                    @endphp
                                                                    ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if ($actionsDatas['statut'] ==='realiser')

                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="email-address-1">
                                                                        Réaliser le 
                                                                    </label>
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input value="{{ $actionsDatas['date_action'] }}" disabled type="date" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="email-address-1">
                                                                        Suivi éffectué le 
                                                                    </label>
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input value="{{ $actionsDatas['date_suivi'] }}" disabled type="datetime" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="email-address-1">
                                                                        Efficacité 
                                                                    </label>
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input value="{{ $actionsDatas['efficacite'] }}" disabled type="text" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    @endif

                                                    

                                                </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-md-12 col-xxl-4">
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner row g-gs">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="email-address-1">
                                                        Validateur
                                                    </label>
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input value="{{$risque->validateur}}" disabled type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($causes_selects as $causes_select)
    <div class="modal fade" id="modalVucause{{$causes_select->id}}" tabindex="-1" aria-labelledby="modalVuLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Détails</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em
                                class="icon ni ni-cross"></em></a>
                    </div>
                    <div class="modal-body modal-body-lg">
                        <form class="nk-block" >
                            <div class="row g-gs">
                                <div class="col-md-12 col-xxl-4" id="groupesContainer">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Processus
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $causes_select->nom_processus }}" disabled type="text" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="controle">
                                                                Risque
                                                                @if ($causes_select->statut === 'soumis')
                                                                    <span class="text-danger"> ( Non validé )</span>
                                                                @endif
                                                                @if ($causes_select->statut === 'valider')
                                                                    <span class="text-success"> ( Validé )</span>
                                                                @endif
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $causes_select->nom_risque }}" disabled type="text" class="form-control" id="controle">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 row g-2" style="margin-left:1px;">
                                    <div class="col-md-12">
                                        <div class="card card-bordered h-100 
                                        @php
                                            if ($causes_select->evaluation <= 10) {
                                                echo 'bg-success border-white';
                                            } elseif ($causes_select->evaluation > 10 && $causes_select->evaluation < 20) {
                                                echo 'bg-warning border-white';
                                            } elseif ($causes_select->evaluation >= 20 && $causes_select->evaluation <= 25) {
                                                echo 'bg-danger border-white';
                                        } @endphp">
                                            <div class="card-inner">
                                                <div class="card-head">
                                                    <h5 class="card-title">Evaluation risque inhérent</h5>
                                                </div>
                                                <form action="#">
                                                    <div class="row g-4">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Vraisemblence
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $causes_select->vraisemblence }}" disabled type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    gravite
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $causes_select->gravite }}" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Evaluation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $causes_select->evaluation }}" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Coût
                                                                </label>
                                                                @php
                                                                    $cout2 = $causes_select->cout;
                                                                    $formatcommande2 = number_format($cout2, 0, '.', '.');
                                                                @endphp
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $formatcommande2 }} Fcfa" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($causesData2[$causes_select->risque_id] as $causeData2)
                                        <div class="col-md-12 col-xxl-4" id="groupesContainer">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="row g-4">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Cause
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $causeData2['cause'] }}" disabled type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Dispositif de Contrôle
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $causeData2['dispositif'] }}" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                                <div class="col-md-12 row g-2" style="margin-left:1px;">
                                    <div class="col-md-12">
                                        <div class="card card-bordered h-100 
                                        @php
                                            if ($causes_select->evaluation_residuel <= 10) {
                                                echo 'bg-success border-white';
                                            } elseif ($causes_select->evaluation_residuel > 10 && $causes_select->evaluation_residuel < 20) {
                                                echo 'bg-warning border-white';
                                            } elseif ($causes_select->evaluation_residuel >= 20 && $causes_select->evaluation_residuel <= 25) {
                                                echo 'bg-danger border-white';
                                        } @endphp
                                        " >
                                            <div class="card-inner">
                                                <div class="card-head">
                                                    <h5 class="card-title">Evaluation risque résiduel</h5>
                                                </div>
                                                <form action="#">
                                                    <div class="row g-4">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Vraisemblence
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $causes_select->vraisemblence_residuel }}" disabled type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    gravite
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $causes_select->gravite_residuel }}" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Evaluation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $causes_select->evaluation_residuel }}" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Coût
                                                                </label>
                                                                @php
                                                                    $cout2 = $causes_select->cout_residuel;
                                                                    $formatcommande2 = number_format($cout2, 0, '.', '.');
                                                                @endphp
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $formatcommande2 }} Fcfa" disabled type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($actionsData2[$causes_select->risque_id] as $actionData2)
                                <div class="col-md-12 col-xxl-4" id="groupesAction">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="corectif">
                                                                Action corrective
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $actionData2['actionc'] }}" disabled type="text" class="form-control" id="corectif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="preventif">
                                                                Action préventive
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $actionData2['actionp'] }}" disabled type="text" class="form-control" id="preventif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="email-address-1">
                                                                Délai
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionData2['delai'] }}" disabled type="date" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="email-address-1">
                                                                Traitement
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionData2['traitement'] }}" disabled type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="email-address-1">
                                                                Responsabilité
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionData2['responsable'] }}" disabled type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="email-address-1">
                                                                Statut
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionData2['statut'] }}" disabled type="text" class="form-control text-white text-center 
                                                                    @php
                                                                        if ($actionData2['statut'] ==='non-realiser') {
                                                                            echo 'bg-danger';
                                                                        } elseif ($actionData2['statut'] ==='realiser') {
                                                                            echo 'bg-success';
                                                                        }
                                                                    @endphp
                                                                    ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if ($actionData2['statut'] ==='realiser')

                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="email-address-1">
                                                                        Réaliser le 
                                                                    </label>
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input value="{{ $actionData2['date_action'] }}" disabled type="date" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="email-address-1">
                                                                        Suivi éffectué le 
                                                                    </label>
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input value="{{ $actionData2['date_suivi'] }}" disabled type="datetime" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="email-address-1">
                                                                        Efficacité 
                                                                    </label>
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input value="{{ $actionData2['efficacite'] }}" disabled type="text" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    @endif

                                                    

                                                </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-md-12 col-xxl-4">
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner row g-gs">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="email-address-1">
                                                        Validateur
                                                    </label>
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input value="{{$causes_select->validateur}}" disabled type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    @endforeach


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Écoutez l'événement de changement de l'élément select
            $('#risqueSelect').on('change', function() {
                // Récupérez la valeur sélectionnée
                var selectedValue = $(this).val();

                // Fermez tous les modals existants
                $('.modal').modal('hide');

                // Ouvrez le modal correspondant à la valeur sélectionnée
                $(`#modalVurisque${selectedValue}`).modal('show');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Écoutez l'événement de changement de l'élément select
            $('#causeSelect').on('change', function() {
                // Récupérez la valeur sélectionnée
                var selectedValu = $(this).val();

                // Fermez tous les modals existants
                $('.modal').modal('hide');

                // Ouvrez le modal correspondant à la valeur sélectionnée
                $(`#modalVucause${selectedValu}`).modal('show');
            });
        });
    </script>


@endsection
