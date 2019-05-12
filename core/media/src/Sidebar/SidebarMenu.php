<?php
namespace Core\Media\Sidebar;
use Core\Base\Sidebar\CoreSidebar;

class SidebarMenu extends CoreSidebar
{
	/**
	 * Get list menu
	 * @author TrinhLe
	 * @return array
	 */
	protected static function getMenus():array{
		return [
			[
				'id'          => 'cms-core-media',
				'priority'    => 3,
				'parent_id'   => null,
				'name'        => __('Manage Media'),
				'icon'        => 'la la-unlock',
				'url'         => route('media.index'),
				'permissions' => ['media.index']
            ],
		];
	}
}