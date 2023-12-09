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
                                            <span>Risque(s) non Validé(es)</span>
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
                                                    <th>Processus</th>
                                                    <th>Risque</th>
                                                    <th>Evaluation</th>
                                                    <th>Motif</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($risques as $key => $risque)
                                                    <tr class="text-center">
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $risque->nom_processus }}</td>
                                                        <td>{{ $risque->nom }}</td>
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
                                                            {{ $risque->motif }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('index_risque_actionup2',[$risque->id]) }}" class="btn btn-icon btn-white btn-dim btn-sm btn-info border border-1 border-white rounded">
                                                                <em class="icon ni ni-edit"></em>
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

    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('9f9514edd43b1637ff61', {
          cluster: 'eu'
        });

        var channel = pusher.subscribe('my-channel-action-non-valider');
        channel.bind('my-event-action-non-valider', function(data) {
            Swal.fire({
                        title: "Alert!",
                        text: "Nouveau(x) Risque(s) à Modifier",
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
