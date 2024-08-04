<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\ModelContract;

abstract class BaseRepository
{
    protected $model;

    public function __construct(protected \PDO $database)
    {
    }

    public function getById(int | string $id): ModelContract {
        $query = 'SELECT * FROM `' . $this->model::$table . '` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $model = $statement->fetchObject($this->model);
        if (! $model) {
            throw new \Exception('Model ' . $this->model . ' not found.', 404);
        }

        return $model;
    }

    public function getByIds(array $ids): array {
        $idsString = implode("','", $ids);
        $query = 'SELECT * FROM `' . $this->model::$table . '` WHERE `id` IN (\'' . $idsString . '\')';
        $statement = $this->database->prepare($query);
        $statement->execute();
        $models = $statement->fetchAll(\PDO::FETCH_CLASS, $this->model);
        if (! $models) {
            throw new \Exception('Models ' . $this->model . ' not found.', 404);
        }

        return $models;
    }
}