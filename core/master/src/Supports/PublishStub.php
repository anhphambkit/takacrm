<?php
declare(strict_types=1);

namespace Core\Master\Supports;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;

trait PublishStub
{   
	/**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The name of the module uppercase first character.
     *
     * @var string
     */
    protected $plugin;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var string
     */
    protected $dataTranslate;

    /**
     * @var string
     */
    protected $filenameTranslate;

    /**
     * Generate the module in Modules directory.
     * @author TrinhLe
     */
    protected function publishStubs(string $from)
    {
        if ($this->files->isDirectory($from)) {
            $this->publishDirectory($from, $this->location);
        } else {
            $this->error('Can’t locate path: <' . $from . '>');
        }
    }

    /**
     * Search and replace all occurrences of ‘Module’
     * in all files with the name of the new module.
     * @author TrinhLe
     */
    public function searchAndReplaceInFiles()
    {

        $manager = new MountManager([
            'directory' => new Flysystem(new LocalAdapter($this->location)),
        ]);

        foreach ($manager->listContents('directory://', true) as $file) {
            if ($file['type'] === 'file') {
            	list($regexs, $values) = $this->parseDataTranslate($this->dataTranslate);
                $content = str_replace(
                	$regexs,
                	$values, 
                	$manager->read('directory://' . $file['path']));
                $manager->put('directory://' . $file['path'], $content);
            }
        }
    }

    /**
     * Parse Data translate file
     * @author TrinhLe
     * @return array
     */
    protected function parseDataTranslate(array $translates): array
    {
    	$regexs = $values = array();
    	foreach ($translates as $regex => $value) {
    		$regexs[] = $regex;
    		$values[] = $value;
    	}
    	return [$regexs, $values];
    }

    /**
     * Rename models and repositories.
     * @param $location
     * @return boolean
     * @author TrinhLe
     */
    public function renameFileName($location)
    {
        $paths = scan_folder($location);
        if (empty($paths)) {
            return false;
        }
        foreach ($paths as $path) {
            $path = $location . DIRECTORY_SEPARATOR . $path;

            $newPath = $this->transformFilename($path);
            rename($path, $newPath);

            $this->renameFileName($newPath);
        }
        return true;
    }

    /**
     * Rename file in path.
     *
     * @param string $path
     * @return string
     * @author TrinhLe
     */
    public function transformFilename($path)
    {
    	list($regexs, $values) = $this->parseDataTranslate($this->filenameTranslate);
        
        return str_replace(
            $regexs,
            $values,
            $path
        );
    }

    /**
     * Publish the directory to the given directory.
     *
     * @param string $from
     * @param string $to
     * @return void
     * @author TrinhLe
     */
    protected function publishDirectory($from, $to)
    {
        $manager = new MountManager([
            'from' => new Flysystem(new LocalAdapter($from)),
            'to' => new Flysystem(new LocalAdapter($to)),
        ]);

        foreach ($manager->listContents('from://', true) as $file) {
            if ($file['type'] === 'file' && (!$manager->has('to://' . $file['path']))) {
                $manager->put('to://' . $file['path'], $manager->read('from://' . $file['path']));
            }
        }
    }

    /**
     * Create the directory to house the published files if needed.
     *
     * @param string $directory
     * @return void
     * @author TrinhLe
     */
    protected function createParentDirectory($directory)
    {
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }
}