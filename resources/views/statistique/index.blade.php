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
                                                        <div class="title text-center">
                                                            Non Conformité.I
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
                                                        <div class="title text-center">
                                                            Soumis
                                                        </div>
                                                        <div class="amount text-center">
                                                            {{ $nbre_ris_soumis }}
                                                        </div>
                                                    </div>
                                                    <div class="invest-data-history">
                                                        <div class="title text-center">
                                                            Rejeter
                                                        </div>
                                                        <div class="amount text-center">
                                                            {{ $nbre_ris_n_valider }}
                                                        </div>
                                                    </div>
                                                    <div class="invest-data-history">
                                                        <div class="title text-center">
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
                                                <em class="icon ni ni-calendar-alt"></em>
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

                        <div class="col-lg-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">
                                                <span class="me-2">
                                                Quelques Risques
                                                </span>
                                            </h6>
                                        </div>
                                        <div class="card-tools">
                                            <ul class="card-tools-nav">
                                                <li>
                                                    <div class="form-group text-center">
                                                        <select class="form-select" id="device">
                                                            <option selected value="fcfa">Fcfa</option>
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

                        <div class="col-lg-12">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-amount mb-2">
                                        <h5>
                                            Tableau des incidents
                                        </h5>
                                    </div>
                                    <table class="datatable-init table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Type</th>
                                                <th>Date de réception</th>
                                                <th>Non conformité</th>
                                                <!--<th>Nombre d'actions</th>-->
                                                <th>Statut</th>
                                                <th>Date de création</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ams as $key => $am)
                                            <tr>
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
                                                <td>{{ \Carbon\Carbon::parse($am->date_fiche)->translatedFormat('j F Y ') }}</td>
                                                <td>{{ $am->non_conformite }}</td>
                                                <!--<td>{{ $am->nbre_action }}</td>-->
                                                @if ($am->statut === 'soumis')
                                                <td>
                                                    <span class="badge badge-dim bg-warning">
                                                        <em class="icon ni ni-stop-circle"></em>
                                                        <span class="fs-12px">En attente de validation</span>
                                                    </span>
                                                </td>
                                                @elseif ($am->statut === 'valider')
                                                <td>
                                                    <span class="badge badge-dim bg-primary">
                                                        <em class="icon ni ni-check"></em>
                                                        <span class="fs-12px">Validé</span>
                                                    </span>
                                                </td>
                                                @elseif ($am->statut === 'non-valider' || $am->statut === 'modif' || $am->statut === 'update')
                                                <td>
                                                    <span class="badge badge-dim bg-danger">
                                                        <em class="icon ni ni-alert"></em>
                                                        <span class="fs-12px">Non Validé</span>
                                                    </span>
                                                </td>
                                                @elseif ($am->statut === 'date_efficacite' )
                                                <td>
                                                    <span class="badge badge-dim bg-warning">
                                                        <em class="icon ni ni-stop-circle"></em>
                                                        <span class="fs-12px">
                                                            En attente de l'évaluation de l'éfficacité
                                                        </span>
                                                    </span>
                                                </td>
                                                @elseif ($am->statut === 'cloturer' )
                                                <td>
                                                    <span class="badge badge-dim bg-success">
                                                        <em class="icon ni ni-check"></em>
                                                        <span class="fs-12px">
                                                            Clôturer
                                                        </span>
                                                    </span>
                                                </td>
                                                @endif
                                                <td>{{ \Carbon\Carbon::parse($am->created_at)->translatedFormat('j F Y '.' à '.' H:i:s') }}</td>
                                                <td>
                                                    <a data-bs-toggle="modal" data-bs-target="#modalDetail{{ $am->id }}" class="btn btn-icon btn-white btn-dim btn-sm btn-warning">
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

    @foreach($ams as $am)
        <div class="modal fade zoom" tabindex="-1" id="modalDetail{{ $am->id }}">
            <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Détails
                            @if ($am->statut === 'soumis')
                                <span class="text-warning"> ( En attente de validation )</span>
                            @elseif ($am->statut === 'valider' )
                                <span class="text-primary"> ( Validé )</span>
                            @elseif ($am->statut === 'non-valider' || $am->statut === 'update' || $am->statut === 'modif')
                                <span class="text-danger"> (Non Validé )</span>
                            @elseif ($am->statut === 'date_efficacite' )
                                <span class="text-warning"> ( En attente de l'évaluation de l'éfficacité )</span>
                            @elseif ($am->statut === 'cloturer' )
                                <span class="text-success"> ( Clôturer )</span>
                            @endif
                        </h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                    </div>
                    <div class="modal-body">
                        <form class="nk-block">
                            <div class="row g-gs">
                                <div class="col-md-12 col-xxl-12" id="groupesContainer">
                                    <div class="">
                                        <div class="card-inner">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
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
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Date de reception
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ \Carbon\Carbon::parse($am->date_fiche)->translatedFormat('j F Y ') }}" readonly type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Date Limite de traitement
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ \Carbon\Carbon::parse($am->date_limite)->translatedFormat('j F Y ') }}" readonly type="text" class="form-control" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Nombres de jours
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $am->nbre_jour }}" readonly type="text" class="form-control" id="Cause">
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
                                            @foreach($actionsData[$am->id] as $key => $actions)
                                            <div class="card-head mt-3">
                                                <h5 class="card-title">
                                                    Action Corrective {{ $key+1 }}
                                                </h5>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group ">
                                                        <label class="form-label" for="Cause">
                                                            Action
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $actions['action'] }}" readonly type="text" class="form-control " id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group ">
                                                        <label class="form-label" for="Cause">
                                                            risque
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $actions['risque'] }}" readonly type="text" class="form-control " id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group ">
                                                        <label class="form-label" for="Cause">
                                                            Processus
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ $actions['processus'] }}" readonly type="text" class="form-control " id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @if ($actions['statut'] === 'realiser')
                                                <div class="col-lg-4">
                                                    <div class="form-group ">
                                                        <label class="form-label" for="Cause">
                                                            Délai
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ \Carbon\Carbon::parse($actions['delai'])->translatedFormat('j F Y ') }}" readonly type="text" class="form-control " id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group ">
                                                        <label class="form-label" for="Cause">
                                                            Date de realisation
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ \Carbon\Carbon::parse($actions['date_action'])->translatedFormat('j F Y ') }}" readonly type="text" class="form-control " id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group ">
                                                        <label class="form-label" for="Cause">
                                                            Date du Suivi
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ \Carbon\Carbon::parse($actions['date_suivi'])->translatedFormat('j F Y '.' à '.' H:i:s') }}" readonly type="text" class="form-control " id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group ">
                                                        <label class="form-label" for="Cause">
                                                            Statut
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="Action Réaliser" readonly type="text" class="form-control text-center bg-success" id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                    @if($actions['efficacite'] === 'oui')
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Efficacité
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="Oui" readonly type="text" class="form-control text-center bg-success" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Cause">
                                                                Efficacité
                                                            </label>
                                                            <div class="form-control-wrap">
                                                                <input value="Non" readonly type="text" class="form-control text-center bg-danger" id="Cause">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @else
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Délai
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="{{ \Carbon\Carbon::parse($actions['delai'])->translatedFormat('j F Y ') }}" readonly type="text" class="form-control " id="Cause">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="Cause">
                                                            Statut
                                                        </label>
                                                        <div class="form-control-wrap">
                                                            <input value="Action non réaliser" readonly type="text" class="form-control text-center bg-danger" id="Cause">
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
                                            @endforeach
                                            <div class="row g-4" >
                                                @if($am->date1 !== null)
                                                    <div class="col-md-12 col-xxl-122" id="groupesContainer">
                                                        <div class="card ">
                                                            <div class="card-inner">
                                                                <div class="card-head">
                                                                    <h5 class="card-title">
                                                                        Efficacité
                                                                    </h5>
                                                                </div>
                                                                <div class="row g-4">
                                                                    @if($am->date1 !== null)
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="Cause">
                                                                                Du
                                                                            </label>
                                                                            <div class="form-control-wrap">
                                                                                <input value="{{ \Carbon\Carbon::parse($am->date1)->translatedFormat('j F Y ') }}" readonly type="text" class="form-control" id="Cause">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="Cause">
                                                                                au
                                                                            </label>
                                                                            <div class="form-control-wrap">
                                                                                <input value="{{ \Carbon\Carbon::parse($am->date2)->translatedFormat('j F Y ') }}" readonly type="text" class="form-control" id="Cause">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                        $startDate = \Carbon\Carbon::parse($am->date1);
                                                                        $endDate = \Carbon\Carbon::parse($am->date2);
                                                                        $daysDifference = $startDate->diffInDays($endDate);
                                                                    @endphp
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="Cause">
                                                                                Nombre de jour(S)
                                                                            </label>
                                                                            <div class="form-control-wrap">
                                                                                <input value="{{ $daysDifference }}" readonly type="text" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @if($am->efficacite !== null)
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="Cause">
                                                                                Action efficace
                                                                            </label>
                                                                            @if ($am->efficacite === 'oui')
                                                                            <div class="form-control-wrap">
                                                                                <input value="{{ $am->efficacite }}" readonly type="text" class="form-control bg-success text-center" id="Cause">
                                                                            </div>
                                                                            @endif
                                                                            @if ($am->efficacite === 'non')
                                                                            <div class="form-control-wrap">
                                                                                <input value="{{ $am->efficacite }}" readonly type="text" class="form-control bg-danger text-center" id="Cause">
                                                                            </div>
                                                                            @endif
                                                                        </div>
                                                                        @if ($am->date_eff !== null)
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="Cause">
                                                                                Date de verification de l'éfficacité
                                                                            </label>
                                                                            @if ($am->date1 <= $am->date_eff && $am->date2 >= $am->date_eff)
                                                                                <div class="form-control-wrap">
                                                                                    <input value="{{ \Carbon\Carbon::parse($am->eff)->translatedFormat('j F Y ') }}" readonly type="text" class="form-control text-center bg-success" id="Cause">
                                                                                </div>
                                                                            @elseif ($am->date1 > $am->date_eff && $am->date2 >= $am->date_eff || $am->date1 <= $am->date_eff && $am->date2 < $am->date_eff)
                                                                                <div class="form-control-wrap">
                                                                                    <input value="{{ \Carbon\Carbon::parse($am->eff)->translatedFormat('j F Y ') }}" readonly type="text" class="form-control text-center bg-danger" id="Cause">
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        @else
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="Cause">
                                                                                Date de verification de l'éfficacité
                                                                            </label>
                                                                            <div class="form-control-wrap">
                                                                                <input value="Néant" readonly type="text" class="form-control" id="Cause">
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="Cause">
                                                                                Commentaire
                                                                            </label>
                                                                            <div class="form-control-wrap">
                                                                                <textarea readonly required name="causes" class="form-control no-resize" id="default-textarea">{{ $am->commentaire_eff }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if ($am->date1 <= $am->date_eff && $am->date2 >= $am->date_eff)
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group text-center">
                                                                                <div class="form-control-wrap">
                                                                                    <input value="Vérification éffectuée dans les delais" readonly type="text" class="form-control text-center bg-success" id="Cause">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif ($am->date1 > $am->date_eff && $am->date2 >= $am->date_eff || $am->date1 <= $am->date_eff && $am->date2 < $am->date_eff)
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group text-center">
                                                                                <div class="form-control-wrap">
                                                                                    <input value="Vérification éffectuée hors delais" readonly type="text" class="form-control text-center bg-warning" id="Cause">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
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

