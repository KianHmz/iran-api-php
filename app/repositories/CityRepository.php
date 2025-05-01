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
}
