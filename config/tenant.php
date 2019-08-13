<?php

return [
    'general' => [
        'primary_domain' => env('PRIMARY_DOMAIN', 'takacrm.bi'),
        'portal_concat_domain' => env('PORTAL_CONCAT_DOMAIN', '.')
    ],
    'tenant_default_hostname' => env('TENANT_DEFAULT_HOSTNAME', 'localhost'),
    'active-plugins' => [
//        'blog',
        'custom-attributes',
        'customer',
//        'faq',
        'history',
//        'newsletter',
        'order',
        'product',
    ],
    'system' => [
        'user_table' => 'users',
        'tenant_table' => 'tenants',
    ],
    'db' => [
        'database_tenant_prefix' => env('DATABASE_TENANT_PREFIX', 'bi_'),
        /**
         * The default connection to use; this overrules the Laravel database.default
         * configuration setting. In Laravel this is normally configured to 'mysql'.
         * You can set a environment variable to override the default database
         * connection to - for instance - the tenant connection 'tenant'.
         */
        'default' => env('TENANT_DEFAULT_CONNECTION'),

        /**
         * Must same the name of database connection
         * Used to give names to the system and tenant database connections. By
         * default we configure 'system' and 'tenant'. The tenant connection
         * is set up automatically by this package.
         *
         * @see src/Database/Connection.php
         * @var system-connection-name The database connection name to use for the global/system database.
         * @var tenant-connection-name The database connection name to use for the tenant database.
         */
        'system-connection-name' => env('SYSTEM_CONNECTION_NAME', 'system'),
        'tenant-connection-name' => env('TENANT_CONNECTION_NAME', 'tenant'),

        /**
         * The tenant division mode specifies to what database websites will be
         * connecting. The default setup is to use a new database per tenant.
         * If using PostgreSQL, a new schema per tenant in the same database can
         * be setup, by optionally setting division mode to 'schema'.
         * In case you prefer to use the same database with a table prefix,
         * set the mode to 'prefix'.
         * To implement a custom division mode, set this to 'bypass'.
         *
         * @see src/Database/Connection.php
         */
        'tenant-division-mode' => env('TENANT_DATABASE_DIVISION_MODE', 'database'),

        /**
         * The database password generator takes care of creating a valid hashed
         * string used for tenants to connect to the specific database. Do
         * note that this will only work in 'division modes' that set up
         * a connection to a separate database.
         */
        'password-generator' => Plugins\Tenancy\Generators\Database\DefaultPasswordGenerator::class,

        /**
         * The default Seeder class used on newly created databases and while
         * running artisan commands that fire seeding.
         *
         * @info requires tenant-migrations-path in order to seed newly created websites.
         * @info seeds stored in `database/seeds/tenants` need to be configured in your composer.json classmap.
         *
         * @warn specify a valid fully qualified class name.
         */
        'tenant-seed-class' => false,
//      eg an admin seeder under `app/Seeders/AdminSeeder.php`:
//        'tenant-seed-class' => App\Seeders\AdminSeeder::class,

        /**
         * Automatically generate a tenant database based on the random id of the
         * website.
         *
         * @info set to false to disable.
         */
        'auto-create-tenant-database' => true,

        /**
         * Automatically generate the user needed to access the database.
         *
         * @info Useful in case you use root or another predefined user to access the
         *       tenant database.
         * @info Only creates in case tenant databases are set to be created.
         *
         * @info set to false to disable.
         */
        'auto-create-tenant-database-user' => false,

        /**
         * Automatically rename the tenant database when the random id of the
         * website changes. This should not be too common, but in case it happens
         * we automatically want to move databases accordingly.
         *
         * @info set to false to disable.
         */
        'auto-rename-tenant-database' => true,

        /**
         * Automatically deletes the tenant specific database and all data
         * contained within.
         *
         * @info set to true to enable.
         */
        'auto-delete-tenant-database' => env('TENANT_DATABASE_AUTO_DELETE', false),

        /**
         * Automatically delete the user needed to access the tenant database.
         *
         * @info Set to false to disable.
         * @info Only deletes in case tenant database is set to be deleted.
         */
        'auto-delete-tenant-database-user' => env('TENANT_DATABASE_AUTO_DELETE_USER', false),

        /**
         * Define a list of classes that you wish to force onto the tenant or system connection.
         * The connection will be forced when the Model has booted.
         *
         * @info Useful for overriding the connection of third party packages.
         */
        'force-tenant-connection-of-models' => [
//            App\User::class
        ],
        'force-system-connection-of-models' => [
//            App\User::class
        ],
    ],
];
