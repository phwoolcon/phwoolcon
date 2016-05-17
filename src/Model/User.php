<?php
namespace Phwoolcon\Model;

use Phwoolcon\Model;

/**
 * Class User
 * @package Phwoolcon\Model
 *
 * @method UserProfile|false getUserProfile()
 * @method $this setUserProfile(UserProfile $profile)
 */
class User extends Model
{
    protected $_table = 'users';

    protected function assignUserProfile()
    {
        return $this->setUserProfile(new UserProfile);
    }

    public function getRememberToken()
    {
        return ($profile = $this->getUserProfile()) ? $profile->getData('remember_token') : null;
    }

    public function initialize()
    {
        $this->hasOne('id', UserProfile::class, 'user_id', ['alias' => 'user_profile']);
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
