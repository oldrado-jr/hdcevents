@extends('layouts.main')

@section('title', 'Editando ' . $event->title)

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editando: {{ $event->title }}</h1>
    <form action="{{ route('event.update', ['event' => $event]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="image">Imagem do Evento:</label>
            <input type="file" name="image" id="image" class="form-control-file">
            <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-preview">
        </div><br>
        <div class="form-group">
            <label for="title">Evento:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Nome do evento" value="{{ $event->title }}" required>
        </div><br>
        <div class="form-group">
            <label for="date">Data do evento:</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $event->date->format('Y-m-d') }}" required>
        </div><br>
        <div class="form-group">
            <label for="city">Cidade:</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Local do evento" value="{{ $event->city }}" required>
        </div><br>
        <div class="form-check">
            <input type="checkbox" name="private" id="private" class="form-check-input" {{ $event->private ? 'checked' : '' }}>
            <label for="private" class="form-check-label">Evento privado</label>
        </div><br>
        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea name="description" id="description" class="form-control" placeholder="O que vai acontecer no evento?" required>{{ $event->description }}</textarea>
        </div><br>
        <div class="form-group">
            <label>Adicione itens de infraestrutura:</label>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="items[]" id="chairs" value="Cadeiras">
                <label for="chairs" class="form-check-label">Cadeiras</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="items[]" id="stage" value="Palco">
                <label for="stage" class="form-check-label">Palco</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="items[]" id="free-beer" value="Cerveja grátis">
                <label for="free-beer" class="form-check-label">Cerveja grátis</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="items[]" id="open-food" value="Open food">
                <label for="open-food" class="form-check-label">Open food</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="items[]" id="gifts" value="Brindes">
                <label for="gifts" class="form-check-label">Brindes</label>
            </div>
        </div><br>
        <input type="submit" value="Editar evento" class="btn btn-primary">
    </form>
</div>

@endsection
