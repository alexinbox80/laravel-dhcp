@extends('layouts.host')
@section('content')
    <div class="offset-2 col-8">
        <br>
        <h2>Редактировать запись хоста</h2>

        @include('inc.message')

        <form method="post" action="{{ route('host.update', ['host' => $host]) }}">
            @csrf
            @method('put')
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="FLAG" id="enable"
                       @if($host->FLAG) checked @endif value="1">
                <label for="enable">Включить/выключить хост</label>
            </div>
            <br>
            <div class="form-group">
                <label for="room">Кабинет</label>
                <input type="text" class="form-control" name="CAB" id="room" value="{{ $host->CAB }}">
            </div>
            <br>
            <div class="form-group">
                <label for="fam">Фамилия</label>
                <input type="text" class="form-control" name="F" id="fam" value="{{ $host->F }}">
            </div>
            <br>
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" name="I" id="name" value="{{ $host->I }}">
            </div>
            <br>
            <div class="form-group">
                <label for="sname">Отчество</label>
                <input type="text" class="form-control" name="O" id="sname" value="{{ $host->O }}">
            </div>
            <br>
            <div class="form-group">
                <label for="comp">Имя ПЭВМ</label>
                <input type="text" class="form-control" name="COMP" id="comp" value="{{ $host->COMP }}" required>
            </div>
            <br>
            <div class="form-group">
                <label for="ip_address">IP адрес</label>
                <input type="text" class="form-control mask-ipv4" name="IP" id="ip_address" value="{{ $host->IP }}">
            </div>
            <br>
            <div class="form-group">
                <label for="ild_ip_address">Старый IP адрес</label>
                <input type="text" class="form-control mask-ipv4" name="OLD_IP" id="old_ip_address"
                       value="{{ $host->OLD_IP }}">
            </div>
            <br>
            <div class="form-group">
                <label for="mac_address">МАС адрес</label>
                <input type="text" class="form-control mask-mac" name="MAC" id="mac_address" value="{{ $host->MAC }}">
            </div>
            <br>
            <div class="form-group">
                <label for="info">Описание</label>
                <textarea class="form-control" name="INFO" id="info">{!! $host->INFO !!}</textarea>
            </div>
            <br>
            <button class="btn btn-success" type="submit">Сохранить</button>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.input-ip-address-control-1.0.min.js') }}"></script>

    <script>
        jQuery(function ($) {
            // $('.mask-phone').mask('+7 (999) 999-99-99');

            $.mask.definitions['h'] = '[A-Fa-f0-9]';
            $('.mask-mac').mask('hh:hh:hh:hh:hh:hh');

            $('.mask-ipv4').ipAddress();
        });
    </script>
@endpush
