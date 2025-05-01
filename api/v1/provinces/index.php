<?php

require_once __DIR__ . '../../../../bootstrap.php';

use App\Repositories\ProvinceRepository;
use App\Services\ProvinceService;
use App\Utilities\Response;
use App\Utilities\CacheUtility;

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestBody = json_decode(file_get_contents('php://input'), true);

$responseData = [];
$responseStatusCode = Response::HTTP_OK;

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
        $responseStatusCode = empty($responseData) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;
        break;

    case 'POST':
        $responseData = $ps->addProvince($requestBody);
        $responseStatusCode = empty($responseData) ? Response::HTTP_NOT_ACCEPTABLE : Response::HTTP_CREATED;
        break;

    case 'PUT':
        $responseData = $ps->changeProvinceName($requestBody);
        $responseStatusCode = empty($responseData) ? Response::HTTP_NOT_ACCEPTABLE : Response::HTTP_OK;
        break;

    case 'DELETE':
        $province_id = $_GET['province_id'] ?? null;
        $requestData = ['province_id' => $province_id];
        $responseData = $ps->deleteProvince($requestData);
        $responseStatusCode = empty($responseData) ? Response::HTTP_NOT_ACCEPTABLE : Response::HTTP_OK;
        break;

    default:
        $responseData = ['error' => 'Invalid Request Method'];
        $responseStatusCode = Response::HTTP_BAD_REQUEST;
        break;
}

echo Response::respond($responseData, $responseStatusCode);

CacheUtility::end();

exit;