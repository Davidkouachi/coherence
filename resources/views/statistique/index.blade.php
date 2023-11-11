@extends('app')

@section('titre', 'Statistique')

@section('content')

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="text-center">
                                Statistique
                            </h3>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a class="btn btn-white btn-dim btn-outline-primary" href="{{ route('index_accueil') }}">
                                    <em class="icon ni ni-home"></em>
                                    <span>Accueil</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="row g-gs">
                        @foreach ($statistics as $type => $stat)
                            <div class="col-md-4">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner">
                                        <div class="card-amount">
                                            <span class="amount">
                                                @if ($type === 'non_conformite_interne')
                                                    Non Conformité Interne
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
                                                type: 'doughnut',
                                                data: {
                                                    labels: ['Causes', 'Risques', 'Néant'],
                                                    datasets: [{
                                                        data: [{{ $stat['causes'] }}, {{ $stat['risques'] }}, {{ $stat['causes_risques_nt'] }}],
                                                        backgroundColor: ['blue', 'red', 'orange'],
                                                        borderColor: 'white',
                                                        borderWidth: 1
                                                    }]
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
                                        </script>

                                        <div class="card-amount">
                                            <div >
                                                <a class="btn btn-outline-warning btn-dim">
                                                    <span  class="me-2" >Voir plus</span>
                                                    <span>
                                                        <em class="ni ni-chevron-right-circle" > </em>
                                                    </span>
                                                </a>
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
    </div>
</div>

@endsection

