<?php


namespace Ecjia\App\Connect\Installer;


use RC_DB;

class PluginUninstaller extends \Ecjia\Component\Plugin\Installer\PluginUninstaller
{

    public function uninstallByCode($code)
    {
        /* 从数据库中删除 */
        RC_DB::connection(config('cashier.database_connection', 'default'))->table('connect')->where('connect_code', $code)->delete();

    }

}