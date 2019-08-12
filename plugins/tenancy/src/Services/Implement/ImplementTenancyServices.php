<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-08
 * Time: 16:01
 */

namespace Plugins\Tenancy\Services\Implement;

use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use Plugins\Tenancy\Models\Website;
use Plugins\Tenancy\Models\Hostname;
use Core\User\Models\User;
use Plugins\Tenancy\Repositories\Interfaces\WebsiteRepository;
use Plugins\Tenancy\Repositories\Interfaces\HostnameRepository;
use Plugins\Tenancy\Environment;
use Plugins\Tenancy\Services\TenancyServices;

class ImplementTenancyServices implements TenancyServices
{
    /**
     * ImplementTenancyServices constructor.
     * @param Website|null $website
     * @param Hostname|null $hostname
     * @param User|null $admin
     */
    public function __construct(Website $website = null, Hostname $hostname = null, User $admin = null)
    {
        $this->website = $website;
        $this->hostname = $hostname;
        $this->admin = $admin;
    }

    /**
     * @param array $data
     * @return TenancyServices
     */
    public function registerTenant(array $data): TenancyServices
    {
        // Convert all to lowercase
        $tenantName = str_slug(strtolower($data['tenancy_name']), '_');

        $website = new Website;
        app(WebsiteRepository::class)->createFromModelWithData($website, $tenantName);

        // associate the website with a hostname
        $hostname = new Hostname;
        $baseUrl = config('tenancy.hostname.default');
        $hostname->fqdn = "{$tenantName}.{$baseUrl}";
        app(HostnameRepository::class)->attach($hostname, $website);

        // make hostname current
        app(Environment::class)->tenant($hostname->website);

        // Make the registered user the default Admin of the site.
        $admin = static::makeAdmin($data['username'], $data['email'], $data['password'], $data['first_name'], $data['last_name']);

        return new ImplementTenancyServices($website, $hostname, $admin);
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @return User
     */
    private static function makeAdmin(string $username, string $email, string $password, string $firstName, string $lastName): User
    {
        $db_ext = DB::connection('tenant');
        $countries = $db_ext->table('users')->get();
        print_r($countries);

        $user = app(UserInterface::class)->getModel();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->username = $username;
        $user->password = bcrypt($password);
        $user->super_user = 1;
        $user->manage_supers = 1;
        $user->profile_image = config('base-user.acl.avatar.default');

        app(UserInterface::class)->createOrUpdate($user);

        return $user;
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function tenantExists($name)
    {
        $name = $name . '.' . config('tenancy.hostname.default');
        return Hostname::where('fqdn', $name)->exists();
    }
}