<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 10:31
 */

namespace Ecjia\App\Connect\ConnectUser;


use Ecjia\App\Connect\ConnectUser\ConnectPlugin\ConnectUserPlugin;

class ConnectMerchatUser extends ConnectUser
{

    protected $user_type = ConnectUserPlugin::MERCHANT;

}