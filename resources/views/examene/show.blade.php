@extends('layouts.app')

@section('template_title')
    {{ $examene->name ?? __('Show') . " " . __('Examene') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Examene</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('examenes.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Tipo:</strong>
                                    {{ $examene->tipo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Resultado:</strong>
                                    {{ $examene->resultado }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Consulta:</strong>
                                    {{ $examene->id_consulta }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
