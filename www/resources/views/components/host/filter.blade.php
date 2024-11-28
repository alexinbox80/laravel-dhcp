<div class="">
    <h4>Фильтровать по:</h4>
</div>
<form action="{{ route($route) }} ">
    <div class="row">
        <div class="col-md-3">
            <label class="form-label" for="enable-hosts">Включить/Отключить</label>
            <select class="form-control" name="isEnable" id="enable-hosts">
                <option value="" selected></option>
                @foreach (['Выкл.', 'Вкл.'] as $key => $status)
                    <option {{ !is_null(request()->isEnable) && ((int)request()->isEnable === $key) ? 'selected' : '' }} value="{{ $key }}">
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label" for="subnets">Адрес сети</label>
            <select class="form-control" name="subnet" id="subnets">
                <option value="" selected></option>
                @foreach ($subnets as $key => $value)
                    <option {{ request()->subnet === $value ? 'selected' : '' }} value="{{ $value }}">
                        {{ $value.'.0' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex">
            <button type="submit" class="btn btn-primary mt-auto">Фильтровать</button>
        </div>
    </div>
</form>
