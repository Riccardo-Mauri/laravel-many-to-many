@extends('layouts.app')

@section('main-content')
    <h1>Modifica Progetto</h1>

    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $project->title) }}" required maxlength="255">
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrizione</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $project->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Immagine</label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            @if ($project->image)
                <div class="mt-3">
                    <h4>Immagine attuale:</h4>
                    <img src="{{asset('storage/'. $project->image)}}" alt="{{ $project->title}}" style="height: 150px;">
                </div>
                <div class="form-check">
                    <input type="checkbox" id="remove_image" name="remove_image">
                    <label for="remove_image">Rimuovi immagine attuale</label>
                </div>
            @endif
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_started" id="is_started" class="form-check-input" value="1" required {{ old('is_started', $project->is_started) ? 'checked' : '' }}>
            <label for="is_started" class="form-check-label">Progetto Iniziato</label>
        </div>

        <div class="form-group">
            <label for="type_id">Tipologia</label>
            <select name="type_id" id="type_id" class="form-control">
                <option value="">Seleziona una tipologia</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ $project->type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="technologies">Seleziona Tecnologie</label><br>
                @foreach ($technologies as $technology)
                    <label>
                        <input type="checkbox" name="technologies[]" value="{{ $technology->id }}"
                            @if (isset($project) && $project->technologies->contains($technology->id))  @endif>
                            {{ $technology->name }}
                    </label><br>
                @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Salva Progetto</button>
    </form>
@endsection

