<?php

namespace Ecjia\App\Connect;

use ecjia_connect;
use ecjia_integrate;
use RC_Format;

trait UserGenerateTrait
{
    /**
     * 用户名
     * @var string
     */
    protected $user_name;

    /**
     * @return ConnectAbstract
     */
    public function getConnectPlugin()
    {
        $handler = ecjia_connect::channel($this->plugin->getConnectCode());
        $handler->setProfile($this->getPluginProfile());
        return $handler;
    }

    public function getPluginProfile()
    {
        return $this->connectPluginHandleProfile($this->getConnectProfile());
    }

    protected function connectPluginHandleProfile($profile)
    {
        return $profile;
    }

    /**
     * 获取会员整合操作对象
     * @return \Ecjia\App\Integrate\UserIntegrateAbstract
     */
    public function getIntegrateUser()
    {
        return ecjia_integrate::getInstance();
    }

    /**
     * 设置用户名
     * @param $user_name
     * @return $this
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
        return $this;
    }

    /**
     * 获取用户名
     * @return string
     */
    public function getUserName()
    {
        if (is_null($this->user_name)) {
            $username = $this->user_name;
        } else {
            $username = $this->getConnectPlugin()->get_username();
        }

        return $this->filterUserName($username);
    }

    /**
     * 获取用户头像
     * @return string
     */
    public function getUserHeaderImg()
    {
        return $this->getConnectPlugin()->get_headerimg();
    }

    /**
     * 过滤用户呢称中的非法字符
     * @param string $username
     * @return string
     */
    protected function filterUserName($username)
    {
        $username = RC_Format::filterEmoji($username);
        $username = safe_replace($username);
        return $username;
    }


    /**
     * 生成用户名
     * @return string
     */
    public function getGenerateUserName()
    {
        $username = $this->getUserName();

        if (ecjia_integrate::checkUser($username)) {
            return GenerateUserUtil::getGenerateUserNameByUserName($username);
        }

        return $username;
    }

    /**
     * 生成邮箱
     * @return string
     */
    public function getGenerateEmail()
    {
        $handler = $this->getConnectPlugin();
        $email = $handler->get_email();

        if (ecjia_integrate::checkEmail($email)) {
            return GenerateUserUtil::getGenerateEmailByEmail($email);
        }

        return $email;
    }

    /**
     * 生成密码
     * @return string
     */
    public function getGeneratePassword()
    {
        $handler = $this->getConnectPlugin();
        $password = $handler->get_password();

        return $password;
    }


}