<?php

namespace App\Services;

use App\Repositories\CityRepository;
use App\Utilities\ValidatorUtility;

/**
 * Service class for handling city-related business logic
 * 
 * This class acts as a business logic layer between the API endpoints
 * and the repository layer. It handles validation and data processing
 * for city-related operations.
 */
class CityService
{
    /**
     * @var CityRepository Repository instance for city data access
     */
    protected CityRepository $repo;

    /**
     * Constructor - Initializes the service with a repository instance
     * 
     * @param CityRepository $repo Repository instance for city data access
     */
    public function __construct(CityRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Retrieves cities with optional filtering and pagination
     * 
     * @param array $data Request parameters including filters and pagination
     * @return bool|array Array of cities or false on failure
     */
    public function getCities(array $data): bool|array
    {
        return $this->repo->getCities($data);
    }

    /**
     * Adds a new city to the database
     * 
     * @param array $data City data including name and province_id
     * @return bool|int Number of affected rows or false on validation failure
     */
    public function addCity(array $data): bool|int
    {
        $province_id = $data['province_id'];
        $city_name = $data['name'];

        if (!ValidatorUtility::isValidProvinceId($province_id) || !ValidatorUtility::isValidCityName($city_name)) {
            return false;
        }
        return $this->repo->addCity($data);
    }

    /**
     * Updates the name of an existing city
     * 
     * @param array $data City data including city_id and new name
     * @return bool|int Number of affected rows or false on validation failure
     */
    public function changeCityName(array $data): bool|int
    {
        $city_id = $data['city_id'];
        $city_name = $data['name'];

        if (!ValidatorUtility::isValidCityId($city_id) || !ValidatorUtility::isValidCityName($city_name)) {
            return false;
        }
        return $this->repo->changeCityName($city_id, $city_name);
    }

    /**
     * Deletes a city from the database
     * 
     * @param array $data City data including city_id
     * @return bool|int Number of affected rows or false on validation failure
     */
    public function deleteCity(array $data): bool|int
    {
        $city_id = $data['city_id'];

        if (!ValidatorUtility::isValidCityId($city_id)) {
            return false;
        }
        return $this->repo->deleteCity($city_id);
    }
}
