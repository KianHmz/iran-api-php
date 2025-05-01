<?php

namespace App\Services;

use App\Repositories\ProvinceRepository;
use App\Utilities\ValidatorUtility;

/**
 * Service class for handling province-related business logic
 * 
 * This class acts as a business logic layer between the API endpoints
 * and the repository layer. It handles validation and data processing
 * for province-related operations.
 */
class ProvinceService
{
    /**
     * @var ProvinceRepository Repository instance for province data access
     */
    protected ProvinceRepository $repo;

    /**
     * Constructor - Initializes the service with a repository instance
     * 
     * @param ProvinceRepository $repo Repository instance for province data access
     */
    public function __construct(ProvinceRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Retrieves provinces with optional filtering and pagination
     * 
     * @param array $data Request parameters including filters and pagination
     * @return bool|array Array of provinces or false on failure
     */
    public function getProvinces(array $data): bool|array
    {
        return $this->repo->getProvinces($data);
    }

    /**
     * Adds a new province to the database
     * 
     * @param array $data Province data including name
     * @return bool|int Number of affected rows or false on validation failure
     */
    public function addProvince(array $data): bool|int
    {
        $province_name = $data['name'];

        if (!ValidatorUtility::isValidProvinceName($province_name)) {
            return false;
        }
        return $this->repo->addProvince($data);
    }

    /**
     * Updates the name of an existing province
     * 
     * @param array $data Province data including province_id and new name
     * @return bool|int Number of affected rows or false on validation failure
     */
    public function changeProvinceName(array $data): bool|int
    {
        $province_id = $data['province_id'];
        $province_name = $data['name'];

        if (!ValidatorUtility::isValidProvinceId($province_id) || !ValidatorUtility::isValidProvinceName($province_name)) {
            return false;
        }
        return $this->repo->changeProvinceName($province_id, $province_name);
    }

    /**
     * Deletes a province from the database
     * 
     * @param array $data Province data including province_id
     * @return bool|int Number of affected rows or false on validation failure
     */
    public function deleteProvince(array $data): bool|int
    {
        $province_id = $data['province_id'];

        if (!ValidatorUtility::isValidProvinceId($province_id)) {
            return false;
        }
        return $this->repo->deleteProvince($province_id);
    }
}
