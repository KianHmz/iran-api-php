<?php

namespace App\Repositories;

use App\Core\Database;
use App\Utilities\QueryHelper;

class CityRepository
{
    protected Database $db;
    protected $table = 'city';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getCities(array $data = []): array
    {
        $fields = QueryHelper::fieldsFilter($data, $this->table);
        $sql = "SELECT $fields FROM {$this->table}";

        list($where, $params) = QueryHelper::provinceIdFilter($data);
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $ordering = QueryHelper::orderbyFilter($data, $this->table);
        if (!empty($ordering)) {
            $sql .= " $ordering";
        }

        $pagination = QueryHelper::paginationFilter($data);
        if (!empty($pagination)) {
            $sql .= " $pagination";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function addCity(array $data): bool|int
    {
        $sql = "INSERT INTO {$this->table} (province_id, name) VALUES (:province_id, :name)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':province_id' => $data['province_id'],
            ':name' => $data['name']
        ]);

        return $stmt->rowCount();
    }
}
