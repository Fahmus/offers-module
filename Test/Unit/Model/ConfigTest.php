<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Test\Unit\Model;

use Dnd\OffersBanner\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigTest
 * Unit tests for \Dnd\OffersBanner\Model\Config
 */
class ConfigTest extends TestCase
{
    private const CONFIG_PATH_ENABLED = 'catalog/offers_banner/enabled';
    private readonly Config $config;
    private readonly ScopeConfigInterface|MockObject $scopeConfigMock;

    /**
     * Set up test mock objects
     */
    protected function setUp(): void
    {
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);

        $this->config = new Config($this->scopeConfigMock);
    }

    /**
     * Test isEnabled() returns true when config flag is set.
     */
    public function testIsEnabledReturnsTrue(): void
    {
        $this->scopeConfigMock->method('isSetFlag')
            ->with(self::CONFIG_PATH_ENABLED, ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->config->isEnabled());
    }

    /**
     * Test isEnabled() returns false when config flag is not set.
     * @return void
     */
    public function testIsEnabledReturnsFalse(): void
    {
        $this->scopeConfigMock->method('isSetFlag')
            ->with(self::CONFIG_PATH_ENABLED, ScopeInterface::SCOPE_STORE, null)
            ->willReturn(false);

        $this->assertFalse($this->config->isEnabled());
    }

    /**
     * Test isEnabled() with custom scope type and code.
     *
     * @return void
     */
    public function testIsEnabledWithCustomScope(): void
    {
        $this->scopeConfigMock->method('isSetFlag')
            ->with(self::CONFIG_PATH_ENABLED, 'website', 'base')
            ->willReturn(true);

        $this->assertTrue($this->config->isEnabled('website', 'base'));
    }
}
