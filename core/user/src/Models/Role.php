<?php 
namespace Core\User\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Core\User\Traits\PermissionTrait;

class Role extends Model
{
    use PermissionTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_staff',
        'is_default',
        'created_by',
        'updated_by',
        'permissions',
        'parent_id',
        'is_default',
    ];

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        if ($this->exists) {
            $this->users()->detach();
        }

        return parent::delete();
    }

    /**
     * Get mutator for the "permissions" attribute.
     *
     * @param  mixed $permissions
     * @return array
     */
    public function getPermissionsAttribute($permissions)
    {
        return $permissions ? json_decode($permissions, true) : [];
    }

    /**
     * Set mutator for the "permissions" attribute.
     *
     * @param  mixed $permissions
     * @return void
     */
    public function setPermissionsAttribute(array $permissions)
    {
        $this->attributes['permissions'] = $permissions ? json_encode($permissions) : '';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Trinh Le
     */
    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author TrinhLe
     */
    public function parent()
    {
        return $this->belongsTo(Role::class, 'parent_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author TrinhLe
     */
    public function children()
    {
        return $this->hasMany(Role::class, 'parent_id');
    }
}
