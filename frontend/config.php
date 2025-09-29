<?php
// Load .env file if exists
if (!function_exists('loadEnvFile')) {
    function loadEnvFile(string $path): void
    {
        if (!is_readable($path))
            return;
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $trim = trim($line);
            if ($trim === '' || str_starts_with($trim, '#'))
                continue;
            if (!str_contains($trim, '='))
                continue;
            [$key, $value] = array_map('trim', explode('=', $trim, 2));
            // Strip optional surrounding quotes
            if ((str_starts_with($value, '"') && str_ends_with($value, '"')) || (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
                $value = substr($value, 1, -1);
            }
            if ($key !== '') {
                // Don't overwrite existing env
                if (getenv($key) === false) {
                    putenv($key . '=' . $value);
                }
                $_ENV[$key] = $value;
                if (!array_key_exists($key, $_SERVER)) {
                    $_SERVER[$key] = $value;
                }
            }
        }
    }
}

// Attempt to load project root .env (one level above this config file)
loadEnvFile(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');

const _MODULE = 'indexphp';
const _ACTION = 'userhomepage';
const _CODE = true;

// Host / Path settings
define('_WEB_HOST', 'http://' . $_SERVER['HTTP_HOST'] . '/frontend');
define('_WEB_HOST_TEMPLATE', _WEB_HOST . '/templates');
define('_WEB_PATH', __DIR__);
define('_WEB_PATH_TEMPLATE', _WEB_PATH . '/templates');

if (!defined('_OPENROUTER_API_KEY')) {
    $envKey = getenv('OPENROUTER_API_KEY');
    define('_OPENROUTER_API_KEY', $envKey !== false ? $envKey : '');
}
?>