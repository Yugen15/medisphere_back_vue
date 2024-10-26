<form method="POST" action="{{ route('your.route') }}">
    @csrf

    <div>
        <label>{{ __('Nombre') }}</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}">
        @error('nombre')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>{{ __('Apellido') }}</label>
        <input type="text" name="apellido" value="{{ old('apellido') }}">
        @error('apellido')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>{{ __('Id Especialidad') }}</label>
        <input type="text" name="id_especialidad" value="{{ old('id_especialidad') }}">
        @error('id_especialidad')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">{{ __('Submit') }}</button>
</form>