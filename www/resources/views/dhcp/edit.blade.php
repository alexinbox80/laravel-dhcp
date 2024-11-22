@extends('layouts.dhcp')
@section('content')
    <div class="offset-2 col-8">
        <br>
        <h2>Редактировать запись хоста</h2>

        @include('inc.message')

        <form method="post" action="{{ route('dhcp.update', ['dhcp' => $host]) }}">
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
                <input type="text" class="form-control" name="COMP" id="comp" value="{{ $host->COMP }}">
            </div>
            <br>
            <div class="form-group">
                <label for="ip_address">IP адрес</label>
                <input type="text" class="form-control" name="IP" id="ip_address" value="{{ $host->IP }}">
            </div>
            <br>
            <div class="form-group">
                <label for="ild_ip_address">Старый IP адрес</label>
                <input type="text" class="form-control" name="OLD_IP" id="old_ip_address" value="{{ $host->OLD_IP }}">
            </div>
            <br>
            <div class="form-group">
                <label for="mac_address">МАС адрес</label>
                <input type="text" class="form-control" name="MAC" id="mac_address" value="{{ $host->MAC }}">
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
