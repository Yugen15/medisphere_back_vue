<!DOCTYPE html>
<html>
<head>
    <title>Expediente del Paciente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .patient-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            background-color: #e0e0e0;
            padding: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Expediente Médico</h1>
    </div>

    <div class="patient-info">
        <h2>Información del Paciente</h2>
        <p><strong>Nombre:</strong> {{ $expediente[0]->nombre_paciente }} {{ $expediente[0]->apellido_paciente }}</p>
        <p><strong>DUI:</strong> {{ $expediente[0]->dui_paciente }}</p>
    </div>

    <div class="section">
        <div class="section-title">Historial de Citas y Consultas</div>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Diagnóstico</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expediente as $registro)
                    @if($registro->fecha_cita)
                    <tr>
                        <td>{{ $registro->fecha_cita }}</td>
                        <td>{{ $registro->titulo_cita }}</td>
                        <td>{{ $registro->estado }}</td>
                        <td>{{ $registro->diagnostico_consulta }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Medicamentos Recetados</div>
        <table>
            <thead>
                <tr>
                    <th>Medicamento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expediente as $registro)
                    @if($registro->medicamento)
                    <tr>
                        <td>{{ $registro->medicamento }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Exámenes Realizados</div>
        <table>
            <thead>
                <tr>
                    <th>Tipo de Examen</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expediente as $registro)
                    @if($registro->tipo_examen)
                    <tr>
                        <td>{{ $registro->tipo_examen }}</td>
                        <td>{{ $registro->resultado_examen }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>