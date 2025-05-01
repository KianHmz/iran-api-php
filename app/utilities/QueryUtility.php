<?php

namespace App\Utilities;

use App\Core\Database;
use App\Utilities\ValidatorUtility;

/**
 * Query utility class for building SQL queries with dynamic filters
 * 
 * This class provides methods for constructing SQL queries with various
 * filtering options including field selection, ordering, and pagination.
 */
class QueryUtility
{
    /**
     * Retrieves all column names from a database table
     * 
     * @param string $table_name Name of the table to get columns from
     * @return array Array of column names
     */
    public static function getColumns(string $table_name): array
    {
        $db = Database::connect();
        $stmt = $db->query("SHOW COLUMNS FROM $table_name");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Filters and validates requested fields for SQL SELECT statement
     * 
     * @param array $data Request data containing fields parameter
     * @param string $table_name Name of the table to validate fields against
     * @return string Comma-separated list of valid fields or '*' for all fields
     */
    public static function fieldsFilter(array $data, string $table_name): string
    {
        $fields = $data['fields'] ?? '*';

        if ($fields !== '*') {
            $requested_fields = isset($_GET['fields']) ? explode(',', $_GET['fields']) : [];

            $columns = self::getColumns($table_name);
            $valid_fields = array_intersect($requested_fields, $columns);

            $fields = !empty($valid_fields) ? implode(", ", array_map('trim', $valid_fields)) : '*';
        }

        return $fields;
    }

    /**
     * Creates WHERE clause and parameters for province_id filtering
     * 
     * @param array $data Request data containing province_id parameter
     * @return array Array containing WHERE clause parts and parameters
     */
    public static function provinceIdFilter(array $data): array
    {
        $where = [];
        $params = [];

        if (ValidatorUtility::isValidProvinceId($data['province_id'])) {
            $where[] = "province_id = :province_id";
            $params[':province_id'] = $data['province_id'];
        }

        return [$where, $params];
    }

    /**
     * Creates LIMIT clause for pagination
     * 
     * @param array $data Request data containing page and page_size parameters
     * @return string|null LIMIT clause or null if pagination parameters are invalid
     */
    public static function paginationFilter(array $data): ?string
    {
        if (
            ValidatorUtility::isValidNumeric($data['page']) &&
            ValidatorUtility::isValidNumeric($data['page_size'])
        ) {
            $offset = (int)$data['page_size'] * ((int)$data['page'] - 1);
            $limit = (int)$data['page_size'];

            return "LIMIT $offset, $limit";
        }

        return null;
    }

    /**
     * Creates ORDER BY clause for sorting
     * 
     * @param array $data Request data containing orderby parameter
     * @param string $table_name Name of the table to validate sort field against
     * @return string|null ORDER BY clause or null if sort parameters are invalid
     */
    public static function orderbyFilter(array $data, $table_name): ?string
    {
        if (!isset($data['orderby']) || empty($data['orderby'])) {
            return null;
        }

        $orderby = explode(' ', $data['orderby']);
        $field = strtolower($orderby[0]) ?? 'id';
        $order = strtoupper($orderby[1]) ?? 'ASC';

        $columns = self::getColumns($table_name);

        if (!in_array($field, $columns)) {
            return null;
        }

        if (!in_array($order, ['ASC', 'DESC'])) {
            return null;
        }

        return "ORDER BY $field $order";
    }
}
