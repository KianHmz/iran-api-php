<?php

namespace App\Utilities;

use App\Core\Database;
use App\Utilities\Validator;

class QueryHelper
{
    public static function getColumns(string $table_name): array
    {
        $db = Database::connect();
        $stmt = $db->query("SHOW COLUMNS FROM $table_name");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

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


    public static function provinceIdFilter(array $data): array
    {
        $where = [];
        $params = [];

        if (Validator::isValidProvinceId($data['province_id'])) {
            $where[] = "province_id = :province_id";
            $params[':province_id'] = $data['province_id'];
        }

        return [$where, $params];
    }

    public static function paginationFilter(array $data): ?string
    {
        if (
            Validator::isValidNumeric($data['page']) &&
            Validator::isValidNumeric($data['page_size'])
        ) {
            $offset = (int)$data['page_size'] * ((int)$data['page'] - 1);
            $limit = (int)$data['page_size'];

            return "LIMIT $offset, $limit";
        }

        return null;
    }

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
