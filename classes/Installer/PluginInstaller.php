<?php

namespace Ecjia\App\Connect\Installer;

use Ecjia\Component\Plugin\Storages\ConnectPluginStorage;
use ecjia_plugin;
use RC_DB;
use RC_Plugin;

class PluginInstaller extends \Ecjia\Component\Plugin\Installer\PluginInstaller
{

    /**
     * 安装插件
     */
    public function install()
    {
        $plugin_file = RC_Plugin::plugin_basename($this->plugin_file);

        (new ConnectPluginStorage())->addPlugin($plugin_file);

        $code = $this->getConfigByKey('connect_code');

        /* 检查输入 */
        if (empty($code)) {
            return ecjia_plugin::add_error('plugin_install_error', __('插件CODE不能为空', 'connect'));
        }

        $this->installByCode($code);

        return true;
    }

    /**
     * @param $code
     */
    protected function installByCode($code)
    {
        $format_name        = $this->getPluginDataByKey('Name');
        $format_description = $this->getPluginDataByKey('Description');

        /* 取得配置信息 */
        $connect_config = serialize($this->getConfigByKey('forms'));

        /* 安装，检查该支付方式是否曾经安装过 */
        $count = RC_DB::connection(config('cashier.database_connection', 'default'))->table('connect')->where('connect_code', $code)->count();

        if ($count > 0) {
            /* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
            $data = array(
                'connect_name'   => $format_name,
                'connect_desc'   => $format_description,
                'connect_config' => $connect_config,
                'enabled'        => 1
            );

            RC_DB::connection(config('cashier.database_connection', 'default'))->table('connect')->where('connect_code', $code)->update($data);
        } else {
            /* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */
            $data = array(
                'connect_code'   => $code,
                'connect_name'   => $format_name,
                'connect_desc'   => $format_description,
                'connect_config' => $connect_config,
                'enabled'        => 1,
            );
            RC_DB::connection(config('cashier.database_connection', 'default'))->table('connect')->insert($data);
        }
    }

    /**
     * 卸载插件
     */
    public function uninstall()
    {
        $code = $this->getConfigByKey('connect_code');

        /* 检查输入 */
        if (empty($code)) {
            return ecjia_plugin::add_error('plugin_uninstall_error', __('插件CODE不能为空', 'connect'));
        }

        (new PluginUninstaller($code, new ConnectPluginStorage()))->uninstall();

        return true;
    }


}