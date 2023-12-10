@extends('app')

@section('titre', 'Tableau de validation')

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
                        <div class="nk-block-head nk-block-head-sm" >
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content" style="margin:0px auto;">
                                        <h3 class="text-center">
                                            <span>Fiche d'amélioration non validé</span>
                                            <em class="icon ni ni-list-index"></em>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-md-12 col-xxl-12">
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                        <table class="datatable-init table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Lieu</th>
                                                    <th>Détecteur</th>
                                                    <th>Non-conformité</th>
                                                    <th>Nombre d'actions</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ams as $key => $am)
                                                    <tr class="text-center">
                                                        <td>{{ $key+1 }}</td>
                                                        <td>
                                                            @if ($am->type === 'contentieux')
                                                                Contentieux
                                                            @endif
                                                            @if ($am->type === 'reclamation')
                                                                Réclamation
                                                            @endif
                                                            @if ($am->type === 'non_conformite_interne')
                                                                Non conformité
                                                            @endif
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($am->date_fiche)->format('d/m/Y') }}</td>
                                                        <td>{{ $am->lieu }}</td>
                                                        <td>{{ $am->detecteur }}</td>
                                                        <td>{{ $am->non_conformite }}</td>
                                                        <td>{{ $am->nbre_action }}</td>
                                                        <td>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#modalDetail{{ $am->id }}"
                                                                class="btn btn-icon btn-white btn-dim btn-sm btn-warning">
                                                                <em class="icon ni ni-eye"></em>
                                                            </a>
                                                            <a href="{{ route('index_etat_am',['id' => $am->id ]) }}"
                                                                class="btn btn-icon btn-white btn-dim btn-sm btn-primary">
                                                                <em class="icon ni ni-printer-fill"></em>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($ams as $am)
        <div class="modal fade zoom" tabindex="-1" id="modalDetail{{ $am->id }}">
            <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Détails</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                    </div>
                    <div class="modal-body">
                        <form class="nk-block">
                            <div class="row g-gs">
                                <div class="col-md-12 col-xxl-12" id="groupesContainer">
                                    <div class="">
                                        <div class="card-inner">
                                            <div class="row g-4">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Type
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input @if ($am->type === 'contentieux')
                                                                value="Contentieux"
                                                            @endif
                                                            @if ($am->type === 'reclamation')
                                                                value="Réclamation"
                                                            @endif
                                                            @if ($am->type === 'non_conformite_interne')
                                                                value="Non conformité"
                                                            @endif
                                                            readonly type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Date
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $am->date_fiche }}" readonly type="date" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Lieu
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $am->lieu }}" readonly type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Détecteur
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $am->detecteur }}" readonly type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Non-conformité
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $am->non_conformite }}" readonly type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            Conséquences
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea">{{ $am->consequence }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            Causes
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea">{{ $am->cause }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach($actionsData[$am->id] as $key => $actions)
                                <div class="col-md-12 col-xxl-122" id="groupesContainer">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-head">
                                                <h5 class="card-title">
                                                    Action Corrective {{ $key+1 }}
                                                </h5>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group text-center">
                                                        <label class="form-label" for="Cause">
                                                            Processus
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $actions['processus'] }}" readonly type="text" class="form-control text-center" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group text-center">
                                                        <label class="form-label" for="Cause">
                                                            risque
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $actions['risque'] }}" readonly type="text" class="form-control text-center" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group text-center">
                                                        <label class="form-label" for="Cause">
                                                            Action
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $actions['action'] }}" readonly type="text" class="form-control text-center" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($actions['statut'] === 'realiser')
                                                <div class="col-lg-4">
                                                    <div class="form-group text-center">
                                                        <label class="form-label" for="Cause">
                                                            Délai
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ \Carbon\Carbon::parse($actions['delai'])->format('d/m/Y') }}" readonly type="text" class="form-control text-center" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group text-center">
                                                        <label class="form-label" for="Cause">
                                                            Date de realisation
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ \Carbon\Carbon::parse($actions['date_action'])->format('d/m/Y') }}" readonly type="text" class="form-control text-center" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group text-center">
                                                        <label class="form-label" for="Cause">
                                                            Date du Suivi
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ \Carbon\Carbon::parse($actions['date_suivi'])->format('d/m/Y H:i:s') }}" readonly type="text" class="form-control text-center" id="Cause">
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
                                                @endif
                                                @if ($actions['statut'] !== 'realiser')
                                                <div class="col-lg-12">
                                                    <div class="form-group text-center">
                                                        <div class="form-control-wrap">
                                                            <input value="Action Non Réaliser" readonly type="text" class="form-control text-center bg-danger" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            Commentaire
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea">{{ $actions['commentaire'] }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


@endsection
