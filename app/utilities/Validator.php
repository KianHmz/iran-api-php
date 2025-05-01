<?php

namespace App\Utilities;

class Validator
{

    public static function isValidCityName($city_name): bool
    {
        return isset($city_name) || empty($city_name) ? false : true;
    }


    public static function isValidCityId($city_id): bool
    {
        return empty($city_id) || !is_numeric($city_id) ? false : true;
    }


    public static function isValidProvinceName($province_name): bool
    {
        return isset($province_name) || empty($province_name) ? false : true;
    }


    public static function isValidProvinceId($province_id): bool
    {
        return empty($province_id) || !is_numeric($province_id) ? false : true;
    }


    public static function isValidNumeric($number): bool
    {
        return empty($number) || !is_numeric($number) ? false : true;
    }
}
