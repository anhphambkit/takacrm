<?php
namespace Core\Master\Supports;

use Eloquent;
use Exception;
use File;
use Request;

class Helper
{
    /**
     * {@inheritDoc}
     */
    const SOURCE_HELPERS = '/../helpers';
	
    /**
     * Load module's helpers
     * @param string|null $directory 
     * @author TrinhLe
     */
    public static function autoloadHelpers($directory = null)
    {
        if(!$directory)
        {
            $sources = loadPackages(self::SOURCE_HELPERS);

            foreach ($sources as $group => $dir) {

                $helpers = File::glob($dir . '/*.php');

                foreach ($helpers as $helper) {
                    File::requireOnce($helper);
                }
            }
        }
        else 
        {
            $helpers = File::glob($directory . '/*.php');
            foreach ($helpers as $helper) {
                File::requireOnce($helper);
            }
        }
    }
}