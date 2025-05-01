<?php

namespace App\Repositories;

use App\Core\Database;
use App\Utilities\QueryUtility;

/**
 * Repository class for handling province-related database operations
 * 
 * This class provides methods for CRUD operations on the province table,
 * including filtering, ordering, and pagination capabilities.
 */
class ProvinceRepository
{
    /**
     * @var \PDO Database connection instance
     */
    protected $db;

    /**
     * @var string Database table name
     */
    protected $table = 'province';

    /**
     * Constructor - Initializes database connection
     */
    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Retrieves provinces with optional ordering and pagination
     * 
     * @param array $data Optional parameters for ordering and pagination
     * @return array Array of province objects
     */
    public function getProvinces(array $data = []): array
    {
        $fields = QueryUtility::fieldsFilter($data, $this->table);
        $sql = "SELECT $fields FROM {$this->table}";

        $ordering = QueryUtility::orderbyFilter($data, $this->table);
        if (!empty($ordering)) {
            $sql .= " $ordering";
        }

        $pagination = QueryUtility::paginationFilter($data);
        if (!empty($pagination)) {
            $sql .= " $pagination";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Adds a new province to the database
     * 
     * @param array $data Province data containing name
     * @return bool|int Number of affected rows or false on failure
     */
    public function addProvince(array $data): bool|int
    {
        $sql = "INSERT INTO {$this->table} (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $data['name']
        ]);

        return $stmt->rowCount();
    }

    /**
     * Updates the name of an existing province
     * 
     * @param int $province_id ID of the province to update
     * @param string $name New name for the province
     * @return int Number of affected rows
     */
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

    /**
     * Deletes a province from the database
     * 
     * @param int $province_id ID of the province to delete
     * @return int Number of affected rows
     */
    public function deleteProvince(int $province_id): int
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $province_id]);

        return $stmt->rowCount();
    }
}
