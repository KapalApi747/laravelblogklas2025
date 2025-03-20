@extends('layouts.backend')
@section('title', 'Post Bekijken')
@section('cards')
@endsection
@section('charts')
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex gap-2 mb-3">
            <a href="{{ route('post.export', ['pdf', $post->id]) }}" class="btn btn-sm btn-danger">Export PDF</a>
        </div>
        <h1 class="h3 mb-4">Post Details</h1>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $post->title }}</h5>
            </div>
            <div class="card-body">
                <!-- Afbeelding -->
                <div class="text-center mb-4">
                    @if($post->photo && file_exists(public_path('assets/img/' . $post->photo->path)))
                        <img src="{{ asset('assets/img/' . $post->photo->path) }}"
                             alt="{{ $post->photo->alternate_text ?? 'Post afbeelding' }}"
                             class="img-fluid rounded object-fit-cover"
                             style="max-width: 100%; height: auto;">
                    @else
                        <img src="https://placehold.co/800x400"
                             alt="Geen afbeelding"
                             class="img-fluid rounded object-fit-cover"
                             style="max-width: 100%; height: auto;">
                    @endif
                </div>
                <!-- Titel & Inhoud -->
                <h3 class="mb-3">{{ $post->title }}</h3>
                <p class="text-muted">Geschreven door: <strong>{{ $post->author->name }}</strong></p>
                <p class="text-muted">Aangemaakt op: {{ $post->created_at->format('d-m-Y H:i') }}</p>
                <p class="text-muted">Laatst bijgewerkt: {{ $post->updated_at->diffForHumans() }}</p>
                <hr>
                <p class="lead">{{ $post->content }}</p>
                <hr>
                <!-- Categorieën -->
                <h5>Categorieën:</h5>
                <div>
                    @foreach($post->categories as $category)
                        <span class="badge bg-info">{{ $category->name }}</span>
                    @endforeach
                </div>
                <!-- Publicatiestatus -->
                <div class="mt-3">
                    <strong>Status:</strong>
                    <span class="badge {{ $post->is_published ? 'bg-success' : 'bg-secondary' }}">
                        {{ $post->is_published ? 'Gepubliceerd' : 'Concept' }}
                    </span>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Terug naar overzicht</a>
                <div>
                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-info">Bewerk</a>
                    @endcan
                    @can('delete', $post)
                        <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Weet je zeker dat je deze post wilt verwijderen?')">
                                Verwijder
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
