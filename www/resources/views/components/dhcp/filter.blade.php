<div class="">
    <h4>Фильтровать по:</h4>
</div>
<form action="{{ route('dhcp.index') }} ">
    <div class="row">
        <div class="col-md-3">
            <label class="form-label" for="enable-hosts">Активность</label>
            <select class="form-control" name="isEnable" id="enable-hosts">
                <option value="1" selected>Вкл</option>
                <option value="0">Выкл</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label" for="subnets">Адрес сети</label>
            <select class="form-control" name="subnets" id="subnets">
                <option value=""></option>
                @foreach ($subnets as $subnet)
                    <option value="{{ $subnet }}">
                        {{ $subnet }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mt-4">Фильтровать</button>
        </div>
    </div>
</form>
