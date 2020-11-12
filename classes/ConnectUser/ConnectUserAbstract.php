<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/11
 * Time: 16:08
 */

namespace Ecjia\App\Connect\ConnectUser;

use Ecjia\App\Connect\ConnectUser\ConnectPlugin\ConnectUserPlugin;
use Ecjia\App\Connect\Models\ConnectUserModel;
use RC_Time;
use Royalcms\Component\Support\Collection;

/**
 * Class ConnectUserAbstract
 * @package Ecjia\App\Connect\ConnectUser
 *
 * @method string getConnectCode()
 * @method ConnectUserPlugin setConnectCode($connect_code)
 * @method string getConnectPlatform()
 * @method ConnectUserPlugin setConnectPlatform(?string $connect_platform)
 * @method string getOpenId()
 * @method ConnectUserPlugin setOpenId(?string $open_id)
 * @method string getUnionId()
 * @method ConnectUserPlugin setUnionId(?string $union_id)
 * @method string getUserType()
 * @method ConnectUserPlugin setUserType(?string $user_type)
 */
abstract class ConnectUserAbstract
{

    /**
     * @var ConnectUserPlugin
     */
    protected $plugin;

    /**
     * @var integer
     */
    protected $user_id;

    /**
     * @var ConnectUserRepository
     */
    protected $repository;


    /**
     * ConnectUserAbstract constructor.
     * @param ConnectUserPlugin $plugin
     * @param null $user_id
     */
    public function __construct(ConnectUserPlugin $plugin, $user_id = null)
    {
        $this->plugin = $plugin;
        $this->user_id = $user_id;
        $this->repository = new ConnectUserRepository();
    }

    /**
     * @return ConnectUserPlugin
     */
    public function getPlugin(): ConnectUserPlugin
    {
        return $this->plugin;
    }

    /**
     * @param ConnectUserPlugin $plugin
     * @return ConnectUserAbstract
     */
    public function setPlugin(ConnectUserPlugin $plugin): ConnectUserAbstract
    {
        $this->plugin = $plugin;
        return $this;
    }

    /**
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param integer $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return ConnectUserRepository
     */
    public function getRepository(): ConnectUserRepository
    {
        return $this->repository;
    }

    /**
     * @param ConnectUserRepository $repository
     * @return ConnectUserAbstract
     */
    public function setRepository(ConnectUserRepository $repository): ConnectUserAbstract
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * 创建绑定用户
     * createUser 和 bindUser 也是二选一操作方法
     * 可以通过判断open_id是否存在，决定使用哪一种绑定方法
     * 如果记录不存在，则需创建记录
     * 如果记录已经存在，则直接绑定用户
     *
     * @param $user_id
     * @return \Ecjia\App\Connect\Models\ConnectUserModel|bool
     */
    public function createUser($user_id)
    {
        return $this->repository->create([
            'connect_code'     => $this->plugin->getConnectCode(),
            'connect_platform' => $this->plugin->getConnectPlatform(),
            'open_id'          => $this->plugin->getOpenId(),
            'union_id'         => $this->plugin->getUnionId(),
            'user_type'        => $this->plugin->getUserType(),
            'user_id'          => $user_id,
            'create_at'        => RC_Time::gmtime(),
        ]);
    }

    /**
     * 获取用户数据模型
     * @return \Ecjia\App\Connect\Models\ConnectUserModel
     */
    public function getUserModel()
    {
        return $this->repository->getModel()
            ->where('open_id', $this->plugin->getOpenId())
            ->where('connect_code', $this->plugin->getConnectCode())
            ->where('user_type', $this->plugin->getUserType())
            ->first();
    }

    /**
     * 获取用户数据模型
     * @return \Ecjia\App\Connect\Models\ConnectUserModel
     */
    public function getUserModelByUserId()
    {
        return $this->repository->getModel()
            ->where('user_id', $this->getUserId())
            ->where('connect_code', $this->plugin->getConnectCode())
            ->where('user_type', $this->plugin->getUserType())
            ->first();
    }

    /**
     * 获取用户数据模型集合，通过union_id
     * @return Collection
     */
    public function getUserModelCollectionByUnionId()
    {
        if ($this->plugin->getUnionId()) {
            return $this->repository->getModel()
                ->where('union_id', $this->plugin->getUnionId())
                ->where('connect_platform', $this->plugin->getConnectPlatform())
                ->where('user_type', $this->plugin->getUserType())
                ->get();
        }

        return collect();
    }

    /**
     * 获取用户数据模型集合，通过open_id
     * @return Collection
     */
    public function getUserModelCollectionByOpenId()
    {
        return $this->repository->getModel()
            ->where('open_id', $this->plugin->getOpenId())
            ->where('connect_platform', $this->plugin->getConnectPlatform())
            ->where('user_type', $this->plugin->getUserType())
            ->get();
    }

