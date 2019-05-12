<?php
use Core\Master\Facades\DashboardMenuFacade;
use Core\Master\Facades\PageTitleFacade;
use Core\Master\Facades\AdminBreadcrumbFacade;
use Core\Master\Supports\Editor;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;

if (!function_exists('sort_item_with_children')) {
    /**
     * Sort parents before children
     * @param Collection|array $list
     * @param array $result
     * @param int $parent
     * @param int $depth
     * @return array
     */
    function sort_item_with_children($list, array &$result = [], $parent = null, $depth = 0)
    {
        if ($list instanceof Collection) {
            $listArr = [];
            foreach ($list as $item) {
                $listArr[] = $item;
            }
            $list = $listArr;
        }

        foreach ($list as $key => $object) {
            if ((int)$object->parent_id == (int)$parent) {
                array_push($result, $object);
                $object->depth = $depth;
                unset($list[$key]);
                sort_item_with_children($list, $result, $object->id, $depth + 1);
            }
        }

        return $result;
    }
}


if (!function_exists('parse_args')) {
    /**
     * @param $args
     * @param string $defaults
     * @return array
     */
    function parse_args($args, $defaults = '')
    {
        if (is_object($args)) {
            $result = get_object_vars($args);
        } else {
            $result =& $args;
        }

        if (is_array($defaults)) {
            return array_merge($defaults, $result);
        }
        return $result;
    }
}

if (!function_exists('page_title')) {
    /**
     * @return PageTitle
     */
    function page_title()
    {
        return PageTitleFacade::getFacadeRoot();
    }
}

if (!function_exists('dashboard_menu')) {
    /**
     * @return \Core\Base\Supports\DashboardMenu
     */
    function dashboard_menu()
    {
        return DashboardMenuFacade::getFacadeRoot();
    }
}

if (!function_exists('table_actions')) {
    /**
     * @param $edit
     * @param $delete
     * @param $item
     * @return string
     * @author TrinhLe
     */
    function table_actions($edit, $delete, $item)
    {
        return view('core-base::elements.tables.actions', compact('edit', 'delete', 'item'))->render();
    }
}

if (!function_exists('anchor_link')) {
    /**
     * @param $link
     * @param $name
     * @param array $options
     * @return string
     * @author TrinhLe
     */
    function anchor_link($link, $name, array $options = [])
    {
        $options = Html::attributes($options);
        return view('core-base::elements.tables.link', compact('link', 'name', 'options'))->render();
    }
}

if (!function_exists('table_checkbox')) {
    /**
     * @param $id
     * @return string
     * @author TrinhLe
     * @throws Throwable
     */
    function table_checkbox($id)
    {
        return view('core-base::elements.tables.checkbox', compact('id'))->render();
    }
}
if (!function_exists('html_attribute_element')) {
    /**
     * @param $key
     * @param $value
     * @return string
     * @author Trinh Le
     */
    function html_attribute_element($key, $value)
    {
        if (is_numeric($key)) {
            return $value;
        }

        // Treat boolean attributes as HTML properties
        if (is_bool($value) && $key != 'value') {
            return $value ? $key : '';
        }

        if (!empty($value)) {
            return $key . '="' . e($value) . '"';
        }
    }
}

if (!function_exists('html_attributes_builder')) {
    /**
     * @param array $attributes
     * @return string
     * @author Trinh Le
     */
    function html_attributes_builder(array $attributes)
    {
        $html = [];

        foreach ((array)$attributes as $key => $value) {
            $element = html_attribute_element($key, $value);

            if (!empty($element)) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }
}

if (!function_exists('render_editor')) {
    /**
     * @param $name
     * @param null $value
     * @param bool $with_short_code
     * @param array $attributes
     * @return string
     * @author Trinh Le
     * @throws Throwable
     */
    function render_editor($name, $value = null, $with_short_code = false, array $attributes = [])
    {
        $editor = new Editor;

        return $editor->render($name, $value, $with_short_code, $attributes);
    }
}

if (!function_exists('register_repositories')) {
    /**
     * helper register repositories of provider core/plugin
     * @author TrinhLe
     * @param  [type] $provider [description]
     * @return [type]           [description]
     */
    function register_repositories($provider)
    {
        $repositories = call_user_func_array([$provider, 'getRespositories'],[]);
        foreach ($repositories as $interface => $model) {
            # code...
            $detection      = explode('\\', $interface);
            $detectionClass = $provider::PREFIX_REPOSITORY_ELOQUENT . end($detection);
            $detectionCache = $provider::PREFIX_REPOSITORY_CACHE . end($detection);
            array_pop($detection);
            array_pop($detection);
            app(Application::class)->singleton($interface, function () use ($detection, $detectionClass, $detectionCache, $model) {
                $detectionClass = implode("\\", array_merge($detection, [$detectionClass]));
                $detectionCache = implode("\\", array_merge($detection, [$detectionCache]));
                $repository     = new $detectionClass(new $model());
                if (setting('enable_cache', false))
                    return new $detectionCache($repository);
                return $repository;
            });
        }
    }
}