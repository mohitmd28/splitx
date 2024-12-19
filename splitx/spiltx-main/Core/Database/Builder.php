<?php

namespace Core\Database;

use PDOStatement;
use Exception;
use PDO;

class Builder
{
    /**
     * @var \Core\Database\Connection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $columns;

    /**
     * @var array
     */
    protected $aggregate;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var array
     */
    protected $joins;

    /**
     * @var array
     */
    public $wheres = [];

    /**
     * @var array
     */
    public $bindings = [];

    /**
     * @var array
     */
    public $groupsBys;

    /**
     * @var array
     */
    public $orders;

    /**
     * @var int
     */
    public $limit;

    /**
     * @var int
     */
    public $offset;

    /**
     *
     * @var array
     */
    public $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>',
        'rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];

    /**
     * Initialization
     * 
     * @param string $host
     * @param string $database
     * @param string $username
     * @param string $password
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function select($columns = ['*']): self
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();

        return $this;
    }

    /**
     * Set the table for the query.
     *
     * @param  string  $table
     * @return $this
     */
    public function from(string $table): self
    {
        $this->from = $table;

        return $this;
    }

    /**
     * Add a join clause
     * 
     * @param string $table
     * @param string $firstColumn
     * @param string $operator
     * @param string $secondColumn
     * @param string $type
     * @return $this
     */
    public function join(string $table, string $firstColumn, string $operator, string $secondColumn, string $type = 'INNER'): self
    {
        if (!in_array($operator, $this->operators))
            throw new Exception('Invalid operator provided');

        if (!in_array($type, ['INNER', 'LEFT', 'RIGHT']))
            throw new Exception('Invalid join type provided');

        $this->joins[] = compact('table', 'firstColumn', 'operator', 'secondColumn', 'type');

        return $this;
    }

    /**
     * Add a where clause
     * 
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @param string $boolean
     * @return $this
     */
    public function where(string $column, string $operator = '=', mixed $value = null, string $boolean = 'AND'): self
    {
        list($value, $operator) = func_num_args() === 2
            ? [$operator, '='] : [$value, $operator];

        if (!in_array($operator, $this->operators))
            throw new Exception('Invalid operator provided');

        $type = 'Basic';

        $this->wheres[] = compact('type', 'column', 'value', 'operator', 'boolean');

        $this->bindings['where'][] = $value;

        return $this;
    }

    /**
     * Add or where clause
     * 
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return $this
     */
    public function orWhere(string $column, string $operator = '=', mixed $value = null): self
    {
        list($value, $operator) = func_num_args() === 2
            ? [$operator, '='] : [$value, $operator];

        $this->where($column, $operator, $value, 'OR');

        return $this;
    }

    /**
     * Add where in caluse
     * 
     * @param string $column
     * @param array $values
     * @return $this
     */
    public function whereIn(string $column, array $values, string $boolean = 'AND'): self
    {
        $type = 'In';

        $this->wheres[] = compact('type', 'column', 'values', 'boolean');

        $this->bindings['where'][] = $values;

        return $this;
    }

    /**
     * Add group by clause
     * 
     * @param array ...$columns
     * @return $this
     */
    public function groupBy(...$columns): self
    {
        $this->groupsBys = array_merge($this->groupsBys ?? [], $columns);

        return $this;
    }

