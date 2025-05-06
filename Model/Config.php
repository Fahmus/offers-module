<?php
declare(strict_types = 1);

namespace Dnd\OffersBanner\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 *
 * This class provides configuration settings for the Offers Banner module.
 */
class Config
{
    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Check if the offers banner is enabled.
     *
     * @param string $scopeType The scope type (default is store scope).
     * @param string|null $scopeCode The scope code (optional).
     * @return bool True if the offers banner is enabled, false otherwise.
     */
    public function isEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(Constants::OFFERS_BANNER_CONFIG_PATH_ENABLED, $scopeType, $scopeCode);
    }

    /**
     * Get the default TTL in seconds.
     *
     * @param string $scopeType The scope type (default is store scope).
     * @param string|null $scopeCode The scope code (optional).
     * @return int the default TTL in seconds.
     */
    public function getTtl(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): int
    {
        $value = $this->scopeConfig->getValue(Constants::OFFERS_BANNER_CONFIG_PATH_TTL, $scopeType, $scopeCode);
        return ($value !== null) ? (int) $value : Constants::OFFERS_BANNER_DEFAULT_CACHE_TTL;
    }
}
