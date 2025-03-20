@extends('layouts.backend')
@section('title', 'Post Bewerken')
@section('cards')
@endsection
@section('charts')
@endsection
@section('content')
    <div class="container-fluid px-4">
        @include('layouts.partials.form_error')
        <h1 class="h3 mb-4">Post Bewerken</h1>
        <!-- Update Form -->
        <form id="updateForm" method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <!-- Linkerkant: Post details -->
                <div class="col-md-8 d-flex">
                    <div class="card w-100">
                        <div class="card-header">Post Details</div>
                        <div class="card-body">
                            <!-- Titel -->
                            <div class="form-group mb-3">
                                <label for="title">Titel:</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Inhoud -->
                            <div class="form-group mb-3">
                                <label for="content">Inhoud:</label>
                                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Auteur (Niet wijzigbaar) -->
                            <div class="form-group mb-3">
                                <label>Auteur:</label>
                                <input type="text" class="form-control" value="{{ $post->author->name }}" disabled>
                            </div>
                            <!-- Categorieën -->
                            <div class="form-group mb-3">
                                <label>Categorieën:</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($categories as $id => $name)
                                        <div class="form-check me-3">
                                            <input type="checkbox" name="categories[]" value="{{ $id }}" id="category-{{ $id }}" class="form-check-input"
                                                {{ in_array($id, old('categories', $post->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label for="category-{{ $id }}" class="form-check-label">{{ $name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('categories')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Publicatiestatus (Radio buttons) -->
                            <div class="form-group mb-3">
                                <label>Publiceren:</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="is_published" value="1" id="published-yes" class="form-check-input"
                                            {{ old('is_published', $post->is_published) == 1 ? 'checked' : '' }}>
                                        <label for="published-yes" class="form-check-label">Ja</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="is_published" value="0" id="published-no" class="form-check-input"
                                            {{ old('is_published', $post->is_published) == 0 ? 'checked' : '' }}>
                                        <label for="published-no" class="form-check-label">Nee</label>
                                    </div>
                                </div>
                                @error('is_published')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Rechterkant: Afbeelding -->
                <div class="col-md-4 d-flex">
                    <div class="card w-100">
                        <div class="card-header">Afbeelding</div>
                        <div class="card-body text-center">
                            @if($post->photo && file_exists(public_path('assets/img/' . $post->photo->path)))
                                <img src="{{ asset('assets/img/' . $post->photo->path) }}"
                                     alt="{{ $post->photo->alternate_text ?? 'Post afbeelding' }}"
                                     class="img-fluid rounded object-fit-cover mb-2"
                                     style="width: 100%; max-width: 300px; height: auto;">
                            @else
                                <img src="https://placehold.co/300x300"
                                     alt="Geen afbeelding"
                                     class="img-fluid rounded object-fit-cover mb-2"
                                     style="width: 100%; max-width: 300px; height: auto;">
                            @endif
                        </div>
                        <div class="card-footer">
                            <label for="photo_id">Nieuwe Afbeelding Uploaden:</label>
                            <input type="file" name="photo_id" id="photo_id" class="form-control @error('photo_id') is-invalid @enderror">
                            @error('photo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Verwijderknop -->
        @can('delete', $post)
            <form id="deleteForm" method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Weet je zeker dat je deze post wilt verwijderen?');">
                @csrf
                @method('DELETE')
            </form>
        @endcan
        <!-- Actieknoppen -->
        <div class="card-footer d-flex justify-content-between align-items-center mt-3">
            <button type="submit" form="updateForm" class="btn btn-primary">Update Post</button>
            @can('delete', $post)
                <button type="submit" form="deleteForm" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Verwijder Post
                </button>
            @endcan
        </div>

    </div>
@endsection
