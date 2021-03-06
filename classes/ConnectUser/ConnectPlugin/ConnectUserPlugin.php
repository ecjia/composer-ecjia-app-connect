<?php

namespace Ecjia\App\Connect\ConnectUser\ConnectPlugin;

class ConnectUserPlugin
{

    /**
     * 用户类型定义
     * @var string
     */
    const USER     = 'user';
    const MERCHANT = 'merchant';
    const ADMIN    = 'admin';

    /**
     * @var string
     */
    protected $connect_code;

    /**
     * @var string
     */
    protected $connect_platform;

    /**
     * @var string
     */
    protected $open_id;

    /**
     * @var string
     */
    protected $union_id;

    /**
     * @var string
     */
    protected $user_type;

    /**
     * ConnectPluginAbstract constructor.
     * @param string $connect_code
     * @param string $connect_platform
     */
    public function __construct(string $connect_code, ?string $connect_platform = null)
    {
        $this->connect_code     = $connect_code;
        $this->connect_platform = $connect_platform;
    }

    /**
     * @return string
     */
    public function getConnectCode()
    {
        return $this->connect_code;
    }

    /**
     * @param string $connect_code
     * @return ConnectUserPlugin
     */
    public function setConnectCode(string $connect_code)
    {
        $this->connect_code = $connect_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getConnectPlatform()
    {
        return $this->connect_platform;
    }

    /**
     * @param string $connect_platform
     * @return ConnectUserPlugin
     */
    public function setConnectPlatform(?string $connect_platform)
    {
        $this->connect_platform = $connect_platform;
        return $this;
    }

    /**
     * @return string
     */
    public function getOpenId()
    {
        return $this->open_id;
    }

    /**
     * @param string $open_id
     * @return ConnectUserPlugin
     */
    public function setOpenId(?string $open_id)
    {
        $this->open_id = $open_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnionId()
    {
        return $this->union_id;
    }

    /**
     * @param string $union_id
     * @return ConnectUserPlugin
     */
    public function setUnionId(?string $union_id)
    {
        $this->union_id = $union_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param string $user_type
     * @return ConnectUserPlugin
     */
    public function setUserType(?string $user_type)
    {
        $this->user_type = $user_type;
        return $this;
    }

}