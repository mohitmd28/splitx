<?php

namespace Core\Database;

use Core\App;
use Core\Database\Builder;

class Database
{
    /**
     * Set a table for the query
     *  
     * @param string $table
     * @return \Core\Database\Builder 
     */
    public static function table(string $table): Builder
    {
        return App::resolve(Builder::class)->from($table);
    }
}
