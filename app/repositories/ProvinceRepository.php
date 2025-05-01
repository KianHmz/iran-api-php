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

    public function changeProvinceName(int $province_id, string $name): int
    {
        $sql = "UPDATE {$this->table} SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':id' => $province_id
        ]);

        return $stmt->rowCount();
    }

    public function deleteProvince(int $province_id): int
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $province_id]);

        return $stmt->rowCount();
    }
}
