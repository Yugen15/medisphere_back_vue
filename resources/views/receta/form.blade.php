<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="medicamento" class="form-label">{{ __('Medicamento') }}</label>
            <input type="text" name="medicamento" class="form-control @error('medicamento') is-invalid @enderror" value="{{ old('medicamento', $receta?->medicamento) }}" id="medicamento" placeholder="Medicamento">
            {!! $errors->first('medicamento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="dosis" class="form-label">{{ __('Dosis') }}</label>
            <input type="text" name="dosis" class="form-control @error('dosis') is-invalid @enderror" value="{{ old('dosis', $receta?->dosis) }}" id="dosis" placeholder="Dosis">
            {!! $errors->first('dosis', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_consulta" class="form-label">{{ __('Id Consulta') }}</label>
            <input type="text" name="id_consulta" class="form-control @error('id_consulta') is-invalid @enderror" value="{{ old('id_consulta', $receta?->id_consulta) }}" id="id_consulta" placeholder="Id Consulta">
            {!! $errors->first('id_consulta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>