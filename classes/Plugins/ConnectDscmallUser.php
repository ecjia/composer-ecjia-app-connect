<?php


namespace Ecjia\App\Connect\Plugins;


use Ecjia\App\Connect\ConnectAbstract;

class ConnectDscmallUser extends ConnectAbstract
{

    /**
     * 生成授权网址
     */
    public function authorize_url()
    {

    }

    /**
     * 生成回调地址
     *
     */
    public function callback_url()
    {

    }

    /**
     * 登录成功后回调处理
     * @param string $user_type 用户类型
     *          ConnectUser::USER,
     *          ConnectUser::MERCHANT,
     *          ConnectUser::ADMIN
     * @return \Ecjia\App\Connect\ConnectUser
     * @see \Ecjia\App\Connect\ConnectAbstract::callback()
     */
    public function callback($user_type = 'user')
    {

    }

}