<?php

namespace Plugins\Customer\Models;

use Core\Setting\Contracts\ReferenceConfig;
use Core\Setting\Models\District;
use Core\Setting\Models\ProvinceCity;
use Core\Setting\Models\Ward;
use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * Class Customer
 * @package Plugins\Customer\Models
 */
class Customer extends Model
{
	use SoftDeletes;
	
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'gender',
        'customer_code',
        'tax_code',
        'phone',
        'fax',
        'email',
        'value',
        'avatar',
        'description',
        'dob',
        'address',
        'province_city_code',
        'district_code',
        'ward_code',
        'website',
        'facebook',
        'user_manage_id',
        'customer_relationship_id',
        'note',
        'status',
        'type_reference_data',
        'introduce_person_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'customer_group_name',
        'customer_job_name',
        'customer_source_name',
        'customer_relation_name',
        'customer_relation_color_code',
        'ward_data',
        'district_data',
        'province_data',
        'user_manage_instance',
        'introduce_person_instance',
        'created_by_instance',
        'address_full',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function customerJobs()
    {
        return $this->belongsToMany(CustomerJob::class, 'customer_job_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function customerGroups()
    {
        return $this->belongsToMany(GroupCustomer::class, 'customer_group_relation', 'customer_id', 'customer_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function customerSources()
    {
        return $this->belongsToMany(CustomerSource::class, 'customer_source_relation');
    }

    /**
     * Get the contact of customer.
     */
    public function customerContacts()
    {
        return $this->hasMany(CustomerContact::class)->select(['customer_contacts.id as index', 'customer_contacts.*']);
    }

    /**
     * @param $value
     */
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = (empty($value)) ? null : format_date_time($value, 'Asia/Ho_Chi_Minh', 'Y-m-d', 'Y-m-d');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function createdByUser()
    {
        $userTable = env('DB_PREFIX') . app(User::class)->getTable();
        return $this->belongsTo(User::class, 'created_by')->select(['id', 'first_name', 'last_name', DB::raw("CONCAT({$userTable}.first_name, ' ', {$userTable}.last_name) as full_name"),'username', 'profile_image as avatar']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function userManage()
    {
        $userTable = env('DB_PREFIX') . app(User::class)->getTable();
        return $this->belongsTo(User::class, 'user_manage_id')->select(['id', 'first_name', 'last_name', DB::raw("CONCAT({$userTable}.first_name, ' ', {$userTable}.last_name) as full_name"),'username', 'profile_image as avatar']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function wardName()
    {
        return $this->belongsTo(Ward::class, 'ward_code', 'code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function districtName()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function provinceCityName()
    {
        return $this->belongsTo(ProvinceCity::class, 'province_city_code', 'code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function customerRelationData()
    {
        return $this->belongsTo(CustomerRelation::class, 'customer_relationship_id');
    }

    /**
     * @return string
     */
    public function getIntroducePerson()
    {
        if (empty($this->type_reference_data)) return null;

        if ($this->type_reference_data === ReferenceConfig::REFERENCE_USER_DATA)
            return ReferenceConfig::REFERENCE_USER_DATA . ": " . User::find($this->introduce_person_id)->getFullName();
        else if ($this->type_reference_data === ReferenceConfig::REFERENCE_CUSTOMER_DATA)
            return ReferenceConfig::REFERENCE_USER_DATA . ": " . Customer::find($this->introduce_person_id)->full_name;
    }

    /**
     * @param string $suffix
     * @return string
     */
    public function getCustomerGroupsDataRender(string $suffix = "")
    {
        $result = "";
        foreach ($this->customerGroups as $index => $customerGroup) {
            $result .= "{$customerGroup->name}";
            if ($index < $this->customerGroups->count() -1)
                $result .= ", {$suffix}";
        }
        return trim($result);
    }

    /**
     * @param string $suffix
     * @return string
     */
    public function getCustomerJobsDataRender(string $suffix = "")
    {
        $result = "";
        foreach ($this->customerJobs as $index => $customerJob) {
            $result .= "{$customerJob->name}";
            if ($index < $this->customerJobs->count() -1)
                $result .= ", {$suffix}";
        }
        return trim($result);
    }

    /**
     * @param string $suffix
     * @return string
     */
    public function getCustomerSourcesDataRender(string $suffix = "")
    {
        $result = "";
        foreach ($this->customerSources as $index => $customerSource) {
            $result .= "{$customerSource->name}";
            if ($index < $this->customerSources->count() -1)
                $result .= ", {$suffix}";
        }
        return trim($result);
    }

    /**
     * @return string
     */
    public function getCustomerGroupNameAttribute() {
        return $this->getCustomerGroupsDataRender("<br />");
    }

    /**
     * @return string
     */
    public function getCustomerJobNameAttribute() {
        $result = "";
        foreach ($this->customerJobs as $index => $customerJob) {
            $result .= "{$customerJob->name}";
            if ($index < $this->customerJobs->count() -1)
                $result .= ", <br />}";
        }
        return trim($result);
//        return $this->getCustomerJobsDataRender("<br />");
    }

    /**
     * @return string
     */
    public function getCustomerSourceNameAttribute() {
        return $this->getCustomerSourcesDataRender("<br />");
    }

    /**
     * @return string
     */
    public function getCustomerRelationNameAttribute() {
        return $this->customerRelationData ? $this->customerRelationData->name : null;
    }

    /**
     * @return string
     */
    public function getCustomerRelationColorCodeAttribute() {
        return $this->customerRelationData ? $this->customerRelationData->color_code : null;
    }

    /**
     * @return string
     */
    public function getWardDataAttribute() {
        return $this->wardName ? $this->wardName->name : null;
    }

    /**
     * @return string
     */
    public function getDistrictDataAttribute() {
        return $this->districtName ? $this->districtName->name : null;
    }

    /**
     * @return string
     */
    public function getProvinceDataAttribute() {
        return $this->provinceCityName ? $this->provinceCityName->name : null;
    }

    /**
     * @return string
     */
    public function getUserManageInstanceAttribute() {
        return $this->userManage;
    }

    /**
     * @return string
     */
    public function getIntroducePersonInstanceAttribute() {
        if (empty($this->type_reference_data)) return null;

        $userTable = env('DB_PREFIX') . app(User::class)->getTable();

        if ($this->type_reference_data === ReferenceConfig::REFERENCE_USER_DATA)
            return User::where('id', $this->introduce_person_id)->select('id', 'first_name', 'last_name', DB::raw("CONCAT({$userTable}.first_name, ' ', {$userTable}.last_name) as full_name"),'username', 'profile_image as avatar')->first();
        else if ($this->type_reference_data === ReferenceConfig::REFERENCE_CUSTOMER_DATA)
            return Customer::where('id', $this->introduce_person_id)->select('id', 'full_name', 'avatar')->first();
    }

    /**
     * @return string
     */
    public function getCreatedByInstanceAttribute() {
        return $this->createdByUser;
    }

    public function getAddressFullAttribute() {
        $fullAddress = $this->address;
        if ($this->ward_data)
            $fullAddress .= ", {$this->ward_data}";
        if ($this->district_data)
            $fullAddress .= ", {$this->district_data}";
        if ($this->province_data)
            $fullAddress .= ", {$this->province_data}";

        return $fullAddress;
    }
}
