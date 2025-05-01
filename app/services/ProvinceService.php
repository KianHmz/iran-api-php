<?php

namespace App\Services;

use App\Repositories\ProvinceRepository;
use App\Utilities\Validator;


class ProvinceService
{
    protected ProvinceRepository $repo;

    public function __construct(ProvinceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getProvinces(array $data): bool|array
    {
        return $this->repo->getProvinces($data);
    }

    public function addProvince(array $data): bool|int
    {
        $province_name = $data['name'];

        if (!Validator::isValidProvinceName($province_name)) {
            return false;
        }
        return $this->repo->addProvince($data);
    }

    public function changeProvinceName(array $data): bool|int
    {
        $province_id = $data['province_id'];
        $province_name = $data['name'];

        if (!Validator::isValidProvinceId($province_id) || !Validator::isValidProvinceName($province_name)) {
            return false;
        }
        return $this->repo->changeProvinceName($province_id, $province_name);
    }

    public function deleteProvince(array $data): bool|int
    {
        $province_id = $data['province_id'];

        if (!Validator::isValidProvinceId($province_id)) {
            return false;
        }
        return $this->repo->deleteProvince($province_id);
    }
}
