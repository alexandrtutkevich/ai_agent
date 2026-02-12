#!/usr/bin/env php
<?php


$envPath = __DIR__ . '/.env';

if (!file_exists($envPath)) {
    fwrite(STDERR, "❌ Файл .env не знайдено\n");
    exit(1);
}

$env = parse_ini_file($envPath);

if (!$env || empty($env['GROQ_API_KEY'])) {
    fwrite(STDERR, "❌ GROQ_API_KEY не заданий у .env\n");
    exit(1);
}

$apiKey = $env['GROQ_API_KEY'];
$model  = $env['AI_MODEL'] ?? 'llama-3.1-8b-instant';


if (!$apiKey) {
    fwrite(STDERR, "GROQ_API_KEY не заданий\n");
    exit(1);
}

$input = stream_get_contents(STDIN);
if (!$input) {
    fwrite(STDERR, "Немає вхідних даних\n");
    exit(1);
}

$prompt = <<<PROMPT
Ти senior web-розробник.

Правила:
- Відповідай українською
- Коротко і по суті
- Мови програмування на яких потрібно писати код: PHP 7.x+, javascript + jQuery, angularJs 1.7
- Виконуй завдання до коду чітко і по суті.

Формат запиту буде:
Між //...// — завдання
Нижче — код

Якщо в запиті лише завдання то виконай його.

$input
PROMPT;

$payload = [
    'model' => $model,
    'messages' => [
        ['role' => 'user', 'content' => $prompt]
    ],
    'temperature' => 0.2,
];

$ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (!isset($data['choices'][0]['message']['content'])) {
    fwrite(STDERR, "Помилка API\n$response\n");
    exit(1);
}

echo $data['choices'][0]['message']['content'] . PHP_EOL;