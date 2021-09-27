@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Meus Eventos</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(count($events) > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Participantes</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr>
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td scope="row">
                            <a href="{{ route('event.show', ['event' => $event]) }}">
                                {{ $event->title }}
                            </a>
                        </td>
                        <td scope="row">{{ count($event->users) }}</td>
                        <td scope="row">
                            <a href="{{ route('event.edit', ['event' => $event]) }}" class="btn btn-info edit-btn">
                                <ion-icon name="create-outline"></ion-icon>
                                Editar
                            </a>
                            <form action="{{ route('event.destroy', ['event' => $event]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger delete-btn">
                                    <ion-icon name="trash-outline"></ion-icon>
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Você ainda não tem eventos. <a href="{{ route('event.create') }}" class="btn btn-primary">Criar evento</a></p>
    @endif
</div>
<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Eventos que estou participando</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(count($eventsAsParticipant) > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Participantes</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventsAsParticipant as $event)
                    <tr>
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td scope="row">
                            <a href="{{ route('event.show', ['event' => $event]) }}">
                                {{ $event->title }}
                            </a>
                        </td>
                        <td scope="row">{{ count($event->users) }}</td>
                        <td scope="row">
                            <form action="{{ route('event.leave', ['event' => $event]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger delete-btn">
                                    <ion-icon name="trash-outline"></ion-icon>
                                    Sair do evento
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>
            Você ainda não está participando de nenhum evento.
            <a href="{{ route('event.index') }}" class="btn btn-primary">
                Veja todos os eventos
            </a>
        </p>
    @endif
</div>

@endsection
