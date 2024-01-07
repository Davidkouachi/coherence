@extends('app')

@section('titre', 'Paramettrage')

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
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content" style="margin:0px auto;">
                            <h3 class="text-center">
                                <span>Paramettrage</span>
                                <em class="icon ni ni-opt-dot-alt"></em>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="nk-block ">
                    <div class="row g-gs">
                        <div class="col-lg-12 col-xxl-12">
                            <div class="card card-bordered card-full">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h5 class="title">
                                                Couleurs en fonction des intervalles
                                            </h5>
                                        </div>
                                        @if($color_para->nbre_color > $color_interval_nbre )
                                        <div class="card-tools">
                                            <ul>
                                                <li>
                                                    <a data-bs-toggle="modal" data-bs-target="#modalColor_interval_plus" href="#" class="btn btn-sm btn-success rounded">
                                                            <em class="icon ni ni-plus"></em>
                                                        </a>
                                                </li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group align-items-center justify-content-center">
                                        <div class="row g-4 mb-0" id="objectifs-container">
                                            <div class="col-lg-3">
                                                <div class="form-group text-center">
                                                    <label class="form-label" for="Cause">
                                                        De
                                                    </label>
                                                    <div class="form-control-wrap">
                                                        <input value="{{ $color_para->nbre1 }}" readonly type="text" class="form-control text-center">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group text-center">
                                                    <label class="form-label" for="Cause">
                                                        à
                                                    </label>
                                                    <div class="form-control-wrap">
                                                        <input value="{{ $color_para->nbre2 }}" readonly type="text" class="form-control text-center">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group text-center">
                                                    <label class="form-label" for="Cause">
                                                        Nombre de couleurs
                                                    </label>
                                                    <div class="form-control-wrap">
                                                        <input value="{{ $color_para->nbre_color }}" readonly type="text" class="form-control text-center">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group text-center">
                                                    <label class="form-label" for="Cause">
                                                        Opération
                                                    </label>
                                                    <div class="form-control-wrap d-flex">
                                                        <input value="{{ $color_para->operation }}" readonly type="text" class="form-control text-center me-2">
                                                        <a data-bs-toggle="modal" data-bs-target="#modalColor_para" href="#" class="btn btn-icon btn-white btn-dim btn-sm btn-info border border-1 border-white rounded">
                                                            <em class="icon ni ni-edit"></em>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($color_interval_nbre > 0)
                                                @if( $color_para->operation === 'addition' )
                                                    @if( $color_para->nbre2+$color_para->nbre2 != $color_interval_dernier->nbre2 )
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label">
                                                                    <em class="nk-modal-icon icon icon-circle icon-circle-md ni ni-alert bg-danger"></em>
                                                                    <em class="text-danger" >
                                                                        Paraméttrage non complet (le deuxiéme
                                                                        chiffre du dernier interval doit être : {{ intval($color_para->nbre2)+intval($color_para->nbre2) }} )
                                                                    </em>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @elseif( $color_para->operation === 'multiplication' )
                                                    @if( $color_para->nbre2*$color_para->nbre2 != $color_interval_dernier->nbre2 )
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label">
                                                                    <em class="nk-modal-icon icon icon-circle icon-circle-md ni ni-alert bg-danger"></em>
                                                                    <em class="text-danger" >
                                                                        Paraméttrage non complet (le deuxiéme chiffre du dernier interval doit être : {{ intval($color_para->nbre2)*intval($color_para->nbre2) }} )
                                                                    </em>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity" style="margin: 0 auto;">
                                    
                                    @if( $color_interval_nbre > 0 )
                                        @foreach($color_intervals as $key => $color_interval )
                                        <li class="nk-activity-item border-0">
                                            @if( $color_interval->color === 'vert' )
                                            <div class="nk-activity-media user-avatar" style="background-color: #5eccbf;">
                                                
                                            </div>
                                            @elseif( $color_interval->color === 'jaune' )
                                            <div class="nk-activity-media user-avatar" style="background-color: #f7f880;">
                                                
                                            </div>
                                            @elseif( $color_interval->color === 'orange' )
                                            <div class="nk-activity-media user-avatar" style="background-color: #f2b171;">
                                                
                                            </div>
                                            @elseif( $color_interval->color === 'rouge' )
                                            <div class="nk-activity-media user-avatar" style="background-color: #ea6072;">
                                                
                                            </div>
                                            @endif
                                            <div class="nk-activity-data" style="width: 100px;">
                                                <div class="label">
                                                    De {{ $color_interval->nbre1 }} à {{ $color_interval->nbre2 }}
                                                </div>
                                            </div>
                                            <div class="nk-activity-media">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalConfirme{{$color_interval->id}}" class="btn btn-icon btn-white btn-dim btn-sm btn-danger border border-1 border-white rounded">
                                                        <em class="icon ni ni-trash"></em>
                                                    </a>
                                            </div>
                                        </li>
                                        @endforeach
                                    @else
                                        <li class="nk-activity-item border-0">
                                            <div class="nk-activity-data" style="width: 200px;">
                                                <div class="label">
                                                    Aucun interval enregistré
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade zoom" tabindex="-1" id="modalColor_para">
    <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mise à jour</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="nk-block">
                    <form method="POST" action="{{ route('color_para_traitement') }}" class="row g-gs align-items-center justify-content-center">
                        @csrf
                        <div class="col-lg-12 col-xxl-12 ">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="row g-4 mb-4" id="objectifs-container">
                                        <div class="col-lg-2">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    De
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input name="nbre1" value="{{ $color_para->nbre1 }}" readonly type="number" class="form-control text-center">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    a
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select required name="nbre2" class="form-select text-center">
                                                        @for ($i = 2; $i <= 10; $i++) <option value="{{ $i }}" {{ $color_para->nbre2 == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                            </option>
                                                            @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    Nombre de couleur
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select required name="nbre_color" class="form-select text-center">
                                                        @for ($i = 2; $i <= 4; $i++) <option value="{{ $i }}" {{ $color_para->nbre_color == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                            </option>
                                                            @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    Opération
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select required name="operation" class="form-select text-center">
                                                        <option value="addition" {{ $color_para->operation == 'addition' ? 'selected' : '' }}>
                                                            Addition
                                                        </option>
                                                        <option value="multiplication" {{ $color_para->operation == 'multiplication' ? 'selected' : '' }}>
                                                            Multiplication
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-lg btn-primary btn-dim">
                                                    <em class="ni ni-check me-2"></em>
                                                    <em>Terminé</em>
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
</div>


<div class="modal fade zoom" tabindex="-1" id="modalColor_interval_plus">
    <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une Couleur</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="nk-block">
                    <form method="POST" action="{{ route('color_interval_add_traitement') }}" class="row g-gs align-items-center justify-content-center">
                        @csrf
                        <div class="col-lg-12 col-xxl-12 ">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="row g-4 mb-4" id="objectifs-container">
                                        <div class="col-lg-3">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    De
                                                </label>
                                                <div class="form-control-wrap">
                                                        @if( $color_interval_nbre >= 1 )
                                                            <input name="nbre1" value="{{ (intval($color_interval_dernier->nbre2) + 1) }}" readonly type="number" class="form-control text-center">
                                                        @else
                                                            <input name="nbre1" value="1" readonly type="number" class="form-control text-center">
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    a
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select required name="nbre2" class="form-select text-center">
                                                        @if( $color_interval_nbre > 0 )
                                                            @if( $color_para->operation === 'addition' )
                                                                @for ($i = (intval($color_interval_dernier->nbre2) + 2); $i <= (intval($color_para->nbre2) + intval($color_para->nbre2)); $i++)
                                                                    <option value="{{ $i }}">
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            @elseif( $color_para->operation === 'multiplication' )
                                                                @for ($i = (intval($color_interval_dernier->nbre2) + 2); $i <= (intval($color_para->nbre2) * intval($color_para->nbre2)); $i++)
                                                                    <option value="{{ $i }}">
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            @endif
                                                        @else
                                                            @if( $color_para->operation === 'addition' )
                                                                @for ($i = 2; $i <= (intval($color_para->nbre2) + intval($color_para->nbre2)); $i++)
                                                                    <option value="{{ $i }}">
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            @elseif( $color_para->operation === 'multiplication' )
                                                                @for ($i = 2; $i <= (intval($color_para->nbre2) * intval($color_para->nbre2)); $i++)
                                                                    <option value="{{ $i }}">
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            @endif
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group text-center">
                                                <label class="form-label" for="Cause">
                                                    Couleur
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select required name="color" class="form-select text-center">
                                                        <option value="" >
                                                            Choisir une couleur
                                                        </option>
                                                        <option value="vert" >
                                                            Vert
                                                        </option>
                                                        <option value="jaune" >
                                                            Jaune
                                                        </option>
                                                        <option value="orange" >
                                                            Orange
                                                        </option>
                                                        <option value="rouge" >
                                                            Rouge
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-lg btn-success btn-dim">
                                                    <em class="ni ni-check me-2"></em>
                                                    <em>Ajouter</em>
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
</div>

@foreach($color_intervals as $key => $color_interval )
<div class="modal fade" tabindex="-1" id="modalConfirme{{$color_interval->id}}" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross"></em></a>
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal"><em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title">Confirmation</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text">
                            <span>Voulez-vous vraiment supprimé cet interval ?</span>
                        </div>
                    </div>
                    <div class="nk-modal-action">
                        <a href="/Color_interval_delete_traitement/{{$color_interval->id}}" class="btn btn-lg btn-mw btn-success me-2">
                            oui
                        </a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" data-bs-dismiss="modal">
                            non
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach




<!--<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les éléments du DOM
        var nbreInput = document.getElementById('nbre');
        var nbreColorInput = document.getElementById('nbre_color');
        var colorPara = document.getElementById('color_para');
        var suivantButton =  document.getElementById('btn_suivant'); // Bouton suivant

        suivantButton.addEventListener('click', function(event) {

            if (nbreInput.value === '') {
                toastr.info("Sélectionné un nombre.");
                event.preventDefault();
                return;
            }else if (nbreColorInput.value === '') {
                toastr.info("Sélectionné le nombre de couleur.");
                event.preventDefault();
                return;
            }else if (operation.value === '') {
                toastr.info("Sélectionné une opération.");
                event.preventDefault();
                return;
            }

            var nbre = parseInt(nbreInput.value);
            var nbreColor = parseInt(nbreColorInput.value);

            document.getElementById('block').style.display = 'block';

            // Supprimer les blocs existants
            while (colorPara.firstChild) {
                colorPara.removeChild(colorPara.firstChild);
            }

            // Créer et afficher les nouveaux blocs
            for (var i = 0; i < nbreColor; i++) {

                var defaultValueInput = '';
                var readonly = '';
                if (i === nbreColor - 1) {
                    if (operation.value === 'addition') {
                        var defaultValueInput = nbre + nbre;
                        var readonly = 'readonly';
                    } else if (operation.value === 'multiplication') {
                        var defaultValueInput = nbre * nbre;
                        var readonly = 'readonly';
                    }
                }

                var defaultValueInput1 = '';
                if (i + 1 === 1) {
                    var defaultValueInput1 = '1';
                }else {
                    var defaultValueInput1 = '';
                }

                var bloc = document.createElement('div');
                bloc.className = 'col-lg-12 row g-4';
                bloc.innerHTML = `
                    <div class="card-head">
                        <h5 class="card-title">
                            ${i + 1}
                        </h5>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group text-center">
                            <label class="form-label" for="Cause">De</label>
                            <div class="form-control-wrap">
                                <input placeholder="Entrer un chiffre" value="${defaultValueInput1}" readonly required type="text" class="form-control text-center" name="nbre1">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group text-center">
                            <label class="form-label" for="Cause">à</label>
                            <div class="form-control-wrap">
                                <input placeholder="Entrer un chiffre" ${readonly} value="${defaultValueInput}" required type="text" class="form-control text-center" name="nbre2">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group text-center">
                            <label class="form-label" for="Cause">Couleur</label>
                            <div class="form-control-wrap">
                                <select required class="form-select text-center" >
                                    <option value="" >
                                        Choisir une couleur
                                    </option>
                                    <option value="vert" >
                                        Vert
                                    </option>
                                    <option value="jaune" >
                                        Jaune
                                    </option>
                                    <option value="orange" >
                                        Orange
                                    </option>
                                    <option value="rouge" >
                                        Rouge
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;
                colorPara.appendChild(bloc);

                var inputNbre2 = bloc.querySelector('input[name="nbre2"]');

                inputNbre2.addEventListener('input', createInputListener(inputNbre2));
            }

            function createInputListener(input) {
                return function() {
                    var parentBloc = input.closest('.row');
                    var nextBloc = parentBloc.nextElementSibling;

                    if (nextBloc) {
                        var inputNbre1 = nextBloc.querySelector('input[name="nbre1"]');
                        if (inputNbre1) {
                            if (parseInt(input.value) >= parseInt(defaultValueInput)) {
                                toastr.warning("Veuillez vérifier le nombre saisie.");
                                return;
                            }else {
                                inputNbre1.value = parseInt(input.value) + 1;
                            }
                        }
                    }
                };
            }

            var selectElements = document.querySelectorAll('.form-control-wrap select');

            // Réinitialiser les options disponibles pour chaque sélecteur de couleur
            selectElements.forEach(function(select) {
                var selectedOptions = new Set(); // Stocker les options déjà sélectionnées

                // Parcourir tous les sélecteurs de couleur sauf celui actuellement modifié
                selectElements.forEach(function(otherSelect) {
                    if (otherSelect !== select) {
                        var selectedValue = otherSelect.value;
                        if (selectedValue !== '') {
                            selectedOptions.add(selectedValue); // Ajouter l'option sélectionnée à l'ensemble
                        }
                    }
                });

                // Désactiver les options déjà sélectionnées dans ce sélecteur
                var options = select.querySelectorAll('option');
                options.forEach(function(option) {
                    if (selectedOptions.has(option.value)) {
                        option.disabled = true; // Désactiver l'option si elle est sélectionnée dans un autre sélecteur
                    } else {
                        option.disabled = false; // Activer l'option si elle n'est pas sélectionnée dans un autre sélecteur
                    }
                });
            });

        });

    });
</script>-->

<!--<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les éléments du DOM
        var nbreInput = document.getElementById('nbre');
        var nbreColorInput = document.getElementById('nbre_color');
        var colorPara = document.getElementById('color_para');
        var suivantButton =  document.getElementById('btn_suivant'); // Bouton suivant

        if (nbreInput.value !== '' && nbreColorInput.value !== '' && operation.value !== '') {

            var nbre = parseInt(nbreInput.value);
            var nbreColor = parseInt(nbreColorInput.value);

            document.getElementById('block').style.display = 'block';

            // Créer et afficher les nouveaux blocs
            for (var i = 0; i < nbreColor; i++) {

                var defaultValueInput = '';
                var readonly = '';
                if (i === nbreColor - 1) {
                    if (operation.value === 'addition') {
                        var defaultValueInput = nbre + nbre;
                        var readonly = 'readonly';
                    } else if (operation.value === 'multiplication') {
                        var defaultValueInput = nbre * nbre;
                        var readonly = 'readonly';
                    }
                }

                var defaultValueInput1 = '';
                if (i + 1 === 1) {
                    var defaultValueInput1 = '1';
                }else {
                    var defaultValueInput1 = '';
                }

                var bloc = document.createElement('div');
                bloc.className = 'col-lg-12 row g-4';
                bloc.innerHTML = `
                    <div class="card-head">
                        <h5 class="card-title">
                            ${i + 1}
                        </h5>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group text-center">
                            <label class="form-label" for="Cause">De</label>
                            <div class="form-control-wrap">
                                <input placeholder="Entrer un chiffre" value="${defaultValueInput1}" readonly required type="text" class="form-control text-center" name="nbre1">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group text-center">
                            <label class="form-label" for="Cause">à</label>
                            <div class="form-control-wrap">
                                <input placeholder="Entrer un chiffre" ${readonly} value="${defaultValueInput}" required type="text" class="form-control text-center" name="nbre2">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group text-center">
                            <label class="form-label" for="Cause">Couleur</label>
                            <div class="form-control-wrap">
                                <select name="color_interval" required class="form-select text-center" >
                                    <option value="" >
                                        Choisir une couleur
                                    </option>
                                    <option value="vert" >
                                        Vert
                                    </option>
                                    <option value="jaune" >
                                        Jaune
                                    </option>
                                    <option value="orange" >
                                        Orange
                                    </option>
                                    <option value="rouge" >
                                        Rouge
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;
                colorPara.appendChild(bloc);

                var inputNbre2 = bloc.querySelector('input[name="nbre2"]');

                inputNbre2.addEventListener('input', createInputListener(inputNbre2));
            }

            function createInputListener(input) {
                return function() {
                    var parentBloc = input.closest('.row');
                    var nextBloc = parentBloc.nextElementSibling;

                    if (nextBloc) {
                        var inputNbre1 = nextBloc.querySelector('input[name="nbre1"]');
                        if (inputNbre1) {
                            if (parseInt(input.value) >= parseInt(defaultValueInput)) {
                                toastr.warning("Veuillez vérifier le nombre saisie.");
                                return;
                            }else {
                                inputNbre1.value = parseInt(input.value) + 1;
                            }
                        }
                    }
                };
            }

            var selectElements = document.querySelectorAll('.form-control-wrap select');

            // Réinitialiser les options disponibles pour chaque sélecteur de couleur
            selectElements.forEach(function(select) {
                var selectedOptions = new Set(); // Stocker les options déjà sélectionnées

                // Parcourir tous les sélecteurs de couleur sauf celui actuellement modifié
                selectElements.forEach(function(otherSelect) {
                    if (otherSelect !== select) {
                        var selectedValue = otherSelect.value;
                        if (selectedValue !== '') {
                            selectedOptions.add(selectedValue); // Ajouter l'option sélectionnée à l'ensemble
                        }
                    }
                });

                // Désactiver les options déjà sélectionnées dans ce sélecteur
                var options = select.querySelectorAll('option');
                options.forEach(function(option) {
                    if (selectedOptions.has(option.value)) {
                        option.disabled = true; // Désactiver l'option si elle est sélectionnée dans un autre sélecteur
                    } else {
                        option.disabled = false; // Activer l'option si elle n'est pas sélectionnée dans un autre sélecteur
                    }
                });
            });

            var colorOptions = ['vert', 'jaune', 'orange', 'rouge'];

            var selectElements = colorPara.querySelectorAll('select');

            selectElements.forEach(function(select) {
                var optionsHTML = '<option value="">Choisir une couleur</option>';
                colorOptions.forEach(function(color) {
                    optionsHTML += `<option value="${color}">${color.charAt(0).toUpperCase() + color.slice(1)}</option>`;
                });
                select.innerHTML = optionsHTML;
            });

        }

    });
</script>-->

@endsection


