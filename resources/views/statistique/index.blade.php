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
                                                <div class="amount text-center">{{ $nbre_ed_ap }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Hors délais</div>
                                                <div class="amount text-center">{{ $nbre_ehd_ap }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Non Réaliser</div>
                                                <div class="amount text-center">{{ $nbre_hd_ap }}</div>
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
                                        <span class="amount">Action Corrective ({{ $nbre_ac }})</span>
                                    </div>
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <div class="title text-center">Dans les délais</div>
                                                <div class="amount text-center">{{ $nbre_ed_ac }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Hors délais</div>
                                                <div class="amount text-center">{{ $nbre_ehd_ac }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title text-center">Non Réaliser</div>
                                                <div class="amount text-center">{{ $nbre_hd_ac }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($statistics as $type => $stat)
                            <div class="col-lg-4">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner">
                                        <div class="card-amount">
                                            <span class="amount">
                                                @if ($type === 'non_conformite_interne')
                                                    Non Conformité  
                                                @endif
                                                @if ($type === 'reclamation')
                                                    Réclamation
                                                @endif
                                                @if ($type === 'contentieux')
                                                     Contentieux
                                                @endif
                                                <span class="currency currency-usd">
                                                    ({{ $stat['total'] }})
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
                            <div class="col-lg-6">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner" >
                                        <div class="form-group text-center">
                                            <label class="form-label" for="cf-full-name">Processus</label>
                                            <select name="processus_id" class="form-select text-center" id="selectProcessus">
                                                <option value="">
                                                    Choisir un processus
                                                </option>
                                                @foreach ($processus as $processus)
                                                <option value="{{$processus->id}}">
                                                    {{$processus->nom}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="camenber">

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner">
                                        <div class="form-group text-center">
                                            <label class="form-label">Choisir un interval de date</label>
                                            <div class="form-control-wrap">
                                                <div class="input-daterange date-picker-range input-group">
                                                    <input data-date-format="yyyy-mm-dd" name="date1" id="date1" type="text" class="form-control" />
                                                    <div class="input-group-addon">TO</div>
                                                    <input data-date-format="yyyy-mm-dd" name="date2" id="date2" type="text" class="form-control me-2" />
                                                    <button id="btn_rech" class="btn btn-outline-success" >
                                                        <em class="ni ni-search" ></em>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="camenber2">

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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Écouteur pour le changement de sélection
        document.getElementById('selectProcessus').addEventListener('change', function() {
            var selectedProcessus = this.value;
            if (selectedProcessus !== '') {
                $.ajax({
                    url: '/get_processus/' + selectedProcessus,
                    method: 'GET',
                    success: function (data) {
                        addGroups(selectedProcessus, data);
                    },
                    error: function () {
                        toastr.info("Aucune données n'a été trouver.");
                    }
                });
            } else {
                toastr.warning("Veuillez selectionner un processus.");
            }
        });

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
                    labels: ['non_conformite_interne', 'reclamation', 'contentieux'],
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
        // Écouteur pour le changement de sélection
        document.getElementById('btn_rech').addEventListener('click', function() {
            var date1 = document.getElementById('date1').value;
            var date2 = document.getElementById('date2').value;

            $.ajax({
                url: '/get_date',
                method: 'GET',
                data: { date1: date1, date2: date2 }, // Pass date1 and date2 to the server
                success: function (data) {
                    addGroups(data);
                },
                error: function () {
                    toastr.error("Une erreur s'est produite lors de la récupération des informations.");
                }
            });
        });

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
                    labels: ['non_conformite_interne', 'reclamation', 'contentieux'],
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

