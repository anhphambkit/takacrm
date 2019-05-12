<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2/17/19
 * Time: 16:23
 */

namespace Core\Setting\Services\Implement;

use Core\Setting\Repositories\Interfaces\AddressGeneralInfoRepositories;
use Core\Setting\Services\AddressGeneralInfoService;

class ImplementAddressGeneralInfoService implements AddressGeneralInfoService
{
    private $addressGeneralInfoRepository;

    /**
     * ImplementAddressGeneralInfoService constructor.
     */
    public function __construct(AddressGeneralInfoRepositories $addressGeneralInfoRepository)
    {
        $this->addressGeneralInfoRepository = $addressGeneralInfoRepository;
    }

    /**
     * @param int $countryId
     * @return mixed
     * @throws \Exception
     */
    public function getProvincesCitiesByCountryId(int $countryId = 0) {
        try {
            return $this->addressGeneralInfoRepository->getProvincesCitiesByCountryId($countryId);
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $cityId
     * @return mixed
     * @throws \Exception
     */
    public function getDistrictsByCityId(int $cityId) {
        try {
            return $this->addressGeneralInfoRepository->getDistrictsByCityId($cityId);
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $districtId
     * @return mixed
     * @throws \Exception
     */
    public function getWardsByDistrictId(int $districtId) {
        try {
            return $this->addressGeneralInfoRepository->getWardsByDistrictId($districtId);
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}