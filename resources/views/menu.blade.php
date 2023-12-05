@extends('app')

@section('titre', 'Accueil')

@section('content')

            <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block justify-items-center">
                        <form class="row g-gs" >
                            <div class="col-lg-12 col-xxl-12" style="margin-bottom: -15px;" >
                                <div class="card card-bordered card-preview" style="margin-top: -15px; background-color: red;">
                                    <div class="" style="height: 30px; display: flex; " >
                                        <label class="form-label" style="font-size: 20px; color: white;margin-left:5px;">
                                            Alert: 
                                        </label>
                                        <marquee>
                                            <label style="font-size: 20px; color: white;">
                                                Nouveau
                                            </label>
                                        </marquee>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xxl-12" >
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner row g-gs">
                                        <div id="carouselExFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active align-items-center justify-content-center"> 
                                                    <img src="images/logo.png" class="d-block w-50" alt="carousel"> 
                                                </div>
                                            </div> 
                                            <a class="carousel-control-prev" href="#carouselExFade" role="button" data-bs-slide="prev"> 
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span> 
                                                <span class="visually-hidden">Previous</span> 
                                            </a> 
                                            <a class="carousel-control-next" href="#carouselExFade" role="button" data-bs-slide="next"> 
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span> 
                                                <span class="visually-hidden">Next</span> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
