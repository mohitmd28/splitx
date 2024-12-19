<?php

namespace Core;

class Session
{
    /**
     * Determine if session has given key
     * 
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return (bool) static::get($key);
    }

    /**
     * Put the value in the session with the given key
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function put(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get the given key value from the session
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null): mixed
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    /**
     * Flash a value to a given key in session
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * Unflash a flash key
     * 
     * @return void
     */
    public function unflash(): void
    {
        unset($_SESSION['_flash']);
    }

    /**
     * Flush the session
     * 
     * @return void
     */
    public function flush()
    {
        $_SESSION = [];
    }

    /**
     * Destroy the session
     * 
     * @return void
     */
    public function destroy()
    {
        $this->flush();

        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
