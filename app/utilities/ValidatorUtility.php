<?php

namespace App\Utilities;

/**
 * Validation utility class for input data
 * 
 * This class provides methods for validating various types of input data
 * used throughout the application.
 */
class ValidatorUtility
{
    /**
     * Validates a city name
     * 
     * @param mixed $city_name City name to validate
     * @return bool True if the city name is valid, false otherwise
     */
    public static function isValidCityName($city_name): bool
    {
        return !isset($city_name) || empty($city_name) ? false : true;
    }

    /**
     * Validates a city ID
     * 
     * @param mixed $city_id City ID to validate
     * @return bool True if the city ID is valid, false otherwise
     */
    public static function isValidCityId($city_id): bool
    {
        return empty($city_id) || !is_numeric($city_id) ? false : true;
    }

    /**
     * Validates a province name
     * 
     * @param mixed $province_name Province name to validate
     * @return bool True if the province name is valid, false otherwise
     */
    public static function isValidProvinceName($province_name): bool
    {
        return !isset($province_name) || empty($province_name) ? false : true;
    }

    /**
     * Validates a province ID
     * 
     * @param mixed $province_id Province ID to validate
     * @return bool True if the province ID is valid, false otherwise
     */
    public static function isValidProvinceId($province_id): bool
    {
        return empty($province_id) || !is_numeric($province_id) ? false : true;
    }

    /**
     * Validates a numeric value
     * 
     * @param mixed $number Value to validate
     * @return bool True if the value is a valid number, false otherwise
     */
    public static function isValidNumeric($number): bool
    {
        return empty($number) || !is_numeric($number) ? false : true;
    }
}
