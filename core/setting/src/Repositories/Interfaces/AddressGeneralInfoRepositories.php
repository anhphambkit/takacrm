<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2/17/19
 * Time: 16:25
 */

namespace Core\Setting\Repositories\Interfaces;

interface AddressGeneralInfoRepositories
{
    /**
     * @param int $countryId | default VN = 0
     * @return mixed
     */
    public function getProvincesCitiesByCountryId(int $countryId = 0);

    /**
     * @param int $cityId
     * @return mixed
     */
    public function getDistrictsByCityId(int $cityId);

    /**
     * @param int $districtId
     * @return mixed
     */
    public function getWardsByDistrictId(int $districtId);
}