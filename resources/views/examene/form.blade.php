<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
            <input type="text" name="tipo" class="form-control @error('tipo') is-invalid @enderror" value="{{ old('tipo', $examene?->tipo) }}" id="tipo" placeholder="Tipo">
            {!! $errors->first('tipo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="resultado" class="form-label">{{ __('Resultado') }}</label>
            <input type="text" name="resultado" class="form-control @error('resultado') is-invalid @enderror" value="{{ old('resultado', $examene?->resultado) }}" id="resultado" placeholder="Resultado">
            {!! $errors->first('resultado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_consulta" class="form-label">{{ __('Id Consulta') }}</label>
            <input type="text" name="id_consulta" class="form-control @error('id_consulta') is-invalid @enderror" value="{{ old('id_consulta', $examene?->id_consulta) }}" id="id_consulta" placeholder="Id Consulta">
            {!! $errors->first('id_consulta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>