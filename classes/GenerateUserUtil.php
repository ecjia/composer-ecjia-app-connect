<?php


namespace Ecjia\App\Connect;


class GenerateUserUtil
{

    /**
     * 生成默认用户名
     * @return string
     */
    public static function defaultGenerateUserName()
    {
        /* 不是用户注册，则创建随机用户名*/
        return 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
    }

    /**
     * 生成默认邮箱
     * @return string
     */
    public static function defaultGenerateEmail()
    {
        /* 不是用户注册，则创建随机用户名*/
        $string = 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
        return $string . '@163.com';
    }

    /**
     * 生成默认密码
     * @return string
     */
    public static function defaultGeneratePassword()
    {
        return md5(rc_random(9, 'abcdefghijklmnopqrstuvwxyz0123456789'));
    }

    /**
     * 生成用户名
     * @param $user_name
     * @return string
     */
    public static function getGenerateUserNameByUserName($user_name)
    {
        return $user_name . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
    }

    /**
     * 生成邮箱
     * @param $email
     * @return string
     */
    public static function getGenerateEmailByEmail($email)
    {
        return 'a' . rc_random(2, 'abcdefghijklmnopqrstuvwxyz0123456789') . '_' . $email;
    }

}