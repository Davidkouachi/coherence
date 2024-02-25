@extends('app')

@section('titre', 'Statistique')

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
                                <span>Statistique</span>
                                <em class="icon ni ni-bar-chart-alt"></em>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="row g-gs">

                        <div class="col-lg-4 col-xxl-4 ">
                            <div class="card card-bordered  card-full">
                                <div class="card-inner">
                                    <div class="card-amount">
                                        <span class="amount">Processus - Risques - Causes</span>
                                    </div>
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <div class="title text-center">Processus</div>
                                                <div class="amount text-center">{{ $nbre_processus }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Risques</div>
                                                <div class="amount text-center">{{ $nbre_risque }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Causes</div>
                                                <div class="amount text-center">{{ $nbre_cause }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xxl-4 ">
                            <div class="card card-bordered  card-full">
                                <div class="card-inner">
                                    <div class="card-amount">
                                        <span class="amount">Action Préventive ({{ $nbre_ap }})</span>
                                    </div>
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <div class="title text-center">Dans les délais</div>
                                                <div class="amount text-center">
                                                    <span class="text-success" >{{ $nbre_ed_ap }}</span>
                                                    @if($nbre_ap != 0)
                                                        (<span>{{ number_format(($nbre_ed_ap / $nbre_ap)*100 , 2) }} %</span>)
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Hors délais</div>
                                                <div class="amount text-center">
                                                    <span class="text-warning" >{{ $nbre_ehd_ap }}</span>
                                                    @if($nbre_ap != 0)
                                                        (<span>{{ number_format(($nbre_ehd_ap / $nbre_ap)*100 , 2) }} %</span>)
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Non Réaliser</div>
                                                <div class="amount text-center">
                                                    <span class="text-danger" >{{ $nbre_hd_ap }}</span>
                                                    @if($nbre_ap != 0)
                                                        (<span>{{ number_format(($nbre_hd_ap / $nbre_ap)*100 , 2) }} %</span>)
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xxl-4 ">
                            <div class="card card-bordered  card-full">
                                <div class="card-inner">
                                    <div class="card-amount">
                                        <span class="amount">Données Statistiques</span>
                                    </div>
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <div class="title text-center">Actions correctives</div>
                                                <div class="amount text-center">{{ $nbre_ac }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Utilisateurs</div>
                                                <div class="amount text-center">{{ $nbre_user }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Postes</div>
                                                <div class="amount text-center">{{ $nbre_poste }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php 
                            $maxProgress = 0;
                        @endphp

                        @foreach ($statistics as $type => $stat)
                            @php 
                                $maxProgress = max($maxProgress, $stat['progres']);
                            @endphp
                        @endforeach

                        @foreach ($statistics as $type => $stat)
                            <div class="col-lg-3">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner">
                                        <div class="card-amount">
                                            <span class="amount">
                                                @if ($type === 'non_conformite_interne')
                                                    Non conformité.I
                                                @endif
                                                @if ($type === 'reclamation')
                                                    Réclamation
                                                @endif
                                                @if ($type === 'contentieux')
                                                     Contentieux
                                                @endif
                                                <span class="currency currency-usd ">
                                                    {{$stat['total']}} 
                                                    <span class="{{ $stat['progres'] === $maxProgress ? 'text-danger' : '' }} " >
                                                        ({{$stat['progres']}}%)
                                                    </span>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="invest-data">
                                            <div class="invest-data-amount g-2">
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Cause(s)
                                                    </div>
                                                    <div class="amount text-center">
                                                        {{ $stat['causes'] }}
                                                    </div>
                                                </div>
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Risque(s)
                                                    </div>
                                                    <div class="amount text-center">
                                                        {{ $stat['risques'] }}
                                                    </div>
                                                </div>
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Néant
                                                    </div>
                                                    <div class="amount text-center">
                                                        {{ $stat['causes_risques_nt'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <canvas id="myChart{{$type}}"></canvas>
                                        </div>

                                        <script>
                                            var ctx{{ $type }} = document.getElementById('myChart{{ $type }}').getContext('2d');
                                            var myChart{{ $type }} = new Chart(ctx{{ $type }}, {
                                                type: 'bar',
                                                data: {
                                                    labels: ['Causes', 'Risques', 'Néant'],
                                                    datasets: [{
                                                       label: 'Histogramme',
                                                        data: [{{ $stat['causes'] }}, {{ $stat['risques'] }}, {{ $stat['causes_risques_nt'] }}],
                                                        backgroundColor: [
                                                            'blue',
                                                            'red',
                                                            'orange'], // Couleur de remplissage du graphique
                                                        borderColor: 'white', // Couleur de la bordure du graphique
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            ticks: {
                                                                stepSize: 10 // L'intervalle entre chaque étiquette sur l'axe Y
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                        </script>

                                        <!--<div class="card-amount">
                                            <div >
                                                <a class="btn btn-outline-warning btn-dim">
                                                    <span  class="me-2" >Détails</span>
                                                    <span>
                                                        <em class="ni ni-chevron-right-circle" > </em>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>-->

                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-lg-3">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-amount">
                                        <span class="amount">
                                            Incidents
                                            <span class="currency currency-usd ">
                                                {{ $nbre_am }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="invest-data">
                                            <div class="invest-data-amount g-2">
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Non C.I
                                                    </div>
                                                    <div class="amount text-center">
                                                        {{ $nbre_am_nci }}
                                                    </div>
                                                </div>
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Réclamations
                                                    </div>
                                                    <div class="amount text-center">
                                                        {{ $nbre_am_r }}
                                                    </div>
                                                </div>
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Contentieux
                                                    </div>
                                                    <div class="amount text-center">
                                                        {{ $nbre_am_c }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div>
                                        <canvas id="myCharti"></canvas>
                                    </div>
                                    <script>
                                        var ctx = document.getElementById('myCharti').getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: ['Non conformité.I', 'Réclamations', 'Contentieux'],
                                                datasets: [{
                                                    label: 'Histogramme',
                                                    data: [{{ $nbre_am_nci }}, {{ $nbre_am_r }}, {{ $nbre_am_c }}],
                                                    backgroundColor: [
                                                        'blue',
                                                        'red',
                                                        'orange'
                                                    ], // Couleur de remplissage du graphique
                                                    borderColor: 'white', // Couleur de la bordure du graphique
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        ticks: {
                                                            stepSize: 10 // L'intervalle entre chaque étiquette sur l'axe Y
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    </script>
                                    <!--<div class="card-amount">
                                                                    <div >
                                                                        <a class="btn btn-outline-warning btn-dim">
                                                                            <span  class="me-2" >Détails</span>
                                                                            <span>
                                                                                <em class="ni ni-chevron-right-circle" > </em>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>-->
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="form-group text-center">
                                        <label class="form-label" for="cf-full-name">Processus</label>
                                        <select name="processus_id" class="form-select text-center" id="selectProcessus">
                                            @foreach ($processus as $processus)
                                            <option value="{{$processus->id}}">
                                                {{$processus->nom}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="camenber"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="form-group text-center">
                                        <label class="form-label" for="cf-full-name">Risque</label>
                                        <select name="risque_id" class="form-select text-center" id="selectRisque">
                                            @foreach ($risques as $risque)
                                            <option value="{{$risque->id}}">
                                                {{$risque->nom}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="camenber_risk">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="form-group text-center">
                                        <label class="form-label">Choisir un interval de date</label>
                                        <div class="form-control-wrap">
                                            <div class="input-daterange date-picker-range input-group">
                                                <input data-date-format="yyyy-mm-dd" name="date1" id="date1" type="text" class="form-control"  value="{{ \Carbon\Carbon::now()->subMonth()->format('m/d/Y') }}"/>
                                                <div class="input-group-addon">au</div>
                                                <input data-date-format="yyyy-mm-dd" name="date2" id="date2" type="text" class="form-control me-2"  value="{{ \Carbon\Carbon::now()->format('m/d/Y') }}"/>
                                                <button id="btn_rech" class="btn btn-outline-success">
                                                    <em class="ni ni-search"></em>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="camenber2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">
                                                <span class="me-2">
                                                Quelques Risques
                                                </span>
                                                <!--<a href="{{ route('index_liste_risque') }}" class="btn btn-outline-warning btn-dim">
                                                    <em class="me-1" >Voir Plus</em>
                                                    <em class="ni ni-eye"></em>
                                                </a>-->
                                            </h6>
                                        </div>
                                        <div class="card-tools">
                                            <ul class="card-tools-nav">
                                                <li>
                                                    <div class="form-group text-center">
                                                        <select class="form-select" id="device">
                                                            <option selected value="Fcfa">Fcfa</option>
                                                            <option value="Euro">Euro</option>
                                                            <option value="Dollar">Dollar</option>
                                                        </select>
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                const selectDevice = document.getElementById('device');
                                                                
                                                                selectDevice.addEventListener('change', function() {
                                                                    // Récupérez la valeur sélectionnée
                                                                    document.querySelectorAll('[id^="device_data_"]').forEach(function(element) {
                                                                        element.textContent = selectDevice.value;
                                                                    });
                                                                });

                                                                // Mettez à jour une fois lors du chargement initial
                                                                document.querySelectorAll('[id^="device_data_"]').forEach(function(element) {
                                                                    element.textContent = selectDevice.value;
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-inner p-0 border-top">
                                    <div class="nk-tb-list nk-tb-orders">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span>Risque</span></div>
                                            <div class="nk-tb-col "><span>Evaluation</span></div>
                                            <div class="nk-tb-col "><span>Coût</span></div>
                                            <div class="nk-tb-col "><span>Statut</span></div>
                                            <div class="nk-tb-col "><span>Taux</span></div>
                                        </div>

                                        @php 
                                            $max = 0;
                                        @endphp

                                        @foreach ($risques_limit as $risque_limit)
                                            @php 
                                                $max = max($max, $risque_limit->progess);
                                            @endphp
                                        @endforeach

                                        @foreach($risques_limit as $risque_limit)
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-lead">{{$risque_limit->nom}}</span>
                                            </div>
                                            <div class="nk-tb-col ">
                                                @php $colorMatchFound = false; @endphp

                                                @foreach($color_intervals as $color_interval)
                                                                
                                                    @if($color_interval->nbre1 <= $risque_limit->evaluation_residuel && $color_interval->nbre2 >= $risque_limit->evaluation_residuel)
                                                        <div class="user-avatar sm" style="background-color:{{$color_interval->code_color}}" ></div>
                                                        @php
                                                            $colorMatchFound = true;
                                                        @endphp

                                                        @break

                                                    @endif

                                                @endforeach

                                                @if(!$colorMatchFound)
                                                    <div class="user-avatar sm" style="background-color:#8e8e8e;"></div>
                                                @endif
                                            </div>
                                            <div class="nk-tb-col ">
                                                <span class="tb-sub tb-amount">
                                                    @php
                                                        $cout = $risque_limit->cout_residuel;
                                                        $formatcommande = number_format($cout, 0, '.', '.');
                                                    @endphp             
                                                    {{ $formatcommande }} <span id="device_data_{{$risque_limit->id}}"></span>
                                                </span>
                                            </div>
                                            <div class="nk-tb-col ">
                                                @if ($risque_limit->statut === 'soumis')
                                                    <span class="badge badge-dim bg-warning">
                                                        <em class="icon ni ni-stop-circle"></em>
                                                        <span class="fs-12px">En attente de validation</span>
                                                    </span>
                                                @elseif ($risque_limit->statut === 'valider')
                                                    <span class="badge badge-dim bg-success">
                                                        <em class="icon ni ni-check"></em>
                                                        <span class="fs-12px">Validé</span>
                                                    </span>
                                                @elseif ($risque_limit->statut === 'non_valider')
                                                    <span class="badge badge-dim bg-danger">
                                                        <em class="icon ni ni-alert"></em>
                                                        <span class="fs-12px">Non Validé</span>
                                                    </span>
                                                @elseif ($risque_limit->statut === 'update')
                                                    <span class="badge badge-dim bg-info">
                                                        <em class="icon ni ni-info"></em>
                                                        <span class="fs-12px">Modification éffectuée</span>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="nk-tb-col ">
                                                <div class="project-list-progress">
                                                    <div class="progress progress-pill progress-md bg-light">
                                                        <div class="progress-bar {{$risque_limit->progess === $max ? 'bg-danger' : '' }}" data-progress="{{$risque_limit->progess}}" style="width: 100%;"></div>
                                                    </div>
                                                    <div class="project-progress-percent {{$risque_limit->progess === $max ? 'text-danger' : '' }}">
                                                        {{$risque_limit->progess}}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">
                                                <span class="me-2">
                                                Quelques Utilisateurs
                                                </span>
                                                <!--<a href="" class="btn btn-outline-warning btn-dim">
                                                    <em class="me-1" >Voir Plus</em>
                                                    <em class="ni ni-eye"></em>
                                                </a>-->
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-inner p-0 border-top">
                                    <div class="nk-tb-list nk-tb-orders">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span>Nom et prénoms</span></div>
                                            <div class="nk-tb-col "><span>Email</span></div>
                                            <div class="nk-tb-col "><span>Contact</span></div>
                                            <div class="nk-tb-col "><span>Poste</span></div>
                                        </div>

                                        @foreach($users as $user)
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-lead">{{$user->name}}</span>
                                            </div>
                                            <div class="nk-tb-col ">
                                                <span class="tb-lead">{{$user->email}}</span>
                                            </div>
                                            <div class="nk-tb-col ">
                                                <span class="tb-lead">{{$user->tel}}</span>
                                            </div>
                                            <div class="nk-tb-col ">
                                                <span class="tb-lead">{{$user->poste}}</span>
                                            </div>
                                        </div>
                                        @endforeach
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
    document.addEventListener('DOMContentLoaded', function() {
        // Appeler la fonction de recherche au chargement de la page
        searchProcessus();

        // Écouteur pour le changement de sélection
        document.getElementById('selectProcessus').addEventListener('change', function(){
            searchProcessus();
        });

        function searchProcessus() {
            var selectedProcessus = document.getElementById('selectProcessus').value;
            if (selectedProcessus !== '') {
                $.ajax({
                    url: '/get_processus/' + selectedProcessus,
                    method: 'GET',
                    success: function (data) {
                        addGroups(selectedProcessus, data);
                    },
                    /*error: function () {
                        toastr.info("Aucune données n'a été trouver.");
                    }*/
                });
            } /*else {
                toastr.warning("Veuillez selectionner un processus.");
            }*/
        }

        function addGroups(selectedProcessus, data) {
            var dynamicFields = document.getElementById("camenber");

            // Supprimer le contenu existant
            while (dynamicFields.firstChild) {
                dynamicFields.removeChild(dynamicFields.firstChild);
            }

            var groupe = document.createElement("div");
            groupe.className = "";
            groupe.innerHTML = `
                <canvas id="myChart"></canvas>
            `;

            var groupe2 = document.createElement("div");
            groupe2.className = "invest-data mt-2";
            groupe2.innerHTML = `
                <div class="invest-data-amount g-2">
                    <div class="invest-data-history">
                        <div class="title text-center">
                            Non conformité interne
                        </div>
                        <div class="amount text-center">
                            ${data.data[0]}
                        </div>
                    </div>
                    <div class="invest-data-history">
                        <div class="title text-center">
                            Réclamation
                        </div>
                        <div class="amount text-center">
                            ${data.data[1]}
                        </div>
                    </div>
                    <div class="invest-data-history">
                        <div class="title text-center">
                            Contentieux
                        </div>
                        <div class="amount text-center">
                            ${data.data[2]}
                        </div>
                    </div>
                </div>
            `;

            document.getElementById("camenber").appendChild(groupe);
            document.getElementById("camenber").appendChild(groupe2);

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Non conformite interne', 'Réclamation', 'Contentieux'],
                    datasets: [{
                        data: data.data,
                        backgroundColor: ['orange', 'skyblue', 'red'],
                        borderColor: 'white',
                        borderWidth: 1
                    }],
                    hoverOffset: 4
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                }
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        searchRisque();

        document.getElementById('selectRisque').addEventListener('change', function(){
            searchRisque();
        });

        function searchRisque() {
            var selectRisque =  document.getElementById('selectRisque').value;
            if (selectRisque !== '') {
                $.ajax({
                    url: '/get_risque/' + selectRisque,
                    method: 'GET',
                    success: function (data) {
                        addGroups(selectRisque, data);
                    },
                    /*error: function () {
                        toastr.info("Aucune données n'a été trouver.");
                    }*/
                });
            } /*else {
                toastr.warning("Veuillez selectionner un risque.");
            }*/
        }

        function addGroups(selectRisque, data) {

            var dynamicFields = document.getElementById("camenber_risk");

            // Supprimer le contenu existant
            while (dynamicFields.firstChild) {
                dynamicFields.removeChild(dynamicFields.firstChild);
            }

            var groupe = document.createElement("div");
            groupe.className = "";
            groupe.innerHTML = `
                <canvas id="myChart_risk"></canvas>
            `;

            var groupe2 = document.createElement("div");
            groupe2.className = "invest-data mt-2";
            groupe2.innerHTML = `
                <div class="invest-data-amount g-2">
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Non conformité interne
                                                    </div>
                                                    <div class="amount text-center">
                                                        ${data.data[0]}
                                                    </div>
                                                </div>
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Réclamation
                                                    </div>
                                                    <div class="amount text-center">
                                                        ${data.data[1]}
                                                    </div>
                                                </div>
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Contentieux
                                                    </div>
                                                    <div class="amount text-center">
                                                        ${data.data[2]}
                                                    </div>
                                                </div>
                                            </div>
            `;

            document.getElementById("camenber_risk").appendChild(groupe);
            document.getElementById("camenber_risk").appendChild(groupe2);

            var ctx = document.getElementById('myChart_risk').getContext('2d');
            var myChart_risk = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Non conformite interne', 'Réclamation', 'Contentieux'],
                    datasets: [{
                        data: data.data,
                        backgroundColor: ['orange', 'skyblue', 'red'],
                        borderColor: 'white',
                        borderWidth: 1
                    }],
                    hoverOffset: 4
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                }
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        searchDate();

        document.getElementById('btn_rech').addEventListener('click', function(){
            searchDate();
        });

        function searchDate() {
            var date1 = document.getElementById('date1').value;
            var date2 = document.getElementById('date2').value;

            $.ajax({
                url: '/get_date',
                method: 'GET',
                data: { date1: date1, date2: date2 }, // Pass date1 and date2 to the server
                success: function (data) {
                    addGroups(data);
                },
                /*error: function () {
                    toastr.error("Une erreur s'est produite lors de la récupération des informations.");
                }*/
            });
        }

        function addGroups(data) {
            var dynamicFields = document.getElementById("camenber2");

            // Supprimer le contenu existant
            while (dynamicFields.firstChild) {
                dynamicFields.removeChild(dynamicFields.firstChild);
            }

            var groupe = document.createElement("div");
            groupe.className = "";
            groupe.innerHTML = `
                <canvas id="myChart2"></canvas>
            `;

            var groupe2 = document.createElement("div");
            groupe2.className = "invest-data mt-2";
            groupe2.innerHTML = `
                <div class="invest-data-amount g-2">
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Non conformité interne
                                                    </div>
                                                    <div class="amount text-center">
                                                        ${data.data[0]}
                                                    </div>
                                                </div>
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Réclamation
                                                    </div>
                                                    <div class="amount text-center">
                                                        ${data.data[1]}
                                                    </div>
                                                </div>
                                                <div class="invest-data-history">
                                                    <div class="title text-center">
                                                        Contentieux
                                                    </div>
                                                    <div class="amount text-center">
                                                        ${data.data[2]}
                                                    </div>
                                                </div>
                                            </div>
            `;

            document.getElementById("camenber2").appendChild(groupe);
            document.getElementById("camenber2").appendChild(groupe2);

            var ctx = document.getElementById('myChart2').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Non conformite interne', 'Réclamation', 'Contentieux'],
                    datasets: [{
                        data: [data.data[0],data.data[1],data.data[2]],
                        backgroundColor: ['orange', 'skyblue', 'red'],
                        borderColor: 'white',
                        borderWidth: 1
                    }],
                    hoverOffset: 4
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                }
            });
        }
    });
</script>

@endsection

