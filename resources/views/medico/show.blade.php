@extends('layouts.app')

@section('template_title')
    {{ $medico->nombre ?? __('Show') . " " . __('Medico') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Medico</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('medicos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        @if ($medico)
                            <div class="form-group mb-2 mb20">
                                <strong>Nombre:</strong>
                                {{ $medico->nombre }}
                            </div>
                            <div class="form-group mb-2 mb20">
                                <strong>Apellido:</strong>
                                {{ $medico->apellido }}
                            </div>
                            <div class="form-group mb-2 mb20">
                                <strong>Id Especialidad:</strong>
                                {{ $medico->id_especialidad }}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                {{ __('No se encontró información del médico.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
