@extends('layouts.app')

@section('template_title')
    {{ $receta->name ?? __('Show') . " " . __('Receta') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Receta</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('recetas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Medicamento:</strong>
                                    {{ $receta->medicamento }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Dosis:</strong>
                                    {{ $receta->dosis }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Consulta:</strong>
                                    {{ $receta->id_consulta }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
