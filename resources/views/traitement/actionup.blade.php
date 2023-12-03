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
                                            <span>Action(s) non Validé(es)</span>
                                            <em class="icon ni ni-list-index"></em>
                                        </h3>
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
                                                    <th>Risque</th>
                                                    <th>Action Préventive</th>
                                                    <th>Action Corrective</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($risques as $key => $risque)
                                                    <tr class="text-center">
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $risque->nom }}</td>
                                                        <td>{{ $risque->nbre_actionp }}</td>
                                                        <td>{{ $risque->nbre_actionc }}</td>
                                                        <td>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#modalDetail{{ $risque->id }}"
                                                                href="#" class="btn btn-info btn-sm">
                                                                <em class="icon ni ni-pen"></em>
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
                        <form class="nk-block" method="post" action="{{ route('action_update') }}" >
                            @csrf
                            <div class="row g-gs">
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
                                                                <input value="{{ $actionsDatas['action'] }}" type="text" class="form-control text-center" id="preventif" name="actionp[]">
                                                                <input value="{{ $actionsDatas['action_idp'] }}" type="text" name="action_idp[]" style="display: none;" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-center">
                                                            <label class="form-label" for="description">
                                                                Commentaire
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <textarea readonly name="commentairep[]" class="form-control no-resize" id="default-textarea">{{ $actionsDatas['commentaire'] }}</textarea>
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
                                                                <input value="{{ $actionsDatas['action'] }}" type="text" class="form-control text-center" id="preventif" name="actionc[]">
                                                                <input value="{{ $actionsDatas['action_idc'] }}" type="text" name="action_idc[]" style="display: none;" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-center">
                                                            <label class="form-label" for="description">
                                                                Commentaire
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <textarea readonly name="commentairep[]" class="form-control no-resize" id="default-textarea">{{ $actionsDatas['commentaire'] }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-md-12 col-xxl-12">
                                    <div class="card card-preview">
                                        <div class="card-inner row g-gs">
                                            <div class="col-12">
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-lg btn-success btn-dim ">
                                                        <em class="ni ni-check me-2"></em>
                                                        <em>Enregistrer</em>
                                                    </button >
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
