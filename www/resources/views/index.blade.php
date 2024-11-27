@extends('layouts.host')
@section('content')
    @php $message = "Test message"; @endphp
    <br>
    {{--    <x-alert type="warning" :message="$message"></x-alert>--}}
    {{--    <x-alert type="success" :message="$message"></x-alert>--}}
    {{--    <x-alert type="primary" :message="$message"></x-alert>--}}
    {{--    <x-alert type="danger" :message="$message"></x-alert>--}}
    {{--    <x-alert type="info" :message="$message"></x-alert>--}}

    @include('components.host.filter', ['route' => 'index'])
    <hr>
    <h2>Список ПЭВМ зарегистрированных в сети последними</h2>

    <div class="alert-message"></div><br>
    <div class="table-responsive">
        @include('inc.message')
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Включить</th>
                <th scope="col">Фамимлия</th>
                <th scope="col">Имя</th>
                <th scope="col">Отчество</th>
                <th scope="col">Имя ПЭВМ</th>
                <th scope="col">IP адрес</th>
                <th scope="col">MAC адрес</th>
                <th scope="col">Дата добавления</th>
                <th scope="col">Дата обновления</th>
            </tr>
            </thead>
            <tbody class="table-body">
            @forelse($hosts as $host)
                <tr id="row-{{ $host->id }}">
                    <td>{{ $host->id }}</td>
                    <td>{{ (bool)$host->FLAG ? 'Вкл.' : 'Выкл.' }}</td>
                    <td>{{ $host->F }}</td>
                    <td>{{ $host->I }}</td>
                    <td>{{ $host->O }}</td>
                    <td>{{ $host->COMP }}</td>
                    <td>{{ $host->IP }}</td>
                    <td>{{ $host->MAC }}</td>
                    <td>{{ $host->DT_REG }}</td>
                    <td>{{ $host->DT_UPD }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">Записей не найдено</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
