<?php
/**
 * Tag repository implemented
 */
namespace Plugins\Blog\Repositories\Eloquent;
use Plugins\Blog\Repositories\Interfaces\TagRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentTagRepositories extends RepositoriesAbstract implements TagRepositories {
	
	/**
     * {@inheritdoc}
     */
    protected $screen = BLOG_TAG_MODULE_SCREEN_NAME;
    
}