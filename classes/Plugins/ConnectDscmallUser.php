<?php


namespace Ecjia\App\Connect\Plugins;


use Ecjia\App\Connect\ConnectUser\ConnectUser;

class ConnectDscmallUser extends ConnectUser
{

    /**
     * ConnectDscmallUser constructor.
     * @param integer $open_id 大商创会员ID user_id
     */
    public function __construct($open_id)
    {
        parent::__construct('uc_dscmall', $open_id);
    }



}