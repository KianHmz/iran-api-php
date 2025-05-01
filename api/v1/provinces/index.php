<?php

/**
 * Provinces API Endpoint
 * 
 * This file handles all HTTP requests related to province operations.
 * It supports GET, POST, PUT, and DELETE methods for managing province data.
 * 
 * GET Parameters:
 * - fields: Comma-separated list of fields to return
 * - orderby: Field and direction for sorting (e.g., "name ASC")
 * - page: Page number for pagination
 * - page_size: Number of items per page
 * 
 * POST/PUT Body:
 * - name: Province name
 * 
 * DELETE Parameters:
 * - province_id: ID of the province to delete
 * 
 * @package App\API\v1
 */

require_once __DIR__ . '../../../../bootstrap.php';

use App\Repositories\ProvinceRepository;
use App\Services\ProvinceService;
use App\Utilities\ResponseUtility;
use App\Utilities\CacheUtility;

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestBody = json_decode(file_get_contents('php://input'), true);

$responseData = [];
$responseStatusCode = ResponseUtility::HTTP_OK;

$ps = new ProvinceService(new ProvinceRepository());

CacheUtility::start();

switch ($requestMethod) {

    case 'GET':
        $requestData = [
            'fields' => $_GET['fields'] ?? null,
            'orderby' => $_GET['orderby'] ?? null,
            'page' => $_GET['page'] ?? null,
            'page_size' => $_GET['page_size'] ?? null
        ];
        $responseData = $ps->getProvinces($requestData);
        $responseStatusCode = empty($responseData) ? ResponseUtility::HTTP_NOT_FOUND : ResponseUtility::HTTP_OK;
        break;

    case 'POST':
        $responseData = $ps->addProvince($requestBody);
        $responseStatusCode = empty($responseData) ? ResponseUtility::HTTP_NOT_ACCEPTABLE : ResponseUtility::HTTP_CREATED;
        break;

    case 'PUT':
        $responseData = $ps->changeProvinceName($requestBody);
        $responseStatusCode = empty($responseData) ? ResponseUtility::HTTP_NOT_ACCEPTABLE : ResponseUtility::HTTP_OK;
        break;

    case 'DELETE':
        $province_id = $_GET['province_id'] ?? null;
        $requestData = ['province_id' => $province_id];
        $responseData = $ps->deleteProvince($requestData);
        $responseStatusCode = empty($responseData) ? ResponseUtility::HTTP_NOT_ACCEPTABLE : ResponseUtility::HTTP_OK;
        break;

    default:
        $responseData = ['error' => 'Invalid Request Method'];
        $responseStatusCode = ResponseUtility::HTTP_BAD_REQUEST;
        break;
}

echo ResponseUtility::respond($responseData, $responseStatusCode);

CacheUtility::end();

exit;