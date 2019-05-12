<?php

namespace Core\Setting\Commands;

use Core\Setting\Commands\Scripts\ImportDataCityWardVietNam;

class Kernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ImportDataCityWardVietNam::class
    ];

    /**
     * Get list command active
     * @return array
     */
    public function getCommands()
    {
        return $this->commands;
    }
}
