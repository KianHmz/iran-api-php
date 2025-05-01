<?php

namespace App\Repositories;

use App\Core\Database;
use App\Utilities\QueryHelper;

class ProvinceRepository
{
    protected $db;
    protected $table = 'province';

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getProvinces(array $data = []): array
    {
        $fields = QueryHelper::fieldsFilter($data, $this->table);
        $sql = "SELECT $fields FROM {$this->table}";

        $ordering = QueryHelper::orderbyFilter($data, $this->table);
        if (!empty($ordering)) {
            $sql .= " $ordering";
        }

        $pagination = QueryHelper::paginationFilter($data);
        if (!empty($pagination)) {
            $sql .= " $pagination";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function addProvince(array $data): bool|int
    {
        $sql = "INSERT INTO {$this->table} (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $data['name']
        ]);

        return $stmt->rowCount();
    }
}
