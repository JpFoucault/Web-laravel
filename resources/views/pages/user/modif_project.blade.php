@extends('layouts.app')

@section('content')
<div class="content_create">
    <div class="form-card">
        <div class="form-header">
            <h1>Nouveau Projet</h1>
            <p>Définissez le cadre, le client, le budget et l'équipe pour ce nouveau projet.</p>
        </div>

        <form action="{{ route('projets.update', $projet->id) }}" method="POST">
            @csrf @method('PUT')                
            <h3 class="form-section-title">Informations générales</h3>
            <div class="form-group-project">
                <label>Nom du projet <span class="text-required">*</span></label>
                <input type="text" name="nom_projet" class="form-control" required>
            </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">Équipe du projet</h3>
                <div class="collabs-grid">
                    @foreach($users as $user)
                        <label class="collab-option">
                            <input type="checkbox" name="collabs[]" value="{{ $user->id }}">
                            <span class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            <span class="collab-name">{{ $user->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('projets.index') }}" class="btn-cancel">Annuler</a>
                <button type="submit" class="btn-submit">Créer le projet</button>
            </div>
        </form>
    </div>
</div>
@endsection