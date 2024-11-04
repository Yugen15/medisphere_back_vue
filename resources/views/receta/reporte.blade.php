<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recetas por Paciente</title>
    <style>
        /* Añade estilos básicos para el PDF */
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Recetas por Paciente</h2>
    <p><strong>Paciente:</strong> {{ $recetas[0]->nombre_paciente }} {{ $recetas[0]->apellido_paciente }}</p>
    <p><strong>Médico:</strong> {{ $recetas[0]->nombre_medico }} {{ $recetas[0]->apellido_medico }}</p>

    <table>
        <thead>
            <tr>
                <th>Fecha de Consulta</th>
                <th>Medicamento</th>
                <th>Dosis</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recetas as $receta)
            <tr>
                <td>{{ $receta->fecha_consulta }}</td>
                <td>{{ $receta->medicamento }}</td>
                <td>{{ $receta->dosis }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>