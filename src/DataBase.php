<?php

namespace Rum\Sandbox;

class DataBase
{
    protected \PDO $connection;

    protected \PDOStatement $stmt;

    public function __construct()
    {
        $dsn = "mysql:host=". read_env('DB_HOST') .";dbname=". read_env('DB_DATABASE')
            . ";charset=". DB_SETTINGS['charset'];

        try {
            $this->connection = new \PDO(
                $dsn, read_env('DB_USERNAME'), read_env('DB_PASSWORD'),
                DB_SETTINGS['options']
            );
        } catch ( \PDOException $e){
            error_log("[" . date('Y-m-d H:i:s') . "] DB Error: {$e->getMessage()}" . PHP_EOL, 3, ERROR_LOGS);
            abort('DB error connection', 500);
        }

        return $this;
    }

    public function query(string $query, array $params=[]): static
    {
        $this->stmt = $this->connection->prepare($query);
//        dump($params, $query);

        $this->stmt->execute($params);
        return $this;
    }

    public function get(): array|false
    {
        return $this->stmt->fetchAll();
    }

    public function getAssoc($key = 'id'): array
    {
        $data = [];
        while ($row = $this->stmt->fetch()){
            $data[$row[$key]] = $row;
        }
        return $data;
    }

    public function getOne()
    {
        return $this->stmt->fetch();
    }

    public function getColumn()
    {
        return $this->stmt->fetchColumn();
    }

    public function findAll($tbl): array|false
    {
        $this->query("select * from {$tbl}");
        return $this->stmt->fetchAll();
    }

    public function findOne($tbl, $value, $field='id')
    {
        $this->query("select * from {$tbl} where $field = ? LIMIT 1", [$value]);
        return $this->stmt->fetch();
    }

    public function findOrFail($tbl, $value, $field = 'id')
    {
        $res = $this->findOne($tbl, $value, $field);
        if(!$res){
            if ($_SERVER['HTTP_ACCEPT'] == 'application/json'){
                response()->json([
                    'status'=>'error',
                    'answer'=>'not found'
                ], 404);
            }
            abort();
        }
        return $res;
    }

    public function getLast($tbl)
    {
        $this->query("select * from {$tbl} ORDER BY id DESC LIMIT 1");
        return $this->stmt->fetch();
    }

    public function lastInsertId(): false|string
    {
        return $this->connection->lastInsertId();
    }

    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->connection->commit();
    }

    public function rollback(): bool
    {
        return $this->connection->rollback();
    }

    public function getInsertId()
    {
        return $this->connection->lastInsertId();
    }
}