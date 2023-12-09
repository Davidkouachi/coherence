@extends('app')

@section('titre', 'Liste des actions preventives')

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
                                            <span>Liste des actions preventives</span>
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
                                                    <th>Action</th>
                                                    <th>Délai</th>
                                                    <th>Statut</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($actions as $key => $action)
                                                    <tr class="text-center">
                                                        <td>{{ $key+1}}</td>
                                                        <td>{{ $action->action}}</td>
                                                        <td>{{ $action->delai}}</td>
                                                        @if ($action->date_action !== null && $action->delai >= $action->date_action)
                                                            <td class="text-center text-success" >
                                                                Realiser dans le delai
                                                            </td>
                                                        @endif
                                                        @if ($action->date_action !== null && $action->delai < $action->date_action)
                                                            <td class="text-center text-danger" >
                                                                Realiser hors delai
                                                            </td>
                                                        @endif
                                                        @if ($action->date_action === null)
                                                            <td class="text-center text-warning" >
                                                                Non réaliser
                                                            </td>
                                                        @endif
                                                        <td>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#modalDetail{{$action->id}}"
                                                                href="#" class="btn btn-icon btn-white btn-dim btn-sm btn-warning border border-1 border-white rounded">
                                                                <em class="icon ni ni-eye"></em>
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

    @foreach ($actions as $action)
        <div class="modal fade zoom" tabindex="-1" id="modalDetail{{ $action->id }}">
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
                                <div class="col-md-12 col-xxl-12" id="groupesContainer">
                                    <div class="">
                                        <div class="card-inner">
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Processus
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->processus }}" readonly type="text" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Risque
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->risque }}" readonly type="text" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Actions
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->action }}" readonly type="text" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if ($action->date_action !== null && $action->delai >= $action->date_action)
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Délai
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->delai }}" readonly type="date" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Date d'action
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->date_action }}" readonly type="date" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Efficacitée
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->efficacite }}" readonly type="text" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                @if ($action->date_action !== null && $action->delai >= $action->date_action)
                                                                    <input value="Realiser dans le delai" readonly type="text" class="form-control text-center bg-success" id="Cause">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" >
                                                                Commentaire
                                                            </label>
                                                            <div class="form-control-wrap" >
                                                                <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea">{{ $action->commentaire }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if ($action->date_action !== null && $action->delai < $action->date_action)
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Délai
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->delai }}" readonly type="date" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Date d'action
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->date_action }}" readonly type="date" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Efficacitée
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->efficacite }}" readonly type="text" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                @if ($action->date_action !== null && $action->delai < $action->date_action)
                                                                    <input value="Realiser hors delai" readonly type="text" class="form-control text-center bg-danger" id="Cause">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" >
                                                                Commentaire
                                                            </label>
                                                            <div class="form-control-wrap" >
                                                                <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea">{{ $action->commentaire }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if ($action->date_action === null)
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Délai
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->delai }}" readonly type="date" class="form-control" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                @if ($action->date_action === null)
                                                                    <input value="Non Realiser" readonly type="text" class="form-control text-center bg-warning" id="Cause">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Contrôleur
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="{{ $action->poste }}" readonly type="text" class="form-control" id="Cause">
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

    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('9f9514edd43b1637ff61', {
          cluster: 'eu'
        });

        var channel = pusher.subscribe('my-channel-ap');
        channel.bind('my-event-ap', function(data) {
            Swal.fire({
                        title: "Alert!",
                    text: "Nouvelle(s) Action(s)",
                        icon: "info",
                        confirmButtonColor: "#00d819",
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
        });
    </script>


@endsection
