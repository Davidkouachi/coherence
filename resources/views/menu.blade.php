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
