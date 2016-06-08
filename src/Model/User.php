<?php
namespace Phwoolcon\Model;

use Phalcon\Di;
use Phwoolcon\Model;

/**
 * Class User
 * @package Phwoolcon\Model
 *
 * @property Di $_dependencyInjector
 * @property Di $_dependencyInjector
 * @method UserProfile|false getUserProfile()
 * @method $this setUserProfile(UserProfile $profile)
 */
class User extends Model
{
    protected $_table = 'users';

    protected function assignUserProfile()
    {
        return $this->setUserProfile($this->_dependencyInjector->get(UserProfile::class));
    }

    public function getRememberToken()
    {
        return ($profile = $this->getUserProfile()) ? $profile->getData('remember_token') : null;
    }

    public function initialize()
    {
        $class = UserProfile::class;
        $this->_dependencyInjector->has($class) and $class = $this->_dependencyInjector->getRaw($class);
        $this->hasOne('id', $class, 'user_id', ['alias' => 'user_profile']);
        parent::initialize();
    }

    protected function prepareSave()
    {
        if (!$profile = $this->getUserProfile()) {
            $this->assignUserProfile();
        }
        parent::prepareSave();
    }

    public function removeRememberToken()
    {
        if ($this->getRememberToken()) {
            $profile = $this->getUserProfile();
            $profile->setData('remember_token', null);
            $profile->save();
        }
        return $this;
    }

    public function setRememberToken($rememberToken)
    {
        if ($profile = $this->getUserProfile()) {
            $profile->setData('remember_token', $rememberToken);
            $profile->save();
        }
        return $this;
    }
}
