<?php


namespace Ecjia\App\Connect\Subscribers;


use ecjia_admin;
use RC_Hook;
use RC_Uri;
use Royalcms\Component\Hook\Dispatcher;
use Ecjia\App\Client\ApplicationFactory\ApplicationFactory;
use Ecjia\App\Client\ApplicationConfigFactory\ApplicationConfigOptions;

class AdminHookSubscriber
{
    public static function connect_admin_menu_api($menus)
    {
        $menu = ecjia_admin::make_admin_menu('menu_user_connect', __('账号连接', 'connect'), RC_Uri::url('connect/admin_plugin/init'), 52)->add_purview('connect_users_manage');
        $menus->add_submenu($menu);
        return $menus;
    }

    public static function add_maintain_command($factories)
    {
        $factories['update_connect_platform'] = 'Ecjia\App\Connect\Maintains\UpdateConnectPlatform';
        return $factories;
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param \Royalcms\Component\Hook\Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {

        RC_Hook::add_filter('user_admin_menu_api', array(__CLASS__, 'connect_admin_menu_api') );
        RC_Hook::add_action('ecjia_maintain_command_filter', array(__CLASS__, 'add_maintain_command'));

    }

}