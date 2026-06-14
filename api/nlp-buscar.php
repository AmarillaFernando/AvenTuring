<?php

require_once __DIR__ . '/../database/conexion.php';

header('Content-Type: application/json');

// ── CONFIGURACIÓN ──────────────────────────────────────────
require_once __DIR__ . '/../config.php';
if (!defined('GROQ_API_KEY')) {
    define('GROQ_API_KEY', env('GROQ_API_KEY'));
}
define('GROQ_URL',   'https://api.groq.com/openai/v1/chat/completions');
define('GROQ_MODEL', 'llama-3.1-8b-instant');
// ───────────────────────────────────────────────────────────

$query = trim($_GET['q'] ?? '');

if ($query === '') {
    echo json_encode([]);
    exit;
}


// ── 1. GROQ EXTRAE PALABRAS CLAVE ──────────────────────────

function extraerTerminos(string $query): array {

    $prompt = <<<PROMPT
El usuario busca en una plataforma educativa sobre Inteligencia Artificial.
Su consulta es: "{$query}"

Devolvé ÚNICAMENTE un array JSON con 3 a 6 términos de búsqueda en español,
sin explicaciones, sin markdown, sin texto adicional.
Los términos deben cubrir sinónimos, conceptos relacionados y palabras clave técnicas
que puedan aparecer en nombres, descripciones o categorías de software de IA.

Ejemplo de salida válida:
["machine learning","aprendizaje automático","clasificación","modelo predictivo"]
PROMPT;

    $payload = json_encode([
        'model'       => GROQ_MODEL,
        'max_tokens'  => 150,
        'temperature' => 0,
        'messages'    => [
            ['role' => 'user', 'content' => $prompt]
        ]
    ]);

    $context = stream_context_create([
        'http' => [
            'method'        => 'POST',
            'header'        => implode("\r\n", [
                'Content-Type: application/json',
                'Authorization: Bearer ' . GROQ_API_KEY,
            ]),
            'content'       => $payload,
            'timeout'       => 8,
            'ignore_errors' => true,
        ]
    ]);

    $response = @file_get_contents(GROQ_URL, false, $context);

    if ($response === false) {
        return [$query];
    }

    $data = json_decode($response, true);
    $text = trim($data['choices'][0]['message']['content'] ?? '');

    // Limpiar posibles ```json ... ``` que algunos modelos agregan
    $text = preg_replace('/^```json\s*/i', '', $text);
    $text = preg_replace('/\s*```$/', '', $text);
    $text = trim($text);

    $terminos = json_decode($text, true);

    if (!is_array($terminos) || empty($terminos)) {
        return [$query];
    }

    $terminos[] = $query;
    return array_unique($terminos);
}


// ── 2. BÚSQUEDA CON LOS TÉRMINOS EXPANDIDOS ────────────────

$terminos = extraerTerminos($query);
$whereParts = [];
$scoreParts = [];
$params     = [];

foreach ($terminos as $i => $termino) {
    $p = "%{$termino}%";

    $whereParts[] = "(nombre LIKE :tw{$i} OR categoria LIKE :tw{$i} OR descripcion LIKE :tw{$i} OR autor LIKE :tw{$i})";
    $params[":tw{$i}"] = $p;

    $scoreParts[] = "(CASE WHEN nombre      LIKE :sn{$i} THEN 3 ELSE 0 END)";
    $scoreParts[] = "(CASE WHEN categoria   LIKE :sc{$i} THEN 2 ELSE 0 END)";
    $scoreParts[] = "(CASE WHEN descripcion LIKE :sd{$i} THEN 1 ELSE 0 END)";
    $scoreParts[] = "(CASE WHEN autor       LIKE :sa{$i} THEN 1 ELSE 0 END)";

    $params[":sn{$i}"] = $p;
    $params[":sc{$i}"] = $p;
    $params[":sd{$i}"] = $p;
    $params[":sa{$i}"] = $p;
}

$where     = implode(' OR ', $whereParts);
$scoreExpr = implode(' + ', $scoreParts);

$sql = "SELECT
            id, nombre, descripcion, categoria,
            licencia, anio, autor, enlace, rating,
            ({$scoreExpr}) AS score
        FROM softwares
        WHERE ({$where})
        ORDER BY score DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$resultados = [];

foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $resultados[] = [
        'tipo'        => 'software',
        'titulo'      => $row['nombre'],
        'descripcion' => $row['descripcion'],
        'meta'        => $row['categoria'] . ' · ' . $row['licencia'] . ' · ' . $row['anio'],
        'enlace'      => $row['enlace'],
        'score'       => (int) $row['score'],
    ];
}

// ── FUTURAS TABLAS ──────────────────────────────────────────
// $terminos ya está expandido por Groq.
// Repetí el bloque de búsqueda con la nueva tabla y
// hacé array_merge($resultados, $nuevosResultados) antes del usort.
// ───────────────────────────────────────────────────────────

usort($resultados, fn($a, $b) => $b['score'] - $a['score']);

echo json_encode($resultados);