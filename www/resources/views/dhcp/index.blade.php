@extends('layouts.dhcp')
@section('content')
    @php $message = "Test message"; @endphp
    <br>
    <x-alert type="warning" :message="$message"></x-alert>
    <x-alert type="success" :message="$message"></x-alert>
    <x-alert type="primary" :message="$message"></x-alert>
    <x-alert type="danger" :message="$message"></x-alert>
    <x-alert type="info" :message="$message"></x-alert>

    <h2>Список ПЭВМ зарегистрированных в сети</h2>
    <div style="display: flex; justify-content: right;">
{{--        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">Добавить новость</a>--}}
    </div><br>
    <div class="alert-message"></div><br>
    <div class="table-responsive">
        @include('inc.message')
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Включить</th>
                <th scope="col">Наименование</th>
                <th scope="col">Категория</th>
                <th scope="col">Автор</th>
                <th scope="col">Статус</th>
                <th scope="col">Дата добавления</th>
                <th scope="col">Управление</th>
            </tr>
            </thead>
            <tbody class="table-body">
            @forelse($lists as $list)
                <tr id="row-{{ $list->id }}">
                    <td>{{ $list->id }}</td>
                    <td>{{ $list->FLAG }}</td>
                    <td>{{ $list->F }}</td>
                    <td>{{ $list->I }}</td>
                    <td>{{ $list->O }}</td>
                    <td>{{ $list->IP }}</td>
                    <td>{{ $list->MAC }}</td>
                    <td>
{{--                        {{ route('admin.news.edit', ['news' => $news]) }}--}}

                        <div style="">
                            <a href="">Ред.</a>&nbsp;
                            <a href="javascript:;" class="delete" rel="{{ $list->id }}"
                               style="color: red;">Уд.</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Новостей не найдено</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $lists->links() }}
    </div>@endsection
