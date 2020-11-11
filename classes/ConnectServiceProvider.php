<?php

namespace Ecjia\App\Connect;

use Ecjia\App\Connect\Services\ConnectAdminPurviewService;
use Ecjia\App\Connect\Services\ConnectConnectUserBindService;
use Ecjia\App\Connect\Services\ConnectConnectUserInfoService;
use Ecjia\App\Connect\Services\ConnectConnectUserRemoveService;
use Ecjia\App\Connect\Services\ConnectConnectUserService;
use Ecjia\App\Connect\Services\ConnectEcjiaSyncappuserAddService;
use Ecjia\App\Connect\Services\ConnectPluginInstallService;
use Ecjia\App\Connect\Services\ConnectPluginMenuService;
use Ecjia\App\Connect\Services\ConnectPluginUninstallService;
use Ecjia\App\Connect\Services\ConnectUpdateUserAvatarService;
use Ecjia\App\Connect\Services\ConnectUserRemoveCleardataService;
use RC_Service;
use Royalcms\Component\App\AppParentServiceProvider;

class ConnectServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-connect');
    }
    
    public function register()
    {
        $this->registerAppService();
    }


    protected function registerAppService()
    {
        RC_Service::addService('admin_purview', 'connect', ConnectAdminPurviewService::class);
        RC_Service::addService('connect_user', 'connect', ConnectConnectUserService::class);
        RC_Service::addService('connect_user_bind', 'connect', ConnectConnectUserBindService::class);
        RC_Service::addService('connect_user_info', 'connect', ConnectConnectUserInfoService::class);
        RC_Service::addService('connect_user_remove', 'connect', ConnectConnectUserRemoveService::class);
        RC_Service::addService('ecjia_syncappuser_add', 'connect', ConnectEcjiaSyncappuserAddService::class);
        RC_Service::addService('plugin_install', 'connect', ConnectPluginInstallService::class);
        RC_Service::addService('plugin_menu', 'connect', ConnectPluginMenuService::class);
        RC_Service::addService('plugin_uninstall', 'connect', ConnectPluginUninstallService::class);
        RC_Service::addService('update_user_avatar', 'connect', ConnectUpdateUserAvatarService::class);
        RC_Service::addService('user_remove_cleardata', 'connect', ConnectUserRemoveCleardataService::class);
    }
    
    
}