    /**
     * 获取用户数据模型集合，通过user_id
     * @return Collection
     */
    public function getUserModelCollectionByUserId()
    {
        return $this->repository->getModel()
            ->where('user_id', $this->getUserId())
            ->where('user_type', $this->plugin->getUserType())
            ->get();
    }

    /**
     * 保存授权token和profile
     * @param $user_model \Ecjia\App\Connect\Models\ConnectUserModel
     * @param $access_token
     * @param $refresh_token
     * @param $user_profile
     * @param $expires_time
     * @return mixed
     */
    public function saveConnectProfile(ConnectUserModel $user_model, $access_token, $refresh_token, $user_profile, $expires_time)
    {
        $curr_time = RC_Time::gmtime();

        $user_model->create_at = $curr_time;
        $user_model->expires_in = $expires_time;
        $user_model->expires_at = $curr_time + $expires_time;

        if (empty($user_model->user_id)) {
            $user_model->user_id = $this->getUserId();
            $user_model->user_type = $this->plugin->getUserType();
        }

        if ($access_token) {
            $user_model->access_token = $access_token;
        }

        if ($refresh_token) {
            $user_model->refresh_token = $refresh_token;
        }

        if ($user_profile) {
            if (is_array($user_profile)) {
                $user_profile = serialize($user_profile);
            }

            $user_model->profile = $user_profile;
        }

        return $user_model->save();
    }

    /**
     * 绑定用户，需要通过手动创建用户，获取user_id传入
     *
     * bindUser 和 bindUserByUnionId 是二选一，取决于有没有user_id的情况下
     * 如果有user_id，走bindUser
     * 如果没有user_id，走bindUserByUnionId，需要提前设置connect_platform和union_id
     *
     * @param $user_id
     * @return \Royalcms\Component\Database\Eloquent\Model | bool
     */
    public function bindUser($user_id)
    {
        $this->setUserId($user_id);

        $model = $this->getUserModel();

        if ($model) {
            if (! empty($model->user_id)) {
                return $model;
            }

            //关联同一平台下union_id相同的用户，同时绑定
            $collection = $this->getUserModelCollectionByUnionId();
            if ($collection->isNotEmpty()) {
                $collection->each(function ($item) use ($user_id) {
                    if (empty($item->user_id)) {
                        $item->user_id = $user_id;
                        $item->save();
                    }
                });
            } else {
                //关联同一平台下open_id相同的用户，同时绑定
                $collection = $this->getUserModelCollectionByOpenId();
                if ($collection->isNotEmpty()) {
                    $collection->each(function ($item) use ($user_id) {
                        if (empty($item->user_id)) {
                            $item->user_id = $user_id;
                            $item->save();
                        }
                    });
                }
            }

            $model->user_id   = $this->getUserId();
            $model->user_type = $this->plugin->getUserType();
            return $model->save();
        } else {
            return false;
        }

    }

    /**
     * 绑定用户，通过union_id，使用setUnionId传入
     * @return \Royalcms\Component\Database\Eloquent\Model | bool
     */
    public function bindUserByUnionId()
    {
        $model = $this->getUserModel();

        $user_id = 0;

        $collection = $this->getUserModelCollectionByUnionId();

        if ($collection->isNotEmpty()) {

            $collection->each(function ($item) use (& $user_id) {
                if (! empty($item->user_id)) {
                    $user_id = $item->user_id;
                }
            });

        }

        if ($user_id) {
            if (empty($model)) {
                return $this->createUser($user_id);
            } else {
                return $this->bindUser($user_id);
            }
        }

        return false;
    }

    /**
     * 绑定用户，通过open_id
     * @return \Royalcms\Component\Database\Eloquent\Model | bool
     */
    public function bindUserByOpenId()
    {
        $model = $this->getUserModel();

        $user_id = 0;

        $collection = $this->getUserModelCollectionByOpenId();

        if ($collection->isNotEmpty()) {

            $collection->each(function ($item) use (& $user_id) {
                if (! empty($item->user_id)) {
                    $user_id = $item->user_id;
                }
            });

        }

        if ($user_id) {
            if (empty($model)) {
                return $this->createUser($user_id);
            } else {
                return $this->bindUser($user_id);
            }
        }

        return false;
    }

    /**
     * 获取用户的profile
     * @return mixed
     */
    public function getConnectProfile()
    {
        $profile = optional($this->getUserModel())->profile;

        $profile = unserialize($profile);

        return  $profile ?: array();
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->plugin->$method(...$parameters);
    }

}