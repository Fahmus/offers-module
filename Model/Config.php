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
        return $this->scopeConfig->isSetFlag(Constants::CONFIG_PATH_ENABLED, $scopeType, $scopeCode);
    }
}
