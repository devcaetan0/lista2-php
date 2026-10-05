<?php
function contarMaiusculas($senha)
{
    preg_match_all('/[A-Z]/', $senha, $matches);
    return count($matches[0]);
}

function contarMinusculas($senha)
{
    preg_match_all('/[a-z]/', $senha, $matches);
    return count($matches[0]);
}

function contarNumeros($senha)
{
    preg_match_all('/[0-9]/', $senha, $matches);
    return count($matches[0]);
}

function contarEspeciais($senha)
{
    preg_match_all('/[^a-zA-Z0-9]/', $senha, $matches);
    return count($matches[0]);
}

function classificarSenha($tamanho, $maiusculas, $minusculas, $numeros, $especiais)
{
    $pontos = 0;

    if ($tamanho >= 8) {
        $pontos++;
    }
    if ($maiusculas > 0) {
        $pontos++;
    }
    if ($minusculas > 0) {
        $pontos++;
    }
    if ($numeros > 0) {
        $pontos++;
    }
    if ($especiais > 0) {
        $pontos++;
    }

    if ($pontos <= 2) {
        return 'Fraca';
    }
    if ($pontos === 3) {
        return 'Média';
    }
    if ($pontos === 4) {
        return 'Forte';
    }
    return 'Muito Forte';
}

function analisarSenha($senha)
{
    $maiusculas = contarMaiusculas($senha);
    $minusculas = contarMinusculas($senha);
    $numeros = contarNumeros($senha);
    $especiais = contarEspeciais($senha);
    $tamanho = strlen($senha);

    return [
        'letras_maiusculas' => $maiusculas,
        'letras_minusculas' => $minusculas,
        'numeros' => $numeros,
        'caracteres_especiais' => $especiais,
        'tamanho' => $tamanho,
        'nivel_seguranca' => classificarSenha($tamanho, $maiusculas, $minusculas, $numeros, $especiais)
    ];
}

$senha = 'DaviBatixta12345-67';
$resultado = analisarSenha($senha);

echo "Senha analisada: $senha";
echo "<br> Letras Maiúsculas: " . $resultado['letras_maiusculas'];
echo "<br> Letras Minúsculas: " . $resultado['letras_minusculas'];
echo "<br> Números: " . $resultado['numeros'];
echo "<br> Caracteres Especiais: " . $resultado['caracteres_especiais'];
echo "<br> Tamanho: " . $resultado['tamanho'];
echo "<br> Nível de Segurança: " . $resultado['nivel_seguranca'];
?>