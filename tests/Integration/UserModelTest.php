<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Db;
use Phwoolcon\Model\User;
use Phwoolcon\Model\UserProfile;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\Tests\Helper\TestUserModel;
use Phwoolcon\Tests\Helper\TestUserProfileModel;

class UserModelTest extends TestCase
{

    /**
     * @return TestUserModel
     */
    protected function getUserModelInstance()
    {
        return $this->di->get(User::class);
    }

    /**
     * @return TestUserModel
     */
    protected function getTestUser()
    {
        $user = $this->getUserModelInstance();
        if ($tmp = $user::findFirstSimple(['username' => 'Test'])) {
            $user = $tmp;
        } else {
            $user->setData([
                'username' => 'Test',
                'password' => '123456',
                'confirmed' => '1',
            ]);
            $user->save();
        }
        return $user;
    }

    public function setUp()
    {
        parent::setUp();
        Db::clearMetadata();
        $this->di->set(User::class, TestUserModel::class);
        $this->di->set(UserProfile::class, TestUserProfileModel::class);
    }

    public function testCreateUser()
    {
        $user = $this->getUserModelInstance();
        $user->setData([
            'username' => 'Test',
            'password' => '123456',
            'confirmed' => '1',
        ]);
        $this->assertTrue($user->save());
    }

    public function testRememberToken()
    {
        $user = $this->getTestUser();
        $user->setRememberToken($token = '12345678');
        $this->assertTrue($user->save());
        $this->assertEquals($token, $user->getRememberToken());
        $user->removeRememberToken();
        $this->assertTrue($user->save());
        $this->assertEmpty($user->getRememberToken());
    }

    public function testProfileExtraData()
    {
        $user = $this->getTestUser();
        $profile = $user->getUserProfile();
        $this->assertEquals(TestUserProfileModel::class, get_class($profile));
        $profile->setExtraData($key = 'test_extra_data', $value = ['foo' => 'bar']);
        $this->assertTrue($profile->save());
        $this->assertEquals($value, $profile->getExtraData($key));
    }
}
