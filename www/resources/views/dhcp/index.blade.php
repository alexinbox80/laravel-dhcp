@extends('layouts.dhcp')
@section('content')
    @php $message = "Test message"; @endphp
    <br>
    {{--    <x-alert type="warning" :message="$message"></x-alert>--}}
    {{--    <x-alert type="success" :message="$message"></x-alert>--}}
    {{--    <x-alert type="primary" :message="$message"></x-alert>--}}
    {{--    <x-alert type="danger" :message="$message"></x-alert>--}}
    {{--    <x-alert type="info" :message="$message"></x-alert>--}}

    <h2>Список ПЭВМ зарегистрированных в сети</h2>
    <div style="display: flex; justify-content: right;">
        <a href="{{ route('make.config') }}" class="btn btn-primary me-3">Создать конфигурационный файл</a>
        <a href="{{ route('dhcp.create') }}" class="btn btn-primary">Добавить ПЭВМ в конфиг</a>
    </div><br>
    <div class="alert-message"></div><br>
    <div class="table-responsive">
        @include('inc.message')
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Включить</th>
                <th scope="col">Фамилия</th>
                <th scope="col">Имя</th>
                <th scope="col">Отчество</th>
                <th scope="col">Имя ПЭВМ</th>
                <th scope="col">IP адрес</th>
                <th scope="col">MAC адрес</th>
                <th scope="col">IP предыдущий</th>
                <th scope="col">Инфо</th>
                <th scope="col">Управление</th>
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
                    <td>{{ $host->OLD_IP }}</td>
                    <td>{{ $host->INFO }}</td>
                    <td>
                        <div style="">
                            <a href="{{ route('dhcp.edit', ['dhcp' => $host]) }}">Ред.</a>&nbsp;
                            <a href="javascript:;" class="delete" rel="{{ $host->id }}"
                               style="color: red;">Уд.</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11">Записей не найдено</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $hosts->links() }}
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {

            let elements = document.querySelectorAll(".delete");

            elements.forEach(function (e, k) {
                e.addEventListener("click", function () {
                    const id = e.getAttribute('rel');

                    console.log(`/dhcp/${id}`);

                    send(`/dhcp/${id}`).then((result) => {

                        const answer = JSON.parse(JSON.stringify(result));
                        let alertBlock = document.querySelector('.alert-message');
                        alertBlock.textContent = '';
                        switch (answer.status.toLowerCase()) {
                            case 'ok':
                                console.log(JSON.stringify(result));
                                const message = `Запись с #ID = ${id} успешно удалена`;
                                renderBlock(alertBlock, message, 'success', 'beforeend');
                                let removeRow = document.querySelector('#row-' + id);
                                removeRow.remove();
                                setTimeout("location.reload()", 2000);
                                break;
                            case 'error':
                                console.log(JSON.stringify(result));
                                const error = 'Возникла ошибка при удалении записи';
                                renderBlock(alertBlock, error, 'danger', 'beforeend');
                                break;
                            default:
                                console.log('Wrong Answer');
                        }
                    });
                });
            });
        });

        async function send(url) {
            console.log(url);
            let response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            // .then(res => {
            //     if (res.ok) { console.log("HTTP request successful") }
            //     else { console.log("HTTP request unsuccessful") }
            //     return res
            // })
            // .then(res => console.log(res))
            // .then(data => console.log(data))
            // .catch(error => console.log(error))

            let result = await response.json();
            return result;
        }

        function getHtml(message, type = 'success') {
            let alertContent;

            alertContent = `<div class="alert alert-${type} alert-dismissible fade show">
                                ${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`;

            return alertContent;
        }

        function renderBlock(container, message, type = 'success', target = 'afterbegin') {

            container.insertAdjacentHTML(target, getHtml(message, type));

            return true;
        }
    </script>
@endpush
