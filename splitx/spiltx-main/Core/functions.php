<?php

use Core\{App, Session, Validator, View};
use Core\Database\Database;

/**
 * Dump given variable
 * 
 * @param mixed $value
 * @return void
 */
function dump($value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

/**
 * Dump and Die given variable
 * 
 * @param mixed $value
 * @return void
 */
function dd($value): void
{
    dump($value);
    die();
}

/**
 * Load a give view file with data
 * 
 * @param string $file
 * @param array $data
 * @return void
 */
function view(string $file, array $data = []): void
{
    $view = new View($file, $data);
    $view->render();
}

/**
 * Abort the request
 * 
 * @param int $code
 * @return void
 */
function abort(int $code = 404): void
{
    http_response_code($code);

    require "../view/{$code}.view.php";

    die();
}

/**
 * Redirect to given location
 * 
 * @param string $location
 * @return void
 */
function redirect(string $location): void
{
    header("Location: /$location");
    die;
}

/**
 * Redirect to the previous location
 * 
 * @return void
 */
function redirectBack()
{
    header("Location: " . $_SERVER['HTTP_REFERER']);
    die;
}

/**
 * Get logged in user
 * 
 * @return object|null
 */
function user(): object|null
{
    return session()->get('user');
}

/**
 * Get the Database helper
 * 
 * @return \Core\Database\Database
 */
function database(): Database
{
    return new Database;
}

/**
 * Get the Session helper
 * 
 * @return \Core\Session
 */
function session(): Session
{
    return App::resolve(Session::class);
}

/**
 * Get the Validator
 * 
 * @return \Core\Validator
 */
function validator(): Validator
{
    return App::resolve(Validator::class);
}

/**
 * Get the given key's values from the given array
 * 
 * @param array $array
 * @param array|string
 */
function array_values_by_keys(array $array, array|string $key): array
{
    $keys = is_string($key) ? [$key] : $key;

    return array_filter($array, fn ($key) => in_array($key, $keys), ARRAY_FILTER_USE_KEY);
}

/**
 * Generate alphanumeric string
 * 
 * @param int $length
 * @return string
 */
function str_random(int $length = 5): String
{
    return substr(
        bin2hex(random_bytes($length)),
        0,
        $length
    );
}

/**
 * Get the previous value of the field
 * from the session
 * 
 * @param string $field
 * @param mixed $default
 * @return mixed
 */
function old(string $field, mixed $default = null): mixed
{
    $old = session()->get('old', []);

    return isset($old[$field]) ?  $old[$field] : $default;
}

/**
 * Flatten two dimensioal array
 * 
 * @param array $array
 * @return array
 */
function flatten_2dimensional_array(array $array): array
{
    return array_reduce($array, function ($carry, $item) {
        return array_merge($carry, (array) $item);
    }, []);
}

/**
 * Get the error message for the given
 * key from the errors in the session
 * 
 * @param string $key
 * @return string|null
 */
function error(string $key): string|null
{
    $old = session()->get('errors', []);

    return $old[$key] ?? null;
}

/**
 * Get the current date time
 * 
 * @return DateTime;
 */
function now(): DateTime
{
    return new DateTime();
}

/**
 * Generate created_at and updated_fields
 * to be used in database operations
 * 
 * @return array
 */
function generate_timestamp_fields(): array
{
    $now = now()->format('Y-m-d H:i:s');

    return [
        'created_at' => $now,
        'updated_at' => $now
    ];
}
