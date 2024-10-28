<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="cita_id" class="form-label">{{ __('Cita Id') }}</label>
            <input type="text" name="cita_id" class="form-control @error('cita_id') is-invalid @enderror" value="{{ old('cita_id', $consulta?->cita_id) }}" id="cita_id" placeholder="Cita Id">
            {!! $errors->first('cita_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="diagnostico" class="form-label">{{ __('Diagnostico') }}</label>
            <input type="text" name="diagnostico" class="form-control @error('diagnostico') is-invalid @enderror" value="{{ old('diagnostico', $consulta?->diagnostico) }}" id="diagnostico" placeholder="Diagnostico">
            {!! $errors->first('diagnostico', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>