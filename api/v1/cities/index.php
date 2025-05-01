<?php

require_once __DIR__ . '../../../../bootstrap.php';

use App\Repositories\CityRepository;
use App\Services\CityService;
use App\Utilities\Response;
use App\Utilities\CacheUtility;

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestBody = json_decode(file_get_contents('php://input'), true);

$responseData = [];
$responseStatusCode = Response::HTTP_OK;

$cs = new CityService(new CityRepository());

CacheUtility::start();

switch ($requestMethod) {

    case 'GET':
        $requestData = [
            'province_id' => $_GET['province_id'] ?? null,
            'fields' => $_GET['fields'] ?? null,
            'orderby' => $_GET['orderby'] ?? null,
            'page' => $_GET['page'] ?? null,
            'page_size' => $_GET['page_size'] ?? null
        ];
        $responseData = $cs->getCities($requestData);
        $responseStatusCode = empty($responseData) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;
        break;

    case 'POST':
        $responseData = $cs->addCity($requestBody);
        $responseStatusCode = empty($responseData) ? Response::HTTP_NOT_ACCEPTABLE : Response::HTTP_CREATED;
        break;

    case 'PUT':
        $responseData = $cs->changeCityName($requestBody);
        $responseStatusCode = empty($responseData) ? Response::HTTP_NOT_ACCEPTABLE : Response::HTTP_OK;
        break;

    case 'DELETE':
        $city_id = $_GET['city_id'] ?? null;
        $requestData = ['city_id' => $city_id];
        $responseData = $cs->deleteCity($requestData);
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
