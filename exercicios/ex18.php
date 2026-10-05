<?php
function ordenarConsultas($consultas)
{
    usort($consultas, function ($consultaA, $consultaB) {
        return strcmp($consultaA['horario'], $consultaB['horario']);
    });

    return $consultas;
}

function contarPacientesDiferentes($consultas)
{
    $pacientes = [];

    foreach ($consultas as $consulta) {
        $pacientes[] = $consulta['paciente'];
    }

    return count(array_unique($pacientes));
}

function contarEspecialidades($consultas)
{
    $especialidades = [];

    foreach ($consultas as $consulta) {
        $especialidade = $consulta['especialidade'];
        if (isset($especialidades[$especialidade])) {
            $especialidades[$especialidade]++;
        } else {
            $especialidades[$especialidade] = 1;
        }
    }

    return $especialidades;
}

function buscarPaciente($consultas, $nomePaciente)
{
    $resultados = [];

    foreach ($consultas as $consulta) {
        if (strtolower($consulta['paciente']) === strtolower($nomePaciente)) {
            $resultados[] = $consulta;
        }
    }

    return $resultados;
}

function verificarHorariosDuplicados($consultas)
{
    $horarios = [];
    $duplicados = [];

    foreach ($consultas as $consulta) {
        $chave = $consulta['data'] . ' ' . $consulta['horario'];
        if (isset($horarios[$chave])) {
            $duplicados[] = $chave;
        } else {
            $horarios[$chave] = true;
        }
    }

    return $duplicados;
}

function organizarAgenda($consultas, $nomePaciente)
{
    $consultasOrdenadas = ordenarConsultas($consultas);
    $total = count($consultasOrdenadas);

    return [
        'total_consultas' => $total,
        'pacientes_diferentes' => contarPacientesDiferentes($consultasOrdenadas),
        'consultas_por_especialidade' => contarEspecialidades($consultasOrdenadas),
        'primeiro_atendimento' => $total > 0 ? $consultasOrdenadas[0] : null,
        'ultimo_atendimento' => $total > 0 ? $consultasOrdenadas[$total - 1] : null,
        'consultas_ordenadas' => $consultasOrdenadas,
        'pesquisa_paciente' => buscarPaciente($consultasOrdenadas, $nomePaciente),
        'horarios_duplicados' => verificarHorariosDuplicados($consultasOrdenadas)
    ];
}

$consultas = [
    ['paciente' => 'Ana Silva', 'especialidade' => 'Clínica geral', 'data' => '2026-10-05', 'horario' => '09:00'],
    ['paciente' => 'Bruno Lima', 'especialidade' => 'Dermatologia', 'data' => '2026-10-05', 'horario' => '08:30'],
    ['paciente' => 'Ana Silva', 'especialidade' => 'Clínica geral', 'data' => '2026-10-05', 'horario' => '10:00'],
    ['paciente' => 'Carla Souza', 'especialidade' => 'Dermatologia', 'data' => '2026-10-05', 'horario' => '09:00']
];
$nomePaciente = 'Ana Silva';
$resultado = organizarAgenda($consultas, $nomePaciente);

echo "Total de consultas: " . $resultado['total_consultas'];
echo "<br> Total de pacientes diferentes: " . $resultado['pacientes_diferentes'];
echo "<br> Consultas por especialidade: ";
foreach ($resultado['consultas_por_especialidade'] as $especialidade => $quantidade) {
    echo "<br> - $especialidade: $quantidade";
}
echo "<br> Primeiro atendimento: " . ($resultado['primeiro_atendimento'] ? $resultado['primeiro_atendimento']['paciente'] . " às " . $resultado['primeiro_atendimento']['horario'] : 'Nenhum');
echo "<br> Último atendimento: " . ($resultado['ultimo_atendimento'] ? $resultado['ultimo_atendimento']['paciente'] . " às " . $resultado['ultimo_atendimento']['horario'] : 'Nenhum');
echo "<br> Consultas ordenadas: ";
foreach ($resultado['consultas_ordenadas'] as $consulta) {
    echo "<br> - " . $consulta['paciente'] . " (" . $consulta['especialidade'] . ") em " . $consulta['data'] . " às " . $consulta['horario'];
}

?>