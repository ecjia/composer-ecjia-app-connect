<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 10:32
 */

namespace Ecjia\App\Connect\ConnectUser;


use Ecjia\App\Connect\ConnectUser\ConnectPlugin\ConnectUserPlugin;

class ConnectAdminUser extends ConnectUser
{

    protected $user_type = ConnectUserPlugin::ADMIN;

}