<?php 
namespace Core\User\Models;

use Carbon\Carbon;
use Exception;
use Elasticquent\ElasticquentTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Core\User\Traits\PermissionTrait;
use Illuminate\Notifications\Notifiable;
use Core\User\Events\ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable,
        PermissionTrait,
        ElasticquentTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $loginNames = ['email', 'username'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'address',
        'password',
        'secondary_address',
        'dob',
        'job_position',
        'phone',
        'secondary_phone',
        'secondary_email',
        'gender',
        'website',
        'skype',
        'facebook',
        'twitter',
        'google_plus',
        'youtube',
        'github',
        'interest',
        'about',
        'super_user',
        'profile_image',
    ];

    /**
     * @var array
     */
    public static $invite_rules = [
        'email'      => 'required|email|unique:users',
        'first_name' => 'required|min:2',
        'last_name'  => 'required|min:2',
    ];

    /**
     * Always capitalize the first name when we retrieve it
     * @param $value
     * @return string
     * @author TrinhLe
     */
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Always capitalize the last name when we retrieve it
     * @param $value
     * @return string
     * @author TrinhLe
     */
    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getFullName()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getProfileImage()
    {
        if (empty($this->profile_image)) {
            return config('core-user.acl.avatar.default');
        } else {
            return $this->profile_image;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function getRole()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    /**
     * @return boolean
     * @author TrinhLe
     */
    public function isSuperUser()
    {
        /**
         * @var PermissionsTrait $this
         */
        return $this->super_user || $this->hasAccess('superuser');
    }

    /**
     * @param $permissions
     * @return boolean
     * @author TrinhLe
     */
    public function hasPermission($permissions)
    {
        if ($this->isSuperUser()) {
            return true;
        }
        /**
         * @var PermissionsTrait $this
         */
        return $this->hasAccess($permissions);
    }

    /**
     * @param $permissions
     * @return bool
     * @author TrinhLe
     */
    public function hasAnyPermission($permissions)
    {
        if ($this->isSuperUser()) {
            return true;
        }
        /**
         * @var PermissionsTrait $this
         */
        return $this->hasAnyAccess($permissions);
    }

    /**
     * @return array
     */
    public function authorAttributes()
    {
        return [
            'name' => $this->getFullName(),
            'email' => $this->email,
            'url' => $this->website,    // optional
            'avatar' => 'gravatar', // optional
        ];
    }

    /**
     * @param $date
     * @author TrinhLe
     */
    public function setDobAttribute($date)
    {
        $this->attributes['dob'] = Carbon::createFromFormat(config('core-base.cms.date_format.date'), $date)->toDateTimeString();
    }

    /**
     * @param $date
     * @author TrinhLe
     * @return mixed
     */
    public function getDobAttribute($date)
    {
        return date_from_database($date, config('core-base.cms.date_format.date'));
    }

    /**
     * @param string $value
     * @return array
     */
    public function getPermissionsAttribute($value)
    {
        try {
            return json_decode($value, true) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Returns the activations relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activations()
    {
        return $this->hasMany(Activation::class, 'user_id');
    }

    /**
     * Set mutator for the "permissions" attribute.
     *
     * @param array $permissions
     * @return void
     */
    public function setPermissionsAttribute(array $permissions)
    {
        $this->attributes['permissions'] = $permissions ? json_encode($permissions) : '';
    }

}
