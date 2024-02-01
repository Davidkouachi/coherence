@extends('app')

@section('titre', 'Fiche Amélioration')

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
                                <span>Mise à jour de la Fiche d'incident</span>
                                <em class="icon ni ni-reports"></em>
                            </h3>
                        </div>
                        <div class="nk-block-head-content">
                                        <a href="{{ route('index_amup') }}" class="btn btn-danger btn-outline-white d-none d-sm-inline-flex">
                                            <em class="icon ni ni-arrow-left"></em>
                                            <span>Retour</span>
                                        </a>
                                        <a href="{{ route('index_amup') }}" class="btn btn-danger btn-outline-white d-inline-flex d-sm-none">
                                            <em class="icon ni ni-arrow-left"></em>
                                        </a>
                                    </div>
                    </div>
                </div>
                <form class="nk-block" method="post" action="{{ route('amup2_traitement') }}">
                    @csrf
                    <input type="text" value="{{ $am->id }}" name="amelioration_id" style="display: none;" >
                    <div class="row g-gs">
                        <div class="col-md-12 col-xxl-12" id="groupesContainer">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Motif(s)
                                                </label>
                                                <div class="form-control-wrap">
                                                    <textarea disabled  class="form-control no-resize" id="default-textarea">{{ $am->motif }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xxl-12" id="groupesContainer">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-4 ">
                                        <div class="col-lg-4">
                                            <div class="form-group text-center">
                                                <div class="custom-control custom-radio">
                                                    <input @php if ($am->type === 'non_conformite_interne') { echo "checked"; } @endphp required type="radio" class="custom-control-input" name="type" id="customRadio7" value="non_conformite_interne">
                                                    <label class="custom-control-label" for="customRadio7">
                                                        Non conformité interne
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group text-center">
                                                <div class="custom-control custom-radio">
                                                    <input @php if ($am->type === 'reclamation') { echo "checked"; } @endphp required type="radio" class="custom-control-input" name="type" id="customRadio6" value="reclamation">
                                                    <label class="custom-control-label" for="customRadio6">
                                                        Reclamation
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group text-center">
                                                <div class="custom-control custom-radio">
                                                    <input @php if ($am->type === 'contentieux') { echo "checked"; } @endphp required type="radio" class="custom-control-input" name="type" id="customRadio5" value="contentieux">
                                                    <label class="custom-control-label" for="customRadio5">
                                                        Contentieux
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xxl-12" id="groupesContainer">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-4">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Date
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input required name="date_fiche" type="date" class="form-control" value="{{ $am->date_fiche }}"  max="{{ \Carbon\Carbon::now()->toDateString() }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="controle">
                                                    Lieu
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input required placeholder="Saisie obligatoire" name="lieu" type="text" class="form-control" value="{{ $am->lieu }}" id="controle">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="controle">
                                                    Détecteur (Agent / Client)
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input required placeholder="Saisie obligatoire" name="detecteur" type="text" class="form-control" value="{{ $am->detecteur }}" id="controle">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xxl-12" id="groupesContainer">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Non conformité
                                                </label>
                                                <div class="form-control-wrap">
                                                    <input required placeholder="Saisie obligatoire" name="non_conformite" id="inputMots" type="text" class="form-control" value="{{ $am->non_conformite }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Conséquence(s)
                                                </label>
                                                <div class="form-control-wrap" id="resultat">
                                                    <textarea required name="consequence" class="form-control no-resize" id="default-textarea">{{ $am->consequence }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="Cause">
                                                    Cause(s)
                                                </label>
                                                <div class="form-control-wrap">
                                                    <textarea required name="cause" class="form-control no-resize" id="default-textarea">{{ $am->cause }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xxl-12 ">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-4">
                                        @foreach($actionsDatam[$am->id] as $key => $actions)
                                        <div class="col-md-12 col-xxl-12">
                                            <div class="card ">
                                                <div class="card-inner">
                                                    <div class="row g-4">
                                                        <div class="col-lg-12 col-xxl-12">
                                                            <div class="card">
                                                                <div class="card-inner">
                                                                    <div class="card-head">
                                                                        {{ $key+1 }}
                                                                        <span class="badge badge-dot bg-primary">
                                                                            @if($actions['trouve'] === 'new_risque')
                                                                                Nouveau risque
                                                                            @endif
                                                                            @if($actions['trouve'] === 'risque')
                                                                                Risque trouvé
                                                                            @endif
                                                                            @if($actions['trouve'] === 'cause')
                                                                                Cause trouvée
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" value="{{ $actions['suivi_id'] }}" name="suivi_id[]" style="display: none;">
                                                                    <div class="row g-4">
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="Cause">
                                                                                    Processus
                                                                                </label>
                                                                                <select disabled class="form-select js-select2">
                                                                                    @foreach($processuss as $processus)
                                                                                    <option {{ $actions['processus_id'] === $processus->id ? 'selected' : '' }}  value="{{$processus->id}}">
                                                                                        {{$processus->nom}}
                                                                                    </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="controle">
                                                                                    Risque
                                                                                </label>
                                                                                <div class="form-control-wrap">
                                                                                    <input disabled value="{{ $actions['risque'] }}" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @if($actions['trouve'] !== 'risque')
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="controle">
                                                                                    Causes
                                                                                </label>
                                                                                <div class="form-control-wrap">
                                                                                    <input value="{{ $actions['cause'] }}" disabled type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="controle">
                                                                                    Action Corrective
                                                                                </label>
                                                                                <div class="form-control-wrap">
                                                                                    <input disabled value="{{ $actions['action'] }}" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="Coût">
                                                                                    Responsable
                                                                                </label>
                                                                                <select disabled name="poste_id[]" class="form-select js-select2">
                                                                                    @foreach($postes as $poste)
                                                                                    <option {{ $actions['poste_id'] === $poste->id ? 'selected' : '' }}  value="{{$poste->id}}">
                                                                                        {{$poste->nom}}
                                                                                    </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="Coût">
                                                                                    Date prévisionnelle de réalisation
                                                                                </label>
                                                                                <div class="form-control-wrap">
                                                                                    <input required name="delai[]" value="{{ $actions['delai'] }}" type="date" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                            <div class="form-group text-center">
                                                                                <label class="form-label" for="description">
                                                                                    Commentaire
                                                                                </label>
                                                                                <div class="form-control-wrap">
                                                                                    <textarea required name="commentaire_am[]" class="form-control no-resize" id="default-textarea">{{ $actions['commentaire_am'] }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 text-left">
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input value="{{ $actions['suivi_id'] }}" name="id_suppr[{{$key+1}}]" type="text" style="display: none;">
                                                                                <input name="suppr[{{$key+1}}]" value="oui" type="checkbox" class="custom-control-input" id="customCheck1_{{$key+1}}">
                                                                                <label class="custom-control-label" for="customCheck1_{{$key+1}}">
                                                                                    Supprimé
                                                                                </label>
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
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xxl-12">
                            <div class="card card-bordered card-preview">
                                <div class="card-inner row g-gs">
                                    <div class="col-12">
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-lg btn-success btn-dim ">
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

<script>
    var postes = @json($postes);
    var processuss = @json($processuss);
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxesCause = document.querySelectorAll('input[name^="suppr["]');

            checkboxesCause.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedCount = document.querySelectorAll('input[name^="suppr["]:checked').length;

                    if (checkedCount === checkboxesCause.length) {
                        // Si toutes les cases sont cochées, décocher la dernière case cochée
                        checkbox.checked = false;

                        toastr.warning(`Impossible de supprimé cette action `);
                    }
                });
            });
        });
    </script>

@endsection
