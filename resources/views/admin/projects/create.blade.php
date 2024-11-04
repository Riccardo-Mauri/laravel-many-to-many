@extends('layouts.app')

@section('main-content')
    <h1>Crea Nuovo Progetto</h1>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required maxlength="255">
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Descrizione</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Immagine</label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="is_started">Progetto Iniziato</label>
            <input type="checkbox" name="is_started" id="is_started" value="1" {{ old('is_started') ? 'checked' : '' }}>
        </div>
        
        <div class="form-group">
            <label for="type_id">Tipologia</label>
            <select name="type_id" id="type_id" class="form-control">
                <option value="">Seleziona una tipologia</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="technologies">Seleziona Tecnologie</label><br>
                @foreach ($technologies as $technology)
                    <label>
                        <input type="checkbox" name="technologies[]" value="{{ $technology->id }}"
                            {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                            {{ $technology->name }}
                    </label><br>
                @endforeach
    </div>

        <button type="submit" class="btn btn-primary">Salva Progetto</button>
    </form>
@endsection