    /**
     * Add order by clause
     * 
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        if (!in_array($direction, ['ASC', 'DESC'], true))
            throw new Exception('Invalid Direction provided');

        $this->orders[] = compact('column', 'direction');

        return $this;
    }

    /**
     * Add limit clause
     * 
     * @param int $offset
     * @param int $limit
     * @return $this
     */
    public function limit(int $offset, int $limit = null): self
    {
        list($offset, $limit) = func_num_args() === 2
            ? [$offset, $limit] : [0, $offset];

        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    /**
     * Gets the result
     * 
     * @return array
     */
    public function get(): array
    {
        $sql = $this->buildSelectQuery();

        $statement = $this->connection->getPdo()->prepare($sql);

        if ($this->bindings['where'] ?? false) {
            $this->bindValues($statement, flatten_2dimensional_array($this->bindings['where']));
        }

        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Bind values
     *
     * @param  PDOStatement $statement
     * @param  array  $bindings
     * @return void
     */
    public function bindValues(PDOStatement $statement, array $bindings)
    {
        foreach ($bindings as $key => $value) {
            $statement->bindValue(
                is_string($key) ? $key : $key + 1,
                $value,
                is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }
    }

    /**
     * Get the first result
     * 
     * @return object|null
     */
    public function first(): object|null
    {
        return $this->limit(1)->get()[0] ?? null;
    }

    /**
     * Get total numbers of records for
     * the result query
     * 
     * @param string $column
     * @return int
     */
    public function count(string $column = '*'): int
    {
        return (int) $this->aggregate('count', $column);
    }

    /**
     * Run aggregate query
     * 
     * @param string $function
     * @param string $column
     * @return int
     */
    private function aggregate(string $function, string $column = '*')
    {
        $this->aggregate = compact('function', 'column');

        $records = $this->get();

        return $records[0]->aggregate;
    }

    /**
     * Insert data to the table
     * 
     * @param array $data
     * @return void
     */
    public function insert(array $values): void
    {
        if (!is_array(reset($values))) {
            $values = [$values];
        }

        $columns = implode(', ', array_map(fn ($column) => '`' . $column . '`', array_keys(reset($values))));

        $inserts = array_map(fn ($value) => '(' . implode(',', array_map(fn () => '?', $value)) . ")", $values);

        $query = "INSERT INTO `$this->from` ($columns) VALUES " . implode(', ', $inserts);

        $statement = $this->connection->getPdo()->prepare($query);

        $this->bindValues($statement, array_merge(
            ...array_map(fn ($value) => array_values($value), $values)
        ));

        $statement->execute();
    }

    /**
     * Insert data to the table and get the ID
     * 
     * @param array $data
     * @return int
     */
    public function insertGetId(array $values): int
    {
        $this->insert($values);

        $id =  $this->connection->getPdo()->lastInsertId();

        return is_numeric($id) ? (int) $id : $id;
    }

    /**
     * Perform updates of the columns
     * 
     * @param array $values
     * @return bool
     */
    public function update(array $values): bool
    {
        $columns = implode(', ', array_map(fn ($column) => "`" . $column . "` = ?", array_keys($values)));

        $wheres = $this->buildWheres();

        $query = trim("UPDATE `$this->from` SET $columns $wheres");

        $statement = $this->connection->getPdo()->prepare($query);

        $this->bindValues($statement, array_values(
            array_merge($values, $this->bindings['where'] ?? [])
        ));

        return $statement->execute();
    }

    /**
     * Delete records from table
     * 
     * @return bool
     */
    public function delete(): bool
    {
        $wheres = $this->buildWheres();

        $query = trim("DELETE FROM `$this->from` $wheres");

        $statement = $this->connection->getPdo()->prepare($query);

        $this->bindValues($statement, array_values($this->bindings['where'] ?? []));

        return $statement->execute();
    }

    /**
     * Builds SELECT query
     */
    protected function buildSelectQuery()
    {
        $sql = [];

        $sql[] = $this->buildColumns();
        $sql[] = $this->buildFrom();
        $sql[] = $this->buildJoins();
        $sql[] = $this->buildWheres();
        $sql[] = $this->buildGroupBy();
        $sql[] = $this->buildOrders();
        $sql[] = $this->buildLimit();

        return implode(' ', array_filter($sql));
    }

    /**
     * Builds columns portion
     * 
     * @return string
     */
    protected function buildColumns(): string
    {
        if (!empty($this->aggregate))
            return $this->buildAggregate();

        return 'SELECT ' . implode(', ', $this->columns ?? ['*']);
    }

    /**
     * Build select clause for aggregate function
     * 
     * @return string
     */
    protected function buildAggregate(): string
    {
        return  'SELECT ' . $this->aggregate['function'] . '(' . $this->aggregate['column'] . ') as aggregate';
    }

    /**
     * Builds FROM portion
     * 
     * @return string
     */
    protected function buildFrom(): string
    {
        return sprintf('FROM `%s`', $this->from);
    }

    /**
     * Builds JOIN portion
     * 
     * @return string
     */
    protected function buildJoins(): string
    {
        if (empty($this->joins)) return '';

        $joins = array_map(function ($join) {
            return $join['type'] . ' JOIN ' .  '`' . $join['table'] . '`' . ' ON ' . $join['firstColumn'] . ' ' . $join['operator'] . ' ' . $join['secondColumn'];
        }, $this->joins);

        return implode(' ', $joins);
    }

    /**
     * Builds WHERE portion
     * 
     * @return string
     */
    protected function buildWheres(): string
    {
        if (empty($this->wheres))
            return '';

        $wheres = array_map(function ($where) {
            return $this->{"buildWhere{$where['type']}"}($where);
        }, $this->wheres);

        return 'WHERE ' . preg_replace('/AND |OR /i', '', implode(' ', $wheres), 1);
    }

    /**
     * Builds basic where clause
     * 
     * @param array $where
     * @return string
     */
    protected function buildWhereBasic(array $where)
    {
        return $where['boolean'] . ' ' . $where['column'] . ' ' . $where['operator'] . ' ?';
    }

    /**
     * Builds where in clause
     * 
     * @param array $where
     * @return string
     */
    protected function buildWhereIn(array $where)
    {
        $placeholders = implode(', ', array_map(fn ($value) => '?', $where['values']));

        return $where['boolean'] . ' ' . $where['column'] . ' in (' . $placeholders . ')';
    }

    /**
     * Builds GROUP BY portion
     * 
     * @return string
     */
    protected function buildGroupBy(): string
    {
        if (empty($this->groupsBys)) return '';

        return 'GROUP BY ' . implode(', ', $this->groupsBys);
    }

    /**
     * Builds ORDER BY portion
     * 
     * @return string
     */
    protected function buildOrders(): string
    {
        if (empty($this->orders)) return '';

        return 'ORDER BY ' . implode(', ', array_map(fn ($order) => $order['column'] . ' ' . $order['direction'], $this->orders));
    }

    /**
     * Builds LIMIT portion
     * 
     * @return string
     */
    protected function buildLimit(): string
    {
        if (is_null($this->limit))
            return '';

        return sprintf('LIMIT %d, %d', $this->offset, $this->limit);
    }
}
