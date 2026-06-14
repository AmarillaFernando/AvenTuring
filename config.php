<?php
// Cargar variables desde .env a las variables de entorno y proporcionar helper env()
if (!function_exists('env')) {
    $dotenv = __DIR__ . '/.env';
    if (file_exists($dotenv)) {
        $lines = file($dotenv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) continue;
            if (strpos($line, '=') === false) continue;
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            // remover comillas
            if ((substr($value,0,1) === '"' && substr($value,-1) === '"') || (substr($value,0,1) === "'" && substr($value,-1) === "'")) {
                $value = substr($value,1,-1);
            }
            if (getenv($name) === false) {
                putenv("$name=$value");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    function env(string $key, string $default = ''): string {
        // Primero busca en variables de entorno del servidor (Railway, etc)
        $serverVal = getenv($key);
        if ($serverVal !== false) return $serverVal;

        // Luego busca en .env local
        static $vars = null;
        if ($vars === null) {
            $vars = [];
            $file = __DIR__ . '/.env';
            if (file_exists($file)) {
                foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                    if (str_starts_with(trim($line), '#')) continue;
                    [$k, $v] = explode('=', $line, 2);
                    $vars[trim($k)] = trim($v);
                }
            }
        }

        return $vars[$key] ?? $default;
    }
}
