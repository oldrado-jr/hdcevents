@extends('layouts.main')

@section('title', 'Criar Evento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Crie o seu evento</h1>
    <form action="{{ route('event.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Imagem do Evento:</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div><br>
        <div class="form-group">
            <label for="title">Evento:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Nome do evento" required>
        </div><br>
        <div class="form-group">
            <label for="date">Data do evento:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div><br>
        <div class="form-group">
            <label for="city">Cidade:</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Local do evento" required>
        </div><br>
        <div class="form-check">
            <input type="checkbox" name="private" id="private" class="form-check-input">
            <label for="private" class="form-check-label">Evento privado</label>
        </div><br>
        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea name="description" id="description" class="form-control" placeholder="O que vai acontecer no evento?" required></textarea>
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
        <input type="submit" value="Criar evento" class="btn btn-primary">
    </form>
</div>

@endsection
