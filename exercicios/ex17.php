<?php
function removerEspacosDuplicados($texto)
{
    return trim(preg_replace('/\s+/', ' ', $texto));
}

function separarPalavras($texto)
{
    $texto = removerEspacosDuplicados($texto);

    if ($texto == '') {
        return [];
    }

    return explode(' ', $texto);
}

function contarFrases($texto)
{
    preg_match_all('/[.!?]+/', $texto, $matches);
    return count($matches[0]);
}

function encontrarPalavraMaisLonga($palavras)
{
    $maior = '';

    foreach ($palavras as $palavra) {
        $palavraLimpa = preg_replace('/[[:punct:]]/', '', $palavra);
        if (strlen($palavraLimpa) > strlen($maior)) {
            $maior = $palavraLimpa;
        }
    }

    return $maior;
}

function encontrarPalavraMaisCurta($palavras)
{
    $menor = '';

    foreach ($palavras as $palavra) {
        $palavraLimpa = preg_replace('/[[:punct:]]/', '', $palavra);
        if ($palavraLimpa != '' && ($menor == '' || strlen($palavraLimpa) < strlen($menor))) {
            $menor = $palavraLimpa;
        }
    }

    return $menor;
}

function contarPalavrasRepetidas($palavras)
{
    $contagens = [];

    foreach ($palavras as $palavra) {
        $palavra = strtolower(preg_replace('/[[:punct:]]/', '', $palavra));
        if ($palavra != '') {
            if (isset($contagens[$palavra])) {
                $contagens[$palavra]++;
            } else {
                $contagens[$palavra] = 1;
            }
        }
    }

    $repetidas = 0;
    foreach ($contagens as $quantidade) {
        if ($quantidade > 1) {
            $repetidas += $quantidade - 1;
        }
    }

    return $repetidas;
}

function encontrarCincoMaisFrequentes($palavras)
{
    $contagens = [];

    foreach ($palavras as $palavra) {
        $palavra = strtolower(preg_replace('/[[:punct:]]/', '', $palavra));
        if ($palavra != '') {
            if (isset($contagens[$palavra])) {
                $contagens[$palavra]++;
            } else {
                $contagens[$palavra] = 1;
            }
        }
    }

    arsort($contagens);
    return array_slice($contagens, 0, 5, true);
}

function processarTexto($texto)
{
    $textoSemEspacosDuplicados = removerEspacosDuplicados($texto);
    $palavras = separarPalavras($texto);

    return [
        'quantidade_caracteres' => strlen($texto),
        'quantidade_palavras' => count($palavras),
        'quantidade_frases' => contarFrases($texto),
        'palavra_mais_longa' => encontrarPalavraMaisLonga($palavras),
        'palavra_mais_curta' => encontrarPalavraMaisCurta($palavras),
        'quantidade_palavras_repetidas' => contarPalavrasRepetidas($palavras),
        'cinco_palavras_mais_frequentes' => encontrarCincoMaisFrequentes($palavras),
        'texto_sem_espacos_duplicados' => $textoSemEspacosDuplicados,
        'texto_formatado' => ucwords(strtolower($textoSemEspacosDuplicados))
    ];
}

$texto = 'Salve o Corinthians o campeão dos campeões eternamente dentro de nossos corações';
$resultado = processarTexto($texto);

echo "Quantidade de caracteres: " . $resultado['quantidade_caracteres'];
echo "<br> Quantidade de palavras: " . $resultado['quantidade_palavras'];
echo "<br> Quantidade de frases: " . $resultado['quantidade_frases'];
echo "<br> Palavra mais longa: " . $resultado['palavra_mais_longa'];
echo "<br> Palavra mais curta: " . $resultado['palavra_mais_curta'];
echo "<br> Quantidade de palavras repetidas: " . $resultado['quantidade_palavras_repetidas'];
echo "<br> Cinco palavras mais frequentes: ";
foreach ($resultado['cinco_palavras_mais_frequentes'] as $palavra => $frequencia) {
    echo "$palavra ($frequencia), ";
}
echo "<br> Texto sem espaços duplicados: " . $resultado['texto_sem_espacos_duplicados'];
echo "<br> Texto formatado: " . $resultado['texto_formatado'];

?>