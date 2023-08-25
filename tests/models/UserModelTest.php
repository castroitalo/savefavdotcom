<?php 

declare(strict_types=1);

namespace tests\models;

use Dotenv\Dotenv;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\models\UserModel;

#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
#[RequiresPhpExtension("mysqli")]
class UserModelTest extends TestCase
{
    /**
     * User model object for testing
     *
     * @var UserModel
     */
    private UserModel $userModel;

    /**
     * UserModelTest setUp
     *
     * @return void
     */
    protected function setUp(): void 
    {
        $dotenv = Dotenv::createImmutable(CONF_ENV_TEST);

        $dotenv->load();

        $this->userModel = new UserModel();
    }
}
