<?php

declare(strict_types=1);

namespace tests\core;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\core\Session;

/**
 * Class SessionTest
 * 
 * @package tests\core
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
final class SessionTest extends TestCase
{
    /**
     * Session object for testing
     *
     * @var Session
     */
    private Session $session;

    /**
     * Session key for testing
     *
     * @var string
     */
    private string $dummySessionKey = "to_delete";

    /**
     * SessionTest setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->session = new Session();
    }

    /**
     * SessionTest tearDown
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($_SESSION[$this->dummySessionKey]);
    }

    /**
     * Session::getSessionKeyValue test data provider
     *
     * @return array
     */
    public static function getSessionKeyValueTestDataProvider(): array
    {
        return [
            "existent_session_key" => [
                "logged", false
            ],
            "unexistent_session_key" => [
                "dontexists", null
            ]
        ];
    }

    /**
     * Test Session::getSessionKeyValue
     *
     * @param string $sessionKey
     * @param mixed $expected
     * @return void
     */
    #[DataProvider("getSessionKeyValueTestDataProvider")]
    public function testGetSessionKeyValue(
        string $sessionKey,
        mixed $expected
    ): void {
        $actual = $this->session->getSessionKeyValue($sessionKey);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test Session::createSessionDataArray for array value
     *
     * @return void
     */
    public function testCreateSessionDataArrayData(): void
    {
        $this->session->createSessionData(
            $this->dummySessionKey,
            ["keyone" => "value1", "keytwo" => "value2"]
        );

        $actual = $this->session->getSessionKeyValue($this->dummySessionKey);

        $this->assertIsObject($actual);
    }

    /**
     * Test Session::createSessionDataArray for non array value
     *
     * @return void
     */
    public function testCreateSessionDataNonArrayValue(): void 
    {
        $this->session->createSessionData(
            $this->dummySessionKey,
            "value"
        );

        $actual = $this->session->getSessionKeyValue($this->dummySessionKey);

        $this->assertIsString($actual);
    }

    /**
     * Test Session::getSession as object
     *
     * @return void
     */
    public function testGetSessionAsObject(): void
    {
        $actual = $this->session->getSession();

        $this->assertIsObject($actual);
    }

    /**
     * Session::hasSessionKey test data provider
     *
     * @return array
     */
    public static function hasSessionKeyTestDataProvider(): array
    {
        return [
            "existent_key" => [
                "logged", false
            ],
            "unexistent_key" => [
                "dontexists", false
            ]
        ];
    }

    /**
     * Test Session:hasSessionKey
     *
     * @param string $sessionKey
     * @param boolean $expected
     * @return void
     */
    #[DataProvider("hasSessionKeyTestDataProvider")]
    public function testHasSessionKey(
        string $sessionKey,
        bool $expected
    ): void {
        $actual = $this->session->hasSessionKey($sessionKey);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test Session::updateSessionKey for an array
     *
     * @return void
     */
    public function testUpdateSessionKeyArrayValue(): void 
    {
        $this->session->createSessionData($this->dummySessionKey, "value");
        $this->session->updateSessionKey($this->dummySessionKey, [
            "valuone" => "val1",
            "valuetwo" => "val2"
        ]);

        $actual = $this->session->getSessionKeyValue($this->dummySessionKey);

        $this->assertIsObject($actual);
    }

    /**
     * Test Session::updateSessionKey for non array value
     *
     * @return void
     */
    public function testUpdateSessionKeyNonArrayValue(): void 
    {
        $this->session->createSessionData($this->dummySessionKey, "value");
        $this->session->updateSessionKey($this->dummySessionKey, true);

        $actual = $this->session->getSessionKeyValue($this->dummySessionKey);

        $this->assertTrue($actual);
    } 

    /**
     * Test Session::deleteSessionKey
     *
     * @return void
     */
    public function testDeleteSessionKey(): void 
    {
        $this->session->createSessionData($this->dummySessionKey, "value");
        $this->session->deleteSessionKey($this->dummySessionKey);

        $actual = $this->session->getSessionKeyValue($this->dummySessionKey);

        $this->assertNull($actual);
    } 
}
