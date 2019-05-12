<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-30
 * Time: 10:04
 */

namespace Core\Setting\Controllers\Ajax;

use Core\Base\Controllers\Admin\BaseAdminController;
use Core\Setting\Services\AddressGeneralInfoService;
use Illuminate\Http\Request;

class AddressController extends BaseAdminController
{
    protected $addressGeneralInfoService;

    public function __construct(AddressGeneralInfoService $addressGeneralInfoService) {
        $this->addressGeneralInfoService = $addressGeneralInfoService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistrictsByCity(Request $request) {
        $cityId = (int) $request->get('province_city_code');
        $districts = $this->addressGeneralInfoService->getDistrictsByCityId($cityId);
        return response()->json($districts);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWardsByDistrict(Request $request) {
        $districtId = (int) $request->get('district_code');
        $wards = $this->addressGeneralInfoService->getWardsByDistrictId($districtId);
        return response()->json($wards);
    }
}