<?php

    if (!function_exists('get_setting_email_template_content')) {
        /**
         * Get content of email template if module need to config email template
         * @param $module_type string type of module is system or plugins
         * @param $module_name string
         * @param $email_template_key string key is config in config.email.templates.$key
         * @return bool|mixed|null
         * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
         */
        function get_setting_email_template_content($moduleType, $moduleName, $emailTemplateKey)
        {
            if(!in_array($moduleType, [ 'core' , 'plugins'])) throw new \Exception("Invalid module type: {$moduleType}", 1);
            
            $templatePath = base_path("{$moduleType}/{$moduleName}/resources/email-templates/{$emailTemplateKey}.tpl");
            return File::exists($templatePath) ? get_file_data($templatePath, false) : '';
        }
    }

    if (!function_exists('get_setting_email_subject_key')) {
        /**
         * get email subject key for setting() function
         * @param $module_name string
         * @param $mail_template string
         * @return string
         */
        function get_setting_email_subject_key($module_type, $module_name, $email_template_key)
        {
            return $module_type . '_' . $module_name . '_' . $email_template_key . '_subject';
        }
    }

    if (!function_exists('get_setting_email_subject')) {
        /**
         * Get email template subject value
         * @param $module_type : plugins or core
         * @param $name : name of plugin or core component
         * @param $mail_key : define in config/email/templates
         * @return array|\Master\Supports\SettingStore|null|string
         */
        function get_setting_email_subject($module_type, $module_name, $email_template_key)
        {
            $setting_email_subject = setting(get_setting_email_subject_key($module_type, $module_name, $email_template_key),
                trans(config($module_type . '.' . $module_name . '.email.templates.' . $email_template_key . '.subject',
                    '')));
            return $setting_email_subject;
        }
    }

    if (!function_exists('get_setting_email_status_key')) {
        /**
         * Get email on or off status key for setting() function
         * @param $module_type
         * @param $module_name
         * @param $email_template_key
         * @return string
         */
        function get_setting_email_status_key($module_type, $module_name, $email_template_key)
        {
            return $module_type . '_' . $module_name . '_' . $email_template_key . '_' . 'status';
        }
    }

    if (!function_exists('get_setting_email_status')) {
        /**
         * @param $module_type
         * @param $module_name
         * @param $email_template_key
         * @return array|\Master\Supports\SettingStore|null|string
         */
        function get_setting_email_status($module_type, $module_name, $email_template_key)
        {
            return setting(get_setting_email_status_key($module_type, $module_name, $email_template_key), true);
        }
    }

    if (!function_exists('get_array_parent_object')) {
        /**
         * @param $collection
         * @param $parentId
         * @param &$result
         * @return array
         */
        function get_array_parent_object($collection, $parentId = 0, array &$result = [])
        {
            $item = $collection
                    ->first(function ($item, $key) use ($parentId){
                        return $item->id === (int)$parentId;
                    });
            if($item){
                array_push($result, $item->id);
                get_array_parent_object($collection, $item->parent_id, $result); 
            }
            return $result;
        }
    }