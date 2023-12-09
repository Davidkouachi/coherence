@extends('app')

@section('titre', 'Modification')

@section('option_btn')
    <li class="dropdown chats-dropdown">
        <a href="{{ route('index_accueil') }}" class="dropdown-toggle nk-quick-nav-icon">
            <div class="icon-status icon-status-na">
                <em class="icon ni ni-home"></em>
            </div>
        </a>
    </li>
    <li class="dropdown user-dropdown">
        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#">
            <div class="user-toggle">
                <div class="user-avatar">
                    <em class="icon ni ni-plus"></em>
                </div>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1 is-light">
            <div class="dropdown-inner">
                <ul class="link-list">
                    <li class="mt-2" >
                        <a id="ajouterGroupe" class="btn btn-md btn-primary text-white" >
                            <em class="icon ni ni-plus"></em>
                            <span>
                                Cause
                            </span>
                        </a>
                    </li>
                    <li class="mt-2" >
                        <a id="ajouterActionpr" class="btn btn-md btn-primary text-white">
                            <em class="icon ni ni-plus"></em>
                            <span>
                                Action Préventive
                            </span>
                        </a>
                    </li>
                    <li class="mt-2" >
                        <a id="ajouterActionco" class="btn btn-md btn-primary text-white">
                            <em class="icon ni ni-plus"></em>
                            <span>
                                Action corrective
                            </span>
                        </a>
                    </li>
                    <li class="mt-2" >
                        <a data-bs-toggle="modal" data-bs-target="#modalDetail" class="btn btn-md btn-primary text-white">
                            <em class="icon ni ni-file"></em>
                            <span>
                                Voir le Ficher PDF
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </li>

@endsection

