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

                        <div class="col-lg-12 ">
                            <div class="card card-bordered  card-full">
                                <div class="card-inner">
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <h5 class="text-center text-primary">Processus</h5>
                                                <div class="amount text-center">{{ $nbre_processus }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <h5 class="text-center text-primary">Risques</h5>
                                                <div class="amount text-center">{{ $nbre_risque }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <h5 class="text-center text-primary">Causes</h5>
                                                <div class="amount text-center">{{ $nbre_cause }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <h5 class="text-center text-primary">Incidents</h5>
                                                <div class="amount text-center">{{ $nbre_am }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <h5 class="text-center text-primary">Actions préventives</h5>
                                                <div class="amount text-center">{{ $nbre_ap }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <h5 class="text-center text-primary">Actions correctives</h5>
                                                <div class="amount text-center">{{ $nbre_ac }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <h5 class="text-center text-primary">Utilisateurs</h5>
                                                <div class="amount text-center">{{ $nbre_user }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <h5 class="text-center text-primary">Postes</h5>
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

                        <div class="col-lg-12">
                            <div class="card card-bordered card-full">
                                <div class="card-inner row g-gs">
                                    <div class="card-amount">
                                        <h5>
                                            <span class="me-2" >
                                                Type d'incidents
                                            </span>
                                            <em class="ni ni-share-alt"></em>
                                        </h5>
                                    </div>
                                @foreach ($statistics as $type => $stat)
                                    <div class="col-lg-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-amount">
                                                    <h5 class="">
                                                        @if ($type === 'non_conformite_interne')
                                                            Non conformité Interne
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
                                                    </h5>
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
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card card-bordered card-full">
                                <div class="card-inner row g-gs">
                                    <div class="card-amount">
                                        <h5>
                                            <span class="me-2" >
                                                Recherche
                                            </span>
                                            <em class="ni ni-search"></em>
                                        </h5>
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
                                                <div id="camenber_risk"></div>
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
                                                <div id="camenber2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group mb-1">
                                        <div class="card-title">
                                            <h6 class="title">
                                                Vue d'ensemble des incidents ({{ $nbre_am }})
                                            </h6>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs nav-tabs-card nav-tabs-xs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#type">
                                                Type 
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#incident">
                                                Statuts 
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-0">
                                        <div class="tab-pane active" id="type" >
                                            <div class="invest-data mt-3">
                                                <div class="invest-data-amount g-2">
                                                    <div class="invest-data-history">
                                                        <div class="title text-center text-primary">
                                                            Non Conformité Interne
                                                        </div>
                                                        <div class="amount text-center">
                                                            {{ $nbre_am_nci }}
                                                        </div>
                                                    </div>
                                                    <div class="invest-data-history">
                                                        <div class="title text-center text-danger">
                                                            Réclamations
                                                        </div>
                                                        <div class="amount text-center">
                                                            {{ $nbre_am_r }}
                                                        </div>
                                                    </div>
                                                    <div class="invest-data-history">
                                                        <div class="title text-center text-warning">
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
                                                        labels: ['Non conformité Interne', 'Réclamations', 'Contentieux'],
                                                        datasets: [{
                                                            label: 'Histogramme',
                                                            data: [ {{ $nbre_am_nci }}, {{ $nbre_am_r }}, {{ $nbre_am_c }} ],
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
                                        </div>
                                        <div class="tab-pane" id="incident" >
                                            <div class="invest-ov gy-2" >
                                                <div class="card-inner d-flex flex-column ">
                                                    <div class="progress-list gy-3">
                                                        <div class="progress-wrap">
                                                            <div class="progress-text">
                                                                <div class="progress-label">
                                                                    Soumis ({{$staut_am_soumis}})
                                                                </div>
                                                                <div class="progress-amount">
                                                                    @if($nbre_am != 0)
                                                                        {{ number_format(($staut_am_soumis / $nbre_am)*100 , 2) }} %
                                                                    @else
                                                                        0.00 %
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-md">
                                                                @php
                                                                    if ($nbre_am != 0) {
                                                                       $sam_soumis = number_format(($staut_am_soumis / $nbre_am)*100 , 0);
                                                                    }else{ $sam_soumis = '0';  }
                                                                @endphp
                                                                <div class="progress-bar bg-warning" data-progress="{{$sam_soumis}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress-wrap">
                                                            <div class="progress-text">
                                                                <div class="progress-label">
                                                                    Rejeter ({{$staut_am_rejeter}})
                                                                </div>
                                                                <div class="progress-amount">
                                                                    @if($nbre_am != 0)
                                                                        {{ number_format(($staut_am_rejeter / $nbre_am)*100 , 2) }} %
                                                                    @else
                                                                        0.00 %
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-md">
                                                                @php
                                                                    if ($nbre_am != 0) {
                                                                       $sam_rejeter = number_format(($staut_am_rejeter / $nbre_am)*100 , 0);
                                                                    }else{ $sam_rejeter = '0';  }
                                                                @endphp
                                                                <div class="progress-bar bg-danger" data-progress="{{$sam_rejeter}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress-wrap">
                                                            <div class="progress-text">
                                                                <div class="progress-label">
                                                                    Valider ({{$staut_am_valider}})
                                                                </div>
                                                                <div class="progress-amount">
                                                                    @if($nbre_am != 0)
                                                                        {{ number_format(($staut_am_valider / $nbre_am)*100 , 2) }} %
                                                                    @else
                                                                        0.00 %
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-md">
                                                                @php
                                                                    if ($nbre_am != 0) {
                                                                       $sam_valider = number_format(($staut_am_valider / $nbre_am)*100 , 0);
                                                                    }else{ $sam_valider = '0';  }
                                                                @endphp
                                                                <div class="progress-bar bg-primary" data-progress="{{$sam_valider}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress-wrap">
                                                            <div class="progress-text">
                                                                <div class="progress-label">
                                                                    Evaluation éfficacitée en cours  ({{$staut_am_eff}})
                                                                </div>
                                                                <div class="progress-amount">
                                                                    @if($nbre_am != 0)
                                                                        {{ number_format(($staut_am_eff / $nbre_am)*100 , 2) }} %
                                                                    @else
                                                                        0.00 %
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-md">
                                                                @php
                                                                    if ($nbre_am != 0) {
                                                                       $sam_eff = number_format(($staut_am_clotu / $nbre_am)*100 , 0);
                                                                    }else{ $sam_eff = '0';  }
                                                                @endphp
                                                                <div class="progress-bar bg-warning" data-progress="{{$sam_eff}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress-wrap">
                                                            <div class="progress-text">
                                                                <div class="progress-label">
                                                                    Clôturé ({{$staut_am_clotu}})
                                                                </div>
                                                                <div class="progress-amount">
                                                                    @if($nbre_am != 0)
                                                                        {{ number_format(($staut_am_clotu / $nbre_am)*100 , 2) }} %
                                                                    @else
                                                                        0.00 %
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-md">
                                                                @php
                                                                    if ($nbre_am != 0) {
                                                                       $sclotu = number_format(($staut_am_clotu / $nbre_am)*100 , 0);
                                                                    }else{ $sclotu = '0';  }
                                                                @endphp
                                                                <div class="progress-bar bg-success" data-progress="{{$sclotu}}">
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

                        <div class="col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group mb-1">
                                        <div class="card-title">
                                            <h6 class="title">
                                                Vue d'ensemble des risques ({{ $nbre_risque }})
                                            </h6>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs nav-tabs-card nav-tabs-xs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#statutr">
                                                Statuts
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " data-bs-toggle="tab" href="#ap">
                                                Action prventives ({{ $nbre_ap }})
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-0">
                                        <div class="tab-pane active" id="statutr">
                                            <div class="invest-data mt-3">
                                                <div class="invest-data-amount g-2">
                                                    <div class="invest-data-history">
                                                        <div class="title text-center text-warning">
                                                            Soumis
                                                        </div>
                                                        <div class="amount text-center">
                                                            {{ $nbre_ris_soumis }}
                                                        </div>
                                                    </div>
                                                    <div class="invest-data-history">
                                                        <div class="title text-center text-danger">
                                                            Rejeter
                                                        </div>
                                                        <div class="amount text-center">
                                                            {{ $nbre_ris_n_valider }}
                                                        </div>
                                                    </div>
                                                    <div class="invest-data-history">
                                                        <div class="title text-center text-success">
                                                            Valider
                                                        </div>
                                                        <div class="amount text-center">
                                                            {{ $nbre_ris_valider }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <canvas id="myChartii"></canvas>
                                            </div>
                                            <script>
                                                var ctx = document.getElementById('myChartii').getContext('2d');
                                                var myChart = new Chart(ctx, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: ['Soumis', 'Rejeter', 'Valider'],
                                                        datasets: [{
                                                            label: 'Histogramme',
                                                            data: [ {{ $nbre_ris_soumis }}, {{ $nbre_ris_n_valider }}, {{ $nbre_ris_valider }} ],
                                                            backgroundColor: [
                                                                'orange',
                                                                'red',
                                                                'green'
                                                            ],
                                                            borderColor: 'white',
                                                            borderWidth: 1
                                                        }]
                                                    },
                                                    options: {
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                                ticks: {
                                                                    stepSize: 10 
                                                                }
                                                            }
                                                        }
                                                    }
                                                });
                                            </script>
                                        </div>
                                        <div class="tab-pane " id="ap">
                                            <div class="invest-ov gy-2" >
                                                <div class="card-inner d-flex flex-column ">
                                                    <div class="progress-list gy-3">
                                                        <div class="progress-wrap">
                                                            <div class="progress-text">
                                                                <div class="progress-label">
                                                                    Soumis ({{$nbre_ris_soumis}})
                                                                </div>
                                                                <div class="progress-amount">
                                                                    @if($nbre_risque != 0)
                                                                        {{ number_format(($nbre_ris_soumis / $nbre_risque)*100 , 2) }} %
                                                                    @else
                                                                        0.00 %
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-md">
                                                                @php
                                                                    if ($nbre_risque != 0) {
                                                                       $sris_soumis = number_format(($nbre_ris_soumis / $nbre_risque)*100 , 0);
                                                                    }else{ $sris_soumis = '0';  }
                                                                @endphp
                                                                <div class="progress-bar bg-warning" data-progress="{{$sris_soumis}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress-wrap">
                                                            <div class="progress-text">
                                                                <div class="progress-label">
                                                                    Rejeter ({{$nbre_ris_n_valider}})
                                                                </div>
                                                                <div class="progress-amount">
                                                                    @if($nbre_risque != 0)
                                                                        {{ number_format(($nbre_ris_n_valider / $nbre_risque)*100 , 2) }} %
                                                                    @else
                                                                        0.00 %
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-md">
                                                                @php
                                                                    if ($nbre_risque != 0) {
                                                                       $sris_n_valider = number_format(($nbre_ris_n_valider / $nbre_risque)*100 , 0);
                                                                    }else{ $sris_n_valider = '0';  }
                                                                @endphp
                                                                <div class="progress-bar bg-danger" data-progress="{{$sris_n_valider}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress-wrap">
                                                            <div class="progress-text">
                                                                <div class="progress-label">
                                                                    Valider ({{$nbre_ris_valider}})
                                                                </div>
                                                                <div class="progress-amount">
                                                                    @if($nbre_risque != 0)
                                                                        {{ number_format(($nbre_ris_valider / $nbre_risque)*100 , 2) }} %
                                                                    @else
                                                                        0.00 %
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-md">
                                                                @php
                                                                    if ($nbre_risque != 0) {
                                                                       $sris_valider = number_format(($nbre_ris_valider / $nbre_risque)*100 , 0);
                                                                    }else{ $sris_valider = '0';  }
                                                                @endphp
                                                                <div class="progress-bar bg-success" data-progress="{{$sris_valider}}">
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

                        <div class="col-lg-4">
                            <div class="card card-bordered h-100">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">
                                                Historiques
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-inner">
                                    <div class="timeline">
                                        <h6 class="timeline-head">
                                            10 dernières actions
                                        </h6>
                                        <ul class="timeline-list" style="height: 250px;" data-simplebar="" >
                                            @foreach ($his as $hi)
                                            <li class="timeline-item">
                                                <em class="icon ni ni-calendar-alt text-primary "></em>
                                                <div class="timeline-date">
                                                    {{ \Carbon\Carbon::parse($hi->created_at)->translatedFormat('j F Y') }}
                                                </div>
                                                <div class="timeline-data">
                                                    <h6 class="timeline-title">
                                                        {{$hi->nom_formulaire}}
                                                    </h6>
                                                    <div class="timeline-des">
                                                        <p>
                                                            <span class="timeline-title" >
                                                                Action :
                                                            </span>
                                                            {{$hi->nom_action}}.
                                                        </p>
                                                        <span class="time">
                                                            <em class="icon ni ni-alarm-alt"></em>
                                                            {{ \Carbon\Carbon::parse($hi->created_at)->translatedFormat('H:i:s') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group mb-1">
                                        <div class="card-title">
                                            <h6 class="title">
                                                Vue d'ensemble des risques ({{ $nbre_risque }})
                                            </h6>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs nav-tabs-card nav-tabs-xs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#pro">
                                                Processus
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#ris">
                                                Risques
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-0">
                                        <div class="tab-pane active" id="pro">
                                            <div class="card-inner">
                                                <table class="datatable-init table">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Position</th>
                                                            <th>Office</th>
                                                            <th>Age</th>
                                                            <th>Start date</th>
                                                            <th>Salary</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($types_processus as $value)
                                                        <tr>
                                                            <td>{{$value->nom}}</td>
                                                            <td>{{$value->nbre_nci}}</td>
                                                            <td>{{$value->nbre_r}}</td>
                                                            <td>{{$value->nbre_c}}</td>
                                                            <td>2011/04/25</td>
                                                            <td>$320,800</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="ris">
                                            <div class="card-inner">
                                                <table class="datatable-init table">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Position</th>
                                                            <th>Office</th>
                                                            <th>Age</th>
                                                            <th>Start date</th>
                                                            <th>Salary</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($types_risque as $value)
                                                        <tr>
                                                            <td>{{$value->nom}}</td>
                                                            <td>{{$value->nbre_nci}}</td>
                                                            <td>{{$value->nbre_r}}</td>
                                                            <td>{{$value->nbre_c}}</td>
                                                            <td>2011/04/25</td>
                                                            <td>$320,800</td>
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

