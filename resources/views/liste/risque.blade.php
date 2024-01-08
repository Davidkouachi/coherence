@extends('app')

@section('titre', 'Liste des Risques')

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
                                    <span>Liste des Risques</span>
                                    <em class="icon ni ni-list-index"></em>
                                </h3>
                            </div>
                        </div>
                    </div>
                    @if( intval($color_para->nbre_color) > intval($color_interval_nbre) )
                        <div class="nk-block">
                            <div class="row g-gs">
                                <div class="col-lg-12 col-xxl-12">
                                    <div class="modal-content">
                                        <div class="modal-body modal-body-lg text-center">
                                            <div class="nk-modal">
                                                <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-alert bg-warning"></em>
                                                <h4 class="nk-modal-title">
                                                    Paraméttrage des couleurs non complet
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @php
                            $isOutOfRange = false;
                            $maxValue = ($color_para->operation === 'addition') ? (intval($color_para->nbre2) + intval($color_para->nbre2)) : (intval($color_para->nbre2) * intval($color_para->nbre2));
                        @endphp

                        @for ($i = 1; $i <= $maxValue; $i++)
                            @php
                                $isInInterval = false;
                            @endphp

                            @foreach($color_intervals as $color_interval)
                                @if ($i >= $color_interval->nbre1 && $i <= $color_interval->nbre2)
                                    @php
                                        $isInInterval = true;
                                        break; // Sortir de la boucle dès qu'un intervalle correspond
                                    @endphp
                                @endif
                            @endforeach

                            @unless($isInInterval)
                                @if($i)
                                    @php
                                        $isOutOfRange = true;
                                    @endphp
                                @endif
                            @endunless
                        @endfor

                        @if($isOutOfRange)
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <div class="col-lg-12 col-xxl-12">
                                        <div class="modal-content">
                                            <div class="modal-body modal-body-lg text-center">
                                                <div class="nk-modal">
                                                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-alert bg-warning"></em>
                                                    <h4 class="nk-modal-title">
                                                        Paraméttrage des couleurs non complet
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <div class="col-md-12 col-xxl-12">
                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                <table class="datatable-init table">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th></th>
                                                            <th>Risque</th>
                                                            <th>Processus</th>
                                                            <!--<th>Nombre de cause</th>
                                                            <th>Nombre d'action Préventive</th>
                                                            <th>Nombre d'action Corrective</th>-->
                                                            <th>Evaluation</th>
                                                            <th>Coût</th>
                                                            <th>Statut</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($risques as $key => $risque)
                                                            <tr class="text-center">
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{ $risque->nom }}</td>
                                                                <td>{{ $risque->nom_processus }}</td>
                                                                <!--<td>{{ $risque->nbre_cause }}</td>
                                                                <td>{{ $risque->nbre_actionp }}</td>
                                                                <td>{{ $risque->nbre_actionc }}</td>-->
                                                                <!--<td>{{ $risque->vraisemblence_residuel }}</td>
                                                                <td>{{ $risque->gravite_residuel }}</td>-->
                                                                @if ($risque->evaluation_residuel < 1 && $risque->evaluation_residuel <= 2 )
                                                                    <td class="border-white" style="background-color:#8e8e8e;" ></td>
                                                                @endif
                                                                @if ($risque->evaluation_residuel >= 1 && $risque->evaluation_residuel <= 2 )
                                                                    <td class="border-white" style="background-color:#5eccbf;" ></td>
                                                                @endif
                                                                @if ($risque->evaluation_residuel >= 3 && $risque->evaluation_residuel <= 9)
                                                                    <td class="border-white"style="background-color:#f7f880;"></td>
                                                                @endif
                                                                @if ($risque->evaluation_residuel >= 10 && $risque->evaluation_residuel <= 16)
                                                                    <td class="border-white"style="background-color:#f2b171;"></td>
                                                                @endif
                                                                @if ($risque->evaluation_residuel > 16)
                                                                    <td class="border-white" style="background-color:#ea6072;"></td>
                                                                @endif
                                                                <td>
                                                                    @php
                                                                        $cout = $risque->cout_residuel;
                                                                        $formatcommande = number_format($cout, 0, '.', '.');
                                                                    @endphp
                                                                    {{ $formatcommande }} Fcfa
                                                                </td>
                                                                @if ($risque->statut === 'soumis')
                                                                    <td class=" text-warning">
                                                                        En attente de validation
                                                                    </td>
                                                                @endif
                                                                @if ($risque->statut === 'valider')
                                                                    <td class=" text-success">
                                                                        Validé
                                                                    </td>
                                                                @endif
                                                                @if ($risque->statut === 'non_valider')
                                                                    <td class=" text-danger">
                                                                        Non Validé
                                                                    </td>
                                                                @endif
                                                                @if ($risque->statut === 'update')
                                                                    <td class="text-info" >
                                                                        Modification éffectuée
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    <a data-bs-toggle="modal"
                                                                        data-bs-target="#modalDetail{{ $risque->id }}"
                                                                        href="#" class="btn btn-icon btn-white btn-dim btn-sm btn-warning border border-1 border-white rounded">
                                                                        <em class="icon ni ni-eye"></em>
                                                                    </a>
                                                                    <a data-bs-toggle="modal"
                                                                        data-bs-target="#modalFile{{ $risque->id }}"
                                                                        href="#" class="btn btn-icon btn-white btn-dim btn-sm btn-info border border-1 border-white rounded">
                                                                        <em class="icon ni ni-file"></em>
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
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    @foreach ($risques as $risque)
        <div class="modal fade zoom" tabindex="-1" id="modalFile{{ $risque->id }}">
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content" data-simplebar>
                    @if ($risque->pdf_nom != '')
                        <embed src="{{ asset('storage/pdf/' . $risque->pdf_nom) }}" type="application/pdf" width="100%" height="1100px">
                    @endif
                    
                    @if ($risque->pdf_nom == '')
                        <p class="text-center mt-2"  >Aucun fichier </p>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($risques as $risque)
        <div class="modal fade zoom" tabindex="-1" id="modalDetail{{ $risque->id }}">
            <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Détails</h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em
                                class="icon ni ni-cross"></em></a>
                    </div>
                    <div class="modal-body">
                        <form class="nk-block" >
                            <div class="row g-gs">
                                <div class="col-md-12 col-xxl-122" id="groupesContainer">
                                    <div class="card ">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Processus
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $risque->nom_processus }}" readonly type="text" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="controle">
                                                                Risque
                                                                @if ($risque->statut === 'soumis')
                                                                    <span class="text-warning"> ( En attente de validation )</span>
                                                                @endif
                                                                @if ($risque->statut === 'valider')
                                                                    <span class="text-success"> ( Validé )</span>
                                                                @endif
                                                                @if ($risque->statut === 'non_valider')
                                                                    <span class="text-danger"> (Non Validé )</span>
                                                                @endif
                                                                @if ($risque->statut === 'update')
                                                                    <span class="text-info"> (Modification éffectuée )</span>
                                                                @endif
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $risque->nom }}" readonly type="text" class="form-control" id="controle">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 row g-2" style="margin-left:1px;">
                                    <div class="col-md-12">
                                        @if ($risque->evaluation >= 1 && $risque->evaluation <= 2 )
                                            <div class="card card-bordered h-100 border-white" style="background-color:#5eccbf;">
                                        @endif
                                        @if ($risque->evaluation >= 3 && $risque->evaluation <= 9)
                                            <div class="card card-bordered h-100 border-white" style="background-color:#f7f880;">
                                        @endif
                                        @if ($risque->evaluation >= 10 && $risque->evaluation <= 16)
                                            <div class="card card-bordered h-100 border-white" style="background-color:#f2b171;">
                                        @endif
                                        @if ($risque->evaluation > 16)
                                            <div class="card card-bordered h-100 border-white" style="background-color:#ea6072;">
                                        @endif
                                            <div class="card-inner">
                                                <div class="card-head">
                                                    <h5 class="card-title">
                                                        Evaluation risque sans dispositif de contrôle interne ou dispositif antérieur
                                                    </h5>
                                                </div>
                                                <form action="#">
                                                    <div class="row g-4">
                                                        <div class="col-lg-2 text-center">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Vraisemblence
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->vraisemblence }}" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    gravite
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->gravite }}" readonly type="text" class="form-control text-center" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    Evaluation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->evaluation }}" readonly type="text" class="form-control text-center" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group text-center">
                                                                <label class="form-label " for="controle">
                                                                    Coût
                                                                </label>
                                                                @php
                                                                    $cout = $risque->cout;
                                                                    $formatcommande = number_format($cout, 0, '.', '.');
                                                                @endphp
                                                                <div class="form-control-wrap ">
                                                                    <input value="{{ $formatcommande }} Fcfa" readonly type="text" class="form-control text-center" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($causesData[$risque->id] as $key => $causesDatas)
                                <div class="col-md-12 col-xxl-122" id="groupesContainer">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-center">
                                                            <label class="form-label" for="Cause">
                                                                Cause {{ $key+1 }}
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $causesDatas['cause'] }}" readonly type="text" class="form-control text-center" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-center">
                                                            <label class="form-label" for="controle">
                                                                Dispositif de Contrôle
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $causesDatas['dispositif'] }}" readonly type="text" class="form-control text-center" id="controle">
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
                                        @if ($risque->evaluation_residuel >= 1 && $risque->evaluation_residuel <= 2 )
                                            <div class="card card-bordered h-100 border-white" style="background-color:#5eccbf;">
                                        @endif
                                        @if ($risque->evaluation_residuel >= 3 && $risque->evaluation_residuel <= 9)
                                            <div class="card card-bordered h-100 border-white" style="background-color:#f7f880;">
                                        @endif
                                        @if ($risque->evaluation_residuel >= 10 && $risque->evaluation_residuel <= 16)
                                            <div class="card card-bordered h-100 border-white" style="background-color:#f2b171;">
                                        @endif
                                        @if ($risque->evaluation_residuel > 16)
                                            <div class="card card-bordered h-100 border-white" style="background-color:#ea6072;">
                                        @endif
                                            <div class="card-inner">
                                                <div class="card-head">
                                                    <h5 class="card-title">
                                                        Evaluation risque avec dispositif de contrôle interne actuel
                                                    </h5>
                                                </div>
                                                <form action="#">
                                                    <div class="row g-4">
                                                        <div class="col-lg-2">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="Cause">
                                                                    Vraisemblence
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->vraisemblence_residuel }}" readonly type="text" class="form-control text-center" id="Cause">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    gravite
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->gravite_residuel }}" readonly type="text" class="form-control text-center" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    Evaluation
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->evaluation_residuel }}" readonly type="text" class="form-control text-center" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    Coût
                                                                </label>
                                                                @php
                                                                    $cout2 = $risque->cout_residuel;
                                                                    $formatcommande2 = number_format($cout2, 0, '.', '.');
                                                                @endphp
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $formatcommande2 }} Fcfa" readonly type="text" class="form-control text-center" id="controle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-center">
                                                                <label class="form-label" for="controle">
                                                                    Traitement
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $risque->traitement }}" readonly type="text" class="form-control text-center" id="controle">
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
                                <div class="col-md-12 col-xxl-12" id="groupesAction">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-center">
                                                            <label class="form-label" for="preventif">
                                                                Action préventive {{ $key+1 }}
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $actionsDatas['action'] }}" readonly type="text" class="form-control text-center" id="preventif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-center">
                                                            <label class="form-label" for="preventif">
                                                                Délai
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $actionsDatas['date_suivip'] }}" readonly type="text" class="form-control text-center" id="preventif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-center">
                                                            <label class="form-label" for="email-address-1">
                                                                Responsabilité
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionsDatas['responsable'] }}" readonly type="text" class="form-control text-center">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @foreach ($actionsDatac[$risque->id] as $key => $actionsDatas)
                                <div class="col-md-12 col-xxl-12" id="groupesAction">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-center">
                                                            <label class="form-label" for="preventif">
                                                                Action corrective {{ $key+1 }}
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $actionsDatas['action'] }}" readonly type="text" class="form-control text-center" id="preventif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-center">
                                                            <label class="form-label" for="email-address-1">
                                                                Responsabilité
                                                            </label>
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input value="{{ $actionsDatas['responsable'] }}" readonly type="text" class="form-control text-center">
                                                                </div>
                                                            </div>
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
                                                <div class="form-group text-center">
                                                    <label class="form-label" for="email-address-1">
                                                        Validateur
                                                    </label>
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $risque->validateur }}" readonly type="text" class="form-control text-center">
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


@endsection