@section('content')

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                                    <div class="nk-block-head-content" style="margin:0px auto;">
                                        <h3 class="text-center">
                                            <span>Mise à jour</span>
                                            <em class="icon ni ni-edit "></em>
                                        </h3>
                                    </div>
                                </div>
                </div>
                <form class="nk-block" method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-gs">
                        <div class="col-md-4 col-xxl-4 row g-2" style="margin-left:1px;">
                            <div class="form-group col-md-12">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <span id="fileSize"> </span>
                                        <div class="card " id="pdfPreview" style="height: 500px; " data-simplebar>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12" style="margin-top: -10px">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div class="form-group">
                                            <label class="form-label" for="cf-full-name">
                                                Fichier ( .pdf )
                                            </label>
                                            <input autocomplete="off" id="fileInput" name="pdfFile" accept=".pdf" type="file" class="form-control" id="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-xxl-8 row g-2" style="margin-left:5px;">
                            <div class="col-md-12 ">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div>
                                            <div class="row g-gs">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Récommandation
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <textarea disabled name="description" class="form-control no-resize" id="default-textarea">{{ $risque->motif }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div>
                                            <div class="row g-gs">
                                                <div class=" form-group col-md-12">
                                                    <label class="form-label" for="cf-full-name">Processus</label>
                                                    <input value="{{ $risque->nom_processus }}" readonly type="text" class="form-control">
                                                </div>
                                                <div class=" form-group col-md-12">
                                                    <label class="form-label" for="cf-full-name">Risque</label>
                                                    <input value="{{ $risque->nom }}" readonly type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row g-2" style="margin-left:1px;">
                                    <div class="col-md-12">
                                        <div class="card card-bordered h-100 border-white" id="divToChange">
                                            <div class="card-inner">
                                                <div class="card-head">
                                                    <h5 class="card-title">
                                                        Evaluation risque sans dispositif de contrôle interne ou dispositif antérieur
                                                    </h5>
                                                </div>
                                                <form action="#">
                                                    <div class="row g-4">
                                                        <div class="col-lg-4 text-center">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Vraisemblence
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <select required name="vrai" class="form-select " id="select1">
                                                                        <option value="1" {{ strval($risque->vraisemblence) === '1' ? 'selected' : '' }} >
                                                                            1
                                                                        </option>
                                                                        <option value="2" {{ strval($risque->vraisemblence) === '2' ? 'selected' : '' }} >
                                                                            2
                                                                        </option>
                                                                        <option value="3" {{ strval($risque->vraisemblence) === '3' ? 'selected' : '' }} >
                                                                            3
                                                                        </option>
                                                                        <option value="4" {{ strval($risque->vraisemblence) === '4' ? 'selected' : '' }} >
                                                                            4
                                                                        </option>
                                                                        <option value="5" {{ strval($risque->vraisemblence) === '5' ? 'selected' : '' }} >
                                                                            5
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    gravite
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <select required name="gravite" class="form-select" id="select2">
                                                                        <option value="1" {{ strval($risque->gravite) === '1' ? 'selected' : '' }} >
                                                                            1
                                                                        </option>
                                                                        <option value="2" {{ strval($risque->gravite) === '2' ? 'selected' : '' }} >
                                                                            2
                                                                        </option>
                                                                        <option value="3" {{ strval($risque->gravite) === '3' ? 'selected' : '' }} >
                                                                            3
                                                                        </option>
                                                                        <option value="4" {{ strval($risque->gravite) === '4' ? 'selected' : '' }} >
                                                                            4
                                                                        </option>
                                                                        <option value="5" {{ strval($risque->gravite) === '5' ? 'selected' : '' }} >
                                                                            5
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    Evaluation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->evaluation }}" readonly type="text" class="form-control text-center" id="result">
                                                                </div>
                                                                <script>
                                                                    document.addEventListener("DOMContentLoaded", function() {
                                                                        var evaluationValue = parseInt("{{ $risque->evaluation }}");
                                                                        var divToChange = document.getElementById("divToChange");

                                                                        if (evaluationValue > 16) {
                                                                            divToChange.style.backgroundColor = "#ea6072";
                                                                        } else if (evaluationValue >= 10 && evaluationValue <= 16) {
                                                                            divToChange.style.backgroundColor = "#f2b171";
                                                                        } else if (evaluationValue >= 3 && evaluationValue <= 9) {
                                                                            divToChange.style.backgroundColor = "#f7f880";
                                                                        } else if (evaluationValue >= 1 && evaluationValue <= 2) {
                                                                            divToChange.style.backgroundColor = "#5eccbf";
                                                                        }
                                                                    });
                                                                </script>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label " for="controle">
                                                                    Coût
                                                                </label>
                                                                <div class="form-control-wrap ">
                                                                    <input value="{{ $risque->cout }}" type="text" class="form-control text-center" id="cout">
                                                                </div>
                                                                <script>
                                                                var inputElement = document.getElementById('cout');
                                                                    inputElement.addEventListener('input', function() {
                                                                        this.value = this.value.replace(/[^0-9]/g, '');
                                                                    });
                                                            </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @foreach ($causesData[$risque->id] as $key => $causesDatas)
                                <div class="col-md-12 col-xxl-12" id="groupesContainer">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Cause {{ $key+1 }}
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{$causesDatas['cause_id']}}" autocomplete="off" name="cause_id[]" type="text" style="display: none;">
                                                            <input placeholder="Saisie Obligatoire" value="{{$causesDatas['cause']}}" autocomplete="off" id="nom_cause" required name="nom_cause[]" type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="controle">
                                                            Dispositif de Contrôle
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{$causesDatas['dispositif']}}" placeholder="Saisie Obligatoire" autocomplete="off" id="dispositif" required name="dispositif[]" type="text" class="form-control" id="controle">
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
                                        <div class="card card-bordered h-100 border-white" id="divToChangee">
                                            <div class="card-inner">
                                                <div class="card-head">
                                                    <h5 class="card-title">
                                                        Evaluation risque avec dispositif de contrôle interne actuel
                                                    </h5>
                                                </div>
                                                <form action="#">
                                                    <div class="row g-4">
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Vraisemblence
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <select required name="vrai_residuel" class="form-select " id="select11">
                                                                        <option value="1" {{ strval($risque->vraisemblence_residuel) === '1' ? 'selected' : '' }} >
                                                                            1
                                                                        </option>
                                                                        <option value="2" {{ strval($risque->vraisemblence_residuel) === '2' ? 'selected' : '' }} >
                                                                            2
                                                                        </option>
                                                                        <option value="3" {{ strval($risque->vraisemblence_residuel) === '3' ? 'selected' : '' }} >
                                                                            3
                                                                        </option>
                                                                        <option value="4" {{ strval($risque->vraisemblence_residuel) === '4' ? 'selected' : '' }} >
                                                                            4
                                                                        </option>
                                                                        <option value="5" {{ strval($risque->vraisemblence_residuel) === '5' ? 'selected' : '' }} >
                                                                            5
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    gravite
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <select required name="gravite_residuel" class="form-select" id="select22">
                                                                        <option value="1" {{ strval($risque->gravite_residuel) === '1' ? 'selected' : '' }} >
                                                                            1
                                                                        </option>
                                                                        <option value="2" {{ strval($risque->gravite_residuel) === '2' ? 'selected' : '' }} >
                                                                            2
                                                                        </option>
                                                                        <option value="3" {{ strval($risque->gravite_residuel) === '3' ? 'selected' : '' }} >
                                                                            3
                                                                        </option>
                                                                        <option value="4" {{ strval($risque->gravite_residuel) === '4' ? 'selected' : '' }} >
                                                                            4
                                                                        </option>
                                                                        <option value="5" {{ strval($risque->gravite_residuel) === '5' ? 'selected' : '' }} >
                                                                            5
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    Evaluation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->evaluation_residuel }}" readonly type="text" class="form-control text-center" id="resultt">
                                                                </div>
                                                                <script>
                                                                    document.addEventListener("DOMContentLoaded", function() {
                                                                        var evaluation_residuel = parseInt("{{ $risque->evaluation_residuel }}");
                                                                        var divToChangee = document.getElementById("divToChangee");

                                                                        if (evaluation_residuel > 16) {
                                                                            divToChangee.style.backgroundColor = "#ea6072";
                                                                        } else if (evaluation_residuel >= 10 && evaluation_residuel <= 16) {
                                                                            divToChangee.style.backgroundColor = "#f2b171";
                                                                        } else if (evaluation_residuel >= 3 && evaluation_residuel <= 9) {
                                                                            divToChangee.style.backgroundColor = "#f7f880";
                                                                        } else if (evaluation_residuel >= 1 && evaluation_residuel <= 2) {
                                                                            divToChangee.style.backgroundColor = "#5eccbf";
                                                                        }
                                                                    });
                                                                </script>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    Coût
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->cout_residuel }}" type="text" class="form-control text-center" id="cout_residuel">
                                                                </div>
                                                                <script>
                                                                    var inputElement = document.getElementById('cout_residuel');
                                                                        inputElement.addEventListener('input', function() {
                                                                        this.value = this.value.replace(/[^0-9]/g, '');
                                                                    });
                                                                </script>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    Traitement
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <select required name="traitement" class="form-select">
                                                                        <option value="reduire le risque" {{ $risque->traitement === 'reduire le risque' ? 'selected' : '' }}>
                                                                            Réduire le risque
                                                                        </option>
                                                                        <option value="accepter le risque" {{ $risque->traitement === 'accepter le risque' ? 'selected' : '' }}>
                                                                            Accepter le risque
                                                                        </option>
                                                                        <option value="partager le risque" {{ $risque->traitement === 'partager le risque' ? 'selected' : '' }}>
                                                                            Partager le risque
                                                                        </option>
                                                                        <option value="eliminer le risque" {{ $risque->traitement === 'eliminer le risque' ? 'selected' : '' }}>
                                                                            Éliminer le risque
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @foreach ($actionsDatap[$risque->id] as $key => $actionsDatas)
                                <div class="col-md-12 col-xxl-12" id="groupesActionpr">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="preventif">
                                                            Action préventive {{ $key+1 }}
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{$actionsDatas['action_idp']}}" autocomplete="off" name="action_idp[]" type="text" style="display: none;">
                                                            <input id="actionp" value="{{ $actionsDatas['action'] }}" autocomplete="off" placeholder="Néant" name="actionp[]" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="email-address-1">
                                                            Délai
                                                        </label>
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input id="delai" value="{{ $actionsDatas['date_suivip'] }}" autocomplete="off" name="delai[]" type="date" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Responsabilité">
                                                            Responsabilité
                                                        </label>
                                                        <select id="responsable_idp" name="poste_idp[]" class="form-select">
                                                            <option value="">
                                                                Choisir un responsable
                                                            </option>
                                                            @foreach($postes as $poste)
                                                                <option value="{{ $poste->id }}" {{ $actionsDatas['poste_idp'] == $poste->id ? 'selected' : '' }}>
                                                                    {{ $poste->nom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                        @foreach ($actionsDatac[$risque->id] as $key => $actionsDatas)
                                <div class="col-md-12 col-xxl-12" id="groupesActionco">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="corectif">
                                                            Action corrective {{ $key+1 }}
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{$actionsDatas['action_idc']}}" autocomplete="off" name="action_idc[]" type="text" style="display: none;">
                                                            <input autocomplete="off" required placeholder="Néant" id="actionc" name="actionc[]" value="{{ $actionsDatas['action'] }}" type="text" class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Responsabilité">
                                                            Responsabilité
                                                        </label>
                                                        <select id="responsable_idc" required name="poste_idc[]" class="form-select">
                                                            <option selected value="">
                                                                Choisir un responsable
                                                            </option>
                                                            @foreach($postes as $poste)
                                                                <option value="{{ $poste->id }}" {{ $actionsDatas['poste_idc'] == $poste->id ? 'selected' : '' }}>
                                                                    {{ $poste->nom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                        <div class="col-md-12 col-xxl-12">
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner row g-gs">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="Responsabilité">
                                                        Validateur
                                                    </label>
                                                    <select required name="poste_id" class="form-select">
                                                        <option value="">
                                                            Choisir le validateur
                                                        </option>
                                                        @foreach($postes as $poste)
                                                                <option value="{{ $poste->id }}" {{ $risque->poste_id == $poste->id ? 'selected' : '' }}>
                                                                    {{ $poste->nom }}
                                                                </option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <div class="col-md-12 col-xxl-12">
                            <div class="card card-preview">
                                <div class="card-inner row g-gs">
                                    <div class="col-12">
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-lg btn-info btn-dim ">
                                                        <em class="ni ni-edit me-2"></em>
                                                        <em>Mise à jour</em>
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

<div class="modal fade zoom" tabindex="-1" id="modalDetail">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="pdfPreviewmodal" data-simplebar>
            <p class="text-center mt-2"  >Aucun fichier sélectionner </p>
        </div>
    </div>
</div>

<script>
    // Sélectionnez les éléments
    const select1 = document.getElementById("select1");
    const select2 = document.getElementById("select2");
    const resultInput = document.getElementById("result");
    const divToChange = document.getElementById("divToChange");

    // Ajoutez des écouteurs d'événements aux sélecteurs
    select1.addEventListener("change", sum);
    select2.addEventListener("change", sum);

    // Fonction pour vérifier les valeurs et effectuer la multiplication
    function sum() {
        const num1 = parseInt(select1.value);
        const num2 = parseInt(select2.value);

        if (num1 > 0 && num2 > 0) {
            const multiplicationResult = num1 * num2;
            resultInput.value = multiplicationResult;
            if (multiplicationResult > 16) {
                divToChange.style.backgroundColor = "#ea6072";
            } else if (multiplicationResult >= 10 && multiplicationResult <= 16) {
                divToChange.style.backgroundColor = "#f2b171";
            } else if (multiplicationResult >= 3 && multiplicationResult <= 9) {
                divToChange.style.backgroundColor = "#f7f880";
            } else if (multiplicationResult >= 1 && multiplicationResult <= 2) {
                divToChange.style.backgroundColor = "#5eccbf";
            }

        } else {
            resultInput.value = "";
            divToChange.style.backgroundColor = "";
        }
    }
</script>

<script>
    // Sélectionnez les éléments
    const select11 = document.getElementById("select11");
    const select22 = document.getElementById("select22");
    const resultInputt = document.getElementById("resultt");
    const divToChangee = document.getElementById("divToChangee");

    // Ajoutez des écouteurs d'événements aux sélecteurs
    select11.addEventListener("change", sum);
    select22.addEventListener("change", sum);

    // Fonction pour vérifier les valeurs et effectuer la multiplication
    function sum() {
        const num11 = parseInt(select11.value);
        const num22 = parseInt(select22.value);

        if (num11 > 0 && num22 > 0) {
            const multiplicationResultt = num11 * num22;
            resultInputt.value = multiplicationResultt;
            if (multiplicationResultt > 16) {
                divToChangee.style.backgroundColor = "#ea6072";
            } else if (multiplicationResultt >= 10 && multiplicationResultt <= 16) {
                divToChangee.style.backgroundColor = "#f2b171";
            } else if (multiplicationResultt >= 3 && multiplicationResultt <= 9) {
                divToChangee.style.backgroundColor = "#f7f880";
            } else if (multiplicationResultt >= 1 && multiplicationResultt <= 2) {
                divToChangee.style.backgroundColor = "#5eccbf";
            }

        } else {
            resultInputt.value = "";
            divToChangee.style.backgroundColor = "";
        }
    }
</script>

<script>
    const selectProcessus = document.getElementById("selectProcessus");
    const listeObjectifs = document.getElementById("listeObjectifs");

    selectProcessus.addEventListener("change", function(event) {
        event.preventDefault();
        const processusId = selectProcessus.value;
        // Faites une requête Ajax vers le serveur Laravel pour récupérer les objectifs
        fetch(`/recherche/${processusId}`)
            .then(response => response.json())
            .then(data => {
                // Effacez la liste actuelle des objectifs
                listeObjectifs.innerHTML = "";
                // Ajoutez les nouveaux objectifs à la liste
                data.forEach(objectif => {
                    const li = document.createElement("li");
                    li.textContent = "- " + objectif.nom;
                    listeObjectifs.appendChild(li);
                });
            })
            .catch(error => console.error("Erreur :", error));
    });
</script>

<script>
    document.getElementById("ajouterGroupe").addEventListener("click", function(event) {
        event.preventDefault();

        const nom_cause = document.getElementById("nom_cause");
        const dispositif = document.getElementById("dispositif");

        if (nom_cause.value === '' || dispositif.value === '') {

            toastr.info("Veuillez saisir une cause.");

        } else {

            const groupe = document.createElement("div");
            groupe.className = "card card-bordered";
            groupe.innerHTML = `
                                            <div class="card-inner">
                                                    <div class="row g-4">
                                                        <div class="col-lg-7">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Cause
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input id="nom_cause" placeholder="Saisie obligatoire" autocomplete="off" required name="nom_cause[]" type="text" class="form-control" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <div class="form-group">
                                                                <label class="form-label" for="controle">
                                                                    Dispositif de Contrôle
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input id="dispositif" value="neant" placeholder="Saisie obligatoire" autocomplete="off" required name="dispositif[]" type="text" class="form-control" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group text-center">
                                                                <a class="btn btn-lg btn-danger btn-dim supprimerGroupe">
                                                                    <em class="ni ni-trash me-2"></em>
                                                                    <em>Supprimer</em>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                    `;

            groupe.querySelector(".supprimerGroupe").addEventListener("click", function(event) {
                event.preventDefault();
                groupe.remove();
            });

            document.getElementById("groupesContainer").appendChild(groupe);
        }
    });
</script>

<script>
    document.getElementById("ajouterActionpr").addEventListener("click", function(event) {
        event.preventDefault();

        const actionp = document.getElementById("actionp");
        const delai = document.getElementById("delai");
        const responsable_idp = document.getElementById("responsable_idp");

        if (actionp.value === '' || delai.value === '' || responsable_idp.value === '') {

            toastr.info("Veuillez saisir une action preventive.");

        } else {

            const groupe = document.createElement("div");
            groupe.className = "card card-bordered";
            groupe.innerHTML = `
                                            <div class="card-inner">
                                                    <div class="row g-4">
                                                        <div class="col-lg-7">
                                                            <div class="form-group">
                                                                <label class="form-label" for="preventif">
                                                                    Action préventive
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input placeholder="Saisie obligatoire" autocomplete="off" required name="actionp[]" type="text" class="form-control" id="preventif">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label class="form-label" for="email-address-1">
                                                                    Délai
                                                                </label>
                                                                <div class="form-group">
                                                                    <div class="form-control-wrap">
                                                                        <input autocomplete="off" required name="delai[]" type="date" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Responsabilité">
                                                                    Responsabilité
                                                                </label>
                                                                <select required name="poste_idp[]" class="form-select">
                                                                    <option value="">
                                                                        Choisir un responsable
                                                                    </option>
                                                                    @foreach ($postes as $poste)
                                                                    <option value="{{ $poste->id }}">
                                                                        {{ $poste->nom }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group text-center">
                                                                <a class="btn btn-lg btn-danger btn-dim supprimerActionpr">
                                                                    <em class="ni ni-trash me-2"></em>
                                                                    <em>Supprimer</em>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                    `;

            groupe.querySelector(".supprimerActionpr").addEventListener("click", function(event) {
                event.preventDefault();
                groupe.remove();
            });

            document.getElementById("groupesActionpr").appendChild(groupe);
        }
    });
</script>

<script>
    document.getElementById("ajouterActionco").addEventListener("click", function(event) {
        event.preventDefault();

        const actionc = document.getElementById("actionc");
        const responsable_idc = document.getElementById("responsable_idc");

        if (actionc.value === '' || responsable_idc.value === '') {

            toastr.info("Veuillez saisir une action corrective.");

        } else {

            const groupe = document.createElement("div");
            groupe.className = "card card-bordered";
            groupe.innerHTML = `
                                            <div class="card-inner">
                                                    <div class="row g-4">
                                                        <div class="col-lg-9">
                                                            <div class="form-group">
                                                                <label class="form-label" for="corectif">
                                                                    Action corrective
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input placeholder="Saisie obligatoire" autocomplete="off" required name="actionc[]" type="text" class="form-control" id="corectif">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Responsabilité">
                                                                    Responsabilité
                                                                </label>
                                                                <select required name="poste_idc[]" class="form-select">
                                                                    <option value="">
                                                                        Choisir un responsable
                                                                    </option>
                                                                    @foreach ($postes as $poste)
                                                                    <option value="{{ $poste->id }}">
                                                                        {{ $poste->nom }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group text-center">
                                                                <a class="btn btn-lg btn-danger btn-dim supprimerActionco">
                                                                    <em class="ni ni-trash me-2"></em>
                                                                    <em>Supprimer</em>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                    `;

            groupe.querySelector(".supprimerActionco").addEventListener("click", function(event) {
                event.preventDefault();
                groupe.remove();
            });

            document.getElementById("groupesActionco").appendChild(groupe);
        }
    });
</script>

<script>
    const fileInput = document.getElementById('fileInput');

    const pdfPreview = document.getElementById('pdfPreview');
    const fileSizeElement = document.getElementById('fileSize');

    const pdfPreviewmodal = document.getElementById('pdfPreviewmodal');
    const fileSizeElementmodal = document.getElementById('fileSizemodal');

    fileInput.addEventListener('change', function() {
        // Obtenez le fichier PDF sélectionné
        const fichier = fileInput.files[0];

        // Vérifiez si un fichier a été sélectionné
        if (fichier) {
            // Créez un élément d'incorporation pour le fichier PDF
            const embedElement = document.createElement('embed');
            embedElement.src = URL.createObjectURL(fichier);
            embedElement.type = 'application/pdf';
            embedElement.style.width = '100%';
            embedElement.style.height = '100%';
            // Affichez l'élément d'incorporation dans la div de prévisualisation
            pdfPreview.innerHTML = '';
            pdfPreview.appendChild(embedElement);
            // Affichez la taille du fichier
            const fileSize = fichier.size; // Taille du fichier en octets
            const fileSizeInKB = fileSize / 1024; // Taille du fichier en kilo-octets
            fileSizeElement.textContent = `Taille du fichier : ${fileSizeInKB.toFixed(2)} Ko`;


            const embedElementmodal = document.createElement('embed');
            embedElementmodal.src = URL.createObjectURL(fichier);
            embedElementmodal.type = 'application/pdf';
            embedElementmodal.style.width = '100%';
            embedElementmodal.style.height = '100%';
            // Affichez l'élément d'incorporation dans la div de prévisualisation
            pdfPreviewmodal.innerHTML = '';
            pdfPreviewmodal.appendChild(embedElementmodal);
            pdfPreviewmodal.style.height = '1000px';
            // Affichez la taille du fichier
            const fileSizemodal = fichier.size; // Taille du fichier en octets
            const fileSizemodalInKB = fileSizemodal / 1024; // Taille du fichier en kilo-octets
            fileSizeElementmodal.textContent = `Taille du fichier : ${fileSizemodalInKB.toFixed(2)} Ko`;
        } else {
            // Si aucun fichier n'est sélectionné, videz la div de prévisualisation et l'élément de la taille du fichier
            pdfPreview.innerHTML = '';
            fileSizeElement.textContent = '';

            pdfPreviewmodal.innerHTML = '';
            fileSizeElementmodal.textContent = '';
        }
    });

</script>


@endsection
