<?php

namespace App\Services;

use App\Repositories\CityRepository;
use App\Utilities\Validator;


class CityService
{
    protected CityRepository $repo;

    public function __construct(CityRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getCities(array $data): bool|array
    {
        return $this->repo->getCities($data);
    }

    public function addCity(array $data): bool|int
    {
        $province_id = $data['province_id'];
        $city_name = $data['name'];

        if (!Validator::isValidProvinceId($province_id) || !Validator::isValidCityName($city_name)) {
            return false;
        }
        return $this->repo->addCity($data);
    }

    public function changeCityName(array $data): bool|int
    {
        $city_id = $data['city_id'];
        $city_name = $data['name'];

        if (!Validator::isValidCityId($city_id) || !Validator::isValidCityName($city_name)) {
            return false;
        }
        return $this->repo->changeCityName($city_id, $city_name);
    }


    public function deleteCity(array $data): bool|int
    {
        $city_id = $data['city_id'];

        if (!Validator::isValidCityId($city_id)) {
            return false;
        }
        return $this->repo->deleteCity($city_id);
    }
}
