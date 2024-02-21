@extends('app')

@section('titre', 'Liste des Utilisateurs')

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
                                            <span>Liste des Utilisateurs</span>
                                            <em class="icon ni ni-list-index"></em>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-lg-12 col-xxl-12">
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                        <table class="datatable-init table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Matricule</th>
                                                    <th>Nom et Prénoms</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Poste</th>
                                                    <th>Date de création</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $key => $user)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $user->matricule }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->tel }}</td>
                                                        <td>{{ $user->poste }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('j F Y '.' à '.' h:i:s') }}</td>
                                                        <td>
                                                        	<div class="d-flex">
															    <form method="post" action="{{ route('index_user_modif') }}">
															        @csrf
															        <input type="text" name="id" value="{{ $user->id }}" style="display: none;">
															        <a data-bs-toggle="modal"
		                                                                data-bs-target="#modalDetail{{ $user->id }}"
		                                                                href="#" class="btn btn-icon btn-white btn-dim btn-sm btn-warning">
		                                                                <em class="icon ni ni-eye"></em>
		                                                            </a>
															        <button type="submit" class="btn btn-icon btn-white btn-dim btn-sm btn-info">
															            <em class="icon ni ni-edit"></em>
															        </button>
															    </form>
															</div>
                                                            <!--<a data-bs-toggle="modal"
                                                                data-bs-target="#modalModif{{ $user->id }}"
                                                                href="#" class="btn btn-icon btn-white btn-dim btn-sm btn-info">
                                                                <em class="icon ni ni-edit"></em>
                                                            </a>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#modalConfirmelock"
                                                                href="#" class="btn btn-icon btn-white btn-dim btn-sm btn-danger">
                                                                <em class="icon ni ni-lock"></em>
                                                            </a>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#modalConfirmeunlock"
                                                                href="#" class="btn btn-icon btn-white btn-dim btn-sm btn-success">
                                                                <em class="icon ni ni-unlock"></em>
                                                            </a>-->
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

    @foreach($users as $key => $user)
        <div class="modal fade zoom" tabindex="-1" id="modalDetail{{ $user->id }}">
		    <div class="modal-dialog modal-lg" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h5 class="modal-title">Informations</h5>
		                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
		            </div>
		            <div class="modal-body">
		                <form class="nk-block">
		                    <div class="row g-gs">
		                        <div class="col-lg-12">
		                            <div class="row g-gs">
		                                <div class="col-lg-12 " id="groupesContainer">
		                                    <div class="card ">
		                                        <div class="card-inner">
		                                            <div class="row g-4">
		                                                <div class="col-lg-12">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="Cause">
		                                                            Matricule
		                                                        </label>
		                                                        <div class="form-control-wrap">
		                                                            <input value="{{ $user->matricule }}" type="text" class="form-control" readonly>
		                                                        </div>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-12">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="Cause">
		                                                            Nom et Prénoms
		                                                        </label>
		                                                        <div class="form-control-wrap">
		                                                            <input value="{{ $user->name }}" type="text" class="form-control" readonly>
		                                                        </div>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-12">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="corectif">
		                                                            Email
		                                                        </label>
		                                                        <div class="form-control-wrap">
		                                                            <input value="{{ $user->email }}" readonly type="text" class="form-control">
		                                                        </div>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="preventif">
		                                                            Contact
		                                                        </label>
		                                                        <div class="form-control-wrap">
		                                                            <input value="{{ $user->tel }}" readonly type="text" class="form-control">
		                                                        </div>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="preventif">
		                                                            Poste
		                                                        </label>
		                                                        <div class="form-control-wrap">
		                                                            <input value="{{ $user->poste }}" readonly type="text" class="form-control">
		                                                        </div>
		                                                    </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-lg-12">
		                            <div class="row g-gs">
		                                <div class="col-lg-12 ">
		                                    <div class="card">
		                                        <div class="card-inner">
		                                            <div class="card-head">
		                                                <h5 class="card-title">
		                                                    Autorisation des différentes fenêtres
		                                                </h5>
		                                            </div>
		                                            <div class="row g-4">
		                                                <div class="col-lg-12">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="Cause">
		                                                            ADMINISTRATION
		                                                        </label>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title text-right">
		                                                        	@if ($user->new_user === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->new_user === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                        	Nouveau Utilisateur
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	@if ($user->list_user === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->list_user === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Liste des Utilisateurs
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->new_poste === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->new_poste === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Nouveau Poste
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->list_poste === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->list_poste === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Liste des Postes
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->historiq === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->historiq === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Historique
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->stat === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->stat === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Statistique
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-12">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="Cause">
		                                                            PROCESSUS
		                                                        </label>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
			                                                        
			                                                        @if ($user->new_proces === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->new_proces === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Nouveau Processus
			                                                    </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->list_proces === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->list_proces === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Liste des Processus
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->eva_proces === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->eva_proces === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Evaluation des Processus
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-12">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="Cause">
		                                                            RISQUE
		                                                        </label>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->new_risk === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->new_risk === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Nouveau Risque
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->list_risk === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->list_risk === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Liste des Risques
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->val_risk === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->val_risk === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Validation des Risques
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->act_n_val === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->act_n_val === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Risques non validés
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->color_para === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->color_para === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Paramettrage des couleurs
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-12">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="Cause">
		                                                            CAUSES
		                                                        </label>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->list_cause === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->list_cause === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Liste des causes
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-12">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="Cause">
		                                                            ACTIONS
		                                                        </label>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->suivi_actp === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->suivi_actp === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Suivis des actions préventives
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->list_actp === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->list_actp === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Liste des actions préventives
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->suivi_actc === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->suivi_actc === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Suivis des actions correctives
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->list_actc === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->list_actc === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Liste des actions correctives
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <!--<div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	Actions correctives éffectuées
		                                                        	@if ($user->list_actc_eff === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->list_actc_eff === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                        </span>
		                                                    </div>
		                                                </div>-->
		                                                <div class="col-lg-12">
		                                                    <div class="form-group">
		                                                        <label class="form-label" for="Cause">
		                                                            INCIDENTS
		                                                        </label>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->fiche_am === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->fiche_am === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Nouvel incident
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->list_am === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->list_am === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Suivis des incidents
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->val_am === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->val_am === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Validation des incidents
		                                                        </span>
		                                                    </div>
		                                                </div>
		                                                <div class="col-lg-6">
		                                                    <div class="form-group align-items-center justify-content-center">
		                                                        <span class="preview-title overline-title">
		                                                        	
		                                                        	@if ($user->am_n_val === 'oui')
		                                                        	<a class="btn btn-sm btn-success">
		                                                                <em class="icon ni ni-check"></em>
		                                                            </a>
		                                                            @endif
		                                                            @if ($user->am_n_val === 'non')
		                                                            <a class="btn btn-sm btn-danger">
		                                                                <em class="icon ni ni-cross"></em>
		                                                            </a>
		                                                            @endif
		                                                            Incidents non validés
		                                                        </span>
		                                                    </div>
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

	@foreach($users as $key => $user)
        <div class="modal fade zoom" tabindex="-1" id="modalModif{{ $user->id }}">
		    <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h5 class="modal-title">Modification des Autorisations</h5>
		                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
		            </div>
		            <div class="modal-body">
		                <form class="nk-block" method="post" action="{{ route('index_modif_auto') }}">
		                	@csrf
		                    <div class="row g-gs">
		                        <div class="col-lg-12">
		                            <div class="row g-gs">
		                                <div class="col-lg-12 ">
		                                    <div class="card">
		                                        <div class="card-inner">
		                                            <input style="display: none" name="user_id" type="text" value="{{ $user->id }}">
		                                            <div class="row g-4">

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    ADMINISTRATION
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Nouveau Utilisateur</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio1" name="new_user"
                                                                                @php 
                                                                                	if ($user->new_user === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp
                                                                                 class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio1">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio2" name="new_user" 
                                                                                @php 
                                                                                	if ($user->new_user === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio2">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Lise des Utilisateurs</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio1l" name="list_user"
                                                                                @php 
                                                                                	if ($user->list_user === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp
                                                                                class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio1l">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio2ll" name="list_user" @php 
                                                                                	if ($user->list_user === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio2ll">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Nouveau Poste</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio3" name="new_poste"
                                                                                @php 
                                                                                	if ($user->new_poste === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp
                                                                                 class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio3">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio4" name="new_poste" @php 
                                                                                	if ($user->new_poste === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio4">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Lise des Postes</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio33" name="list_poste"
                                                                                @php 
                                                                                	if ($user->list_poste === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp
                                                                                 class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio33">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio44" name="list_poste" @php 
                                                                                	if ($user->list_poste === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio44">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Historique</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio5" name="historiq"
                                                                                @php 
                                                                                	if ($user->historiq === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp
                                                                                class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio5">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio6" name="historiq" @php 
                                                                                	if ($user->historiq === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio6">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Statistique</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio7" @php 
                                                                                	if ($user->stat === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="stat" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio7">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio8" @php 
                                                                                	if ($user->stat === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="stat" class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio8">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    PROCESSUS
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Nouveau Processus</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio9" @php 
                                                                                	if ($user->new_proces === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="new_proces" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio9">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio10" name="new_proces" @php 
                                                                                	if ($user->new_proces === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio10">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Liste des Processus</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio11" @php 
                                                                                	if ($user->list_proces === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="list_proces" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio11">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio12" name="list_proces" @php 
                                                                                	if ($user->list_proces === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp  class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio12">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Evaluation des Processus</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio11ev" @php 
                                                                                	if ($user->eva_proces === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp  name="eva_proces" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio11ev">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio12evv" name="eva_proces" @php 
                                                                                	if ($user->eva_proces === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp  class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio12evv">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    Risque
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Nouveau Risque</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio13" @php 
                                                                                	if ($user->new_risk === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp  name="new_risk" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio13">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio14" name="new_risk" @php 
                                                                                	if ($user->new_risk === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio14">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Liste des Risques</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio15" @php 
                                                                                	if ($user->list_risk === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="list_risk" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio15">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio16" name="list_risk" @php 
                                                                                	if ($user->list_risk === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio16">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Validation des risques</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio0" @php 
                                                                                	if ($user->val_risk === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="val_risk" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio0">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio00" name="val_risk" @php 
                                                                                	if ($user->val_risk === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio00">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Risques non validés</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio0n" @php 
                                                                                	if ($user->act_n_val === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="act_n_val" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio0n">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio00n" name="act_n_val" @php 
                                                                                	if ($user->act_n_val === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio00n">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Paramettrage des couleurs</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio0nc" @php 
                                                                                	if ($user->color_para === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="color_para" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio0nc">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio00nc" name="color_para" @php 
                                                                                	if ($user->color_para === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio00nc">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    ACTIONS
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Suivis des actions préventives</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio17sp" @php 
                                                                                	if ($user->suivi_actp === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="suivi_actp" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio17sp">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio18sp" name="suivi_actp" @php 
                                                                                	if ($user->suivi_actp === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio18sp">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Liste des actions préventives</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio17spp" @php 
                                                                                	if ($user->list_actp === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="list_actp" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio17spp">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio18spp" name="list_actp" @php 
                                                                                	if ($user->list_actp === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio18spp">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Suivi des actions correctives</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio19sa" @php 
                                                                                	if ($user->suivi_actc === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="suivi_actc" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio19sa">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio20sa" name="suivi_actc" @php 
                                                                                	if ($user->suivi_actc === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio20sa">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Actions correctives éffectuées</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio19saf" @php 
                                                                                	if ($user->list_actc_eff === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="list_actc_eff" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio19saf">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio20saf" name="list_actc_eff" @php 
                                                                                	if ($user->list_actc_eff === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio20saf">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Liste des actions correctives</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio19safl" @php 
                                                                                	if ($user->list_actc === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="list_actc" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio19safl">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio20safl" name="list_actc" @php 
                                                                                	if ($user->list_actc === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio20safl">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="Cause">
                                                                    INCIDENTS
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Nouvel incident</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio13am" @php 
                                                                                	if ($user->fiche_am === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="fiche_am" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio13am">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio14am" name="fiche_am" @php 
                                                                                	if ($user->fiche_am === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio14am">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Suivis des incidents</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio15am" @php 
                                                                                	if ($user->list_am === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="list_am" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio15am">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio16am" name="list_am" @php 
                                                                                	if ($user->list_am === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio16am">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Validation des incidents</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio0vm" @php 
                                                                                	if ($user->val_am === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="val_am" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio0vm">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio00vm" name="val_am" @php 
                                                                                	if ($user->val_am === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio00vm">Non</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group align-items-center justify-content-center">
                                                                <span class="preview-title overline-title">Incidents non validés</span>
                                                                <div class="row gy-4">
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio0nnv" @php 
                                                                                	if ($user->am_n_val === 'oui') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp name="am_n_val" class="custom-control-input" value="oui" >
                                                                                <label class="custom-control-label" for="customRadio0nnv">Oui</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6">
                                                                        <div class="preview-block">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" id="customRadio00nnv" name="am_n_val" @php 
                                                                                	if ($user->am_n_val === 'non') {
                                                                                		echo "checked";
                                                                                	}
                                                                                @endphp class="custom-control-input" value="non">
                                                                                <label class="custom-control-label" for="customRadio00nnv">Non</label>
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
		                        </div>
		                        <div class="col-lg-12">
		                            <div class="row g-gs">
		                                <div class="col-md-12">
		                                    <div class="card card-preview">
		                                        <div class="card-inner row g-gs">
		                                            <div class="col-md-12">
		                                                <div class="form-group text-center">
		                                                    <button type="submit" class="btn btn-lg btn-primary btn-dim">
		                                                        <em class="ni ni-edit me-2 "></em>
		                                                        <em>Mise à jour</em>
		                                                    </button>
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


        <div class="modal fade" tabindex="-1" id="modalConfirmelock" aria-modal="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                    <div class="modal-body modal-body-lg text-center">
                        <div class="nk-modal">
                            <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-lock bg-danger"></em>
                            <h4 class="nk-modal-title">Confirmation</h4>
                            <div class="nk-modal-text">
                                <div class="caption-text">
                                    <span>Voulez-vous vraiment bloquer ce compte ?</span>
                                </div>
                            </div>
                            <div class="nk-modal-action">
                                <a href="/suppr_processus/" class="btn btn-lg btn-mw btn-success me-2">
                                    oui
                                </a>
                                <a href="#" class="btn btn-lg btn-mw btn-danger"data-bs-dismiss="modal">
                                    non
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="modalConfirmeunlock" aria-modal="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-bs-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </a>
                    <div class="modal-body modal-body-lg text-center">
                        <div class="nk-modal">
                            <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-unlock bg-success"></em>
                            <h4 class="nk-modal-title">Confirmation</h4>
                            <div class="nk-modal-text">
                                <div class="caption-text">
                                    <span>Voulez-vous vraiment débloquer ce compte ?</span>
                                </div>
                            </div>
                            <div class="nk-modal-action">
                                <a href="/suppr_processus/" class="btn btn-lg btn-mw btn-success me-2">
                                    oui
                                </a>
                                <a href="#" class="btn btn-lg btn-mw btn-danger"data-bs-dismiss="modal">
                                    non
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



@endsection
