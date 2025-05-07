<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Observer;

use Dnd\OffersBanner\Model\Constants;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\CacheInterface;

class InvalidateOffersBannerCache implements ObserverInterface
{
    /**
     * @param CacheInterface $cache
     */
    public function __construct(
        protected CacheInterface $cache
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer): void
    {
        $categories = $observer->getData('categories');
        foreach ($categories as $categoryId) {
            $this->cache->remove(sprintf('%s_%s', Constants::OFFERS_BANNER_CACHE_KEY, $categoryId));
        }
    }
}
