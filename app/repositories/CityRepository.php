<?php

namespace App\Repositories;

use App\Core\Database;
use App\Utilities\QueryUtility;

/**
 * Repository class for handling city-related database operations
 * 
 * This class provides methods for CRUD operations on the city table,
 * including filtering, ordering, and pagination capabilities.
 */
class CityRepository
{
    /**
     * @var \PDO Database connection instance
     */
    protected $db;

    /**
     * @var string Database table name
     */
    protected $table = 'city';

    /**
     * Constructor - Initializes database connection
     */
    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Retrieves cities with optional filtering, ordering, and pagination
     * 
     * @param array $data Optional parameters for filtering, ordering, and pagination
     * @return array Array of city objects
     */
    public function getCities(array $data = []): array
    {
        $fields = QueryUtility::fieldsFilter($data, $this->table);
        $sql = "SELECT $fields FROM {$this->table}";

        list($where, $params) = QueryUtility::provinceIdFilter($data);
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $ordering = QueryUtility::orderbyFilter($data, $this->table);
        if (!empty($ordering)) {
            $sql .= " $ordering";
        }

        $pagination = QueryUtility::paginationFilter($data);
        if (!empty($pagination)) {
            $sql .= " $pagination";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Adds a new city to the database
     * 
     * @param array $data City data containing province_id and name
     * @return bool|int Number of affected rows or false on failure
     */
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

    /**
     * Updates the name of an existing city
     * 
     * @param int $city_id ID of the city to update
     * @param string $name New name for the city
     * @return int Number of affected rows
     */
    public function changeCityName(int $city_id, string $name): int
    {
        $sql = "UPDATE {$this->table} SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':id' => $city_id
        ]);

        return $stmt->rowCount();
    }

    /**
     * Deletes a city from the database
     * 
     * @param int $city_id ID of the city to delete
     * @return int Number of affected rows
     */
    public function deleteCity(int $city_id): int
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $city_id]);

        return $stmt->rowCount();
    }
}
