@extends('layouts.app')

@section('content')
<div class="content">
    <div class="page-actions">
        <div>
            <a href="{{ route('projets.index') }}" class="back-link" style="color:#94a3b8; text-decoration:none;">← Retour</a>
            <h1>{{ $projet->nom_projet }}</h1>
        </div>
        @if(Auth::id() === $projet->createur_id)
            <a href="{{ route('projets.edit', $projet->id) }}" class="btn-add-collab">Modifier</a>
        @endif
    </div>

    <div id="modal-link-ticket" class="modal-overlay">
        <div class="modal-content">
            <a href="#" class="close-btn">&times;</a>
            <form action="{{ route('projets.link_ticket', $projet->id) }}" method="POST">
                @csrf
                <select name="ticket_id" class="form-control" required>
                    <option value="" disabled selected>-- Sélectionner --</option>
                    @foreach($free_tickets as $ft)
                        <option value="{{ $ft->id }}">#{{ $ft->id }} - {{ $ft->titre }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-submit">Lier au projet</button>
            </form>
        </div>
    </div>
</div>
@endsection