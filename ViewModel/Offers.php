<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\ViewModel;

use DateTime;
use Dnd\OffersBanner\Api\Data\OffersBannerInterface;
use Dnd\OffersBanner\Model\Constants;
use Dnd\OffersBanner\Model\OffersBanner;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner\Collection as OffersBannerCollection;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner\CollectionFactory as OffersBannerCollectionFactory;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Offers
 * The offers banner view model
 */
class Offers implements ArgumentInterface
{
    /**
     * @var ReadInterface $mediaDirectory
     */
    protected ReadInterface $mediaDirectory;

    /**
     * @param OffersBannerCollectionFactory $offersBannerCollectionFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param CacheInterface $cache
     * @param JsonSerializer $jsonSerializer
     */
    public function __construct(
        private readonly OffersBannerCollectionFactory $offersBannerCollectionFactory,
        private readonly Filesystem $filesystem,
        private readonly StoreManagerInterface $storeManager,
        private readonly CacheInterface $cache,
        private readonly JsonSerializer $jsonSerializer
    ) {
        $this->mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
    }

    /**
     * Get current offers by Category ID.
     *
     * @param int $categoryId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getCurrentOffersByCategoryId(int $categoryId): array
    {
        $now = new DateTime();
        $nowTs = $now->getTimestamp();

        $cacheKey = sprintf('%s_%s', Constants::OFFERS_BANNER_CACHE_KEY, $categoryId);
        if ($cacheData = $this->cache->load($cacheKey)) {
            return $this->jsonSerializer->unserialize($cacheData);
        }

        /** @var OffersBannerCollection $offersBannerCollection */
        $offersBannerCollection = $this->offersBannerCollectionFactory->create();
        $offersBannerCollection->getSelect()->where('FIND_IN_SET(?, main_table.categories)', $categoryId);

        /** @var OffersBannerInterface[] $items */
        $items = $offersBannerCollection
            ->addFieldToFilter('start_date', ['lteq' => $now->format('Y-m-d H:i:s')])
            ->addFieldToFilter('end_date', ['gteq' => $now->format('Y-m-d H:i:s')])
            ->getItems();

        $offers = [];
        $soonestTs = null;
        foreach ($items as $offer) {
            $offers[] = [
                'label' => $offer->getLabel(),
                'image' => $this->getImageUrl($offer),
                'link' => $offer->getLink(),
            ];

            $startDateTs = $offer->getStartDate()?->getTimestamp();
            $endDateTs = $offer->getEndDate()?->getTimestamp();
            $soonestTs = $this->getOfferSoonestTs($startDateTs, $endDateTs, $soonestTs, $nowTs);
        }

        $ttl = $soonestTs ? max($soonestTs - time(), 60) : Constants::OFFERS_BANNER_DEFAULT_CACHE_TTL;
        $this->cache->save($this->jsonSerializer->serialize($offers), $cacheKey, [], $ttl);

        return $offers;
    }

    /**
     * Get offer image url.
     *
     * @param OffersBanner $offer
     * @return string
     * @throws NoSuchEntityException
     */
    private function getImageUrl(OffersBanner $offer): string
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return sprintf('%s/%s/%s', $baseUrl . Constants::BANNERS_OFFER_IMAGE_PATH, $offer->getId(), $offer->getImage());
    }

    /**
     * Get the offer soonest timestamp.
     *
     * @param int $startDateTs
     * @param int $endDateTs
     * @param int|null $soonestTs
     * @param int $nowTs
     * @return int|null
     */
    private function getOfferSoonestTs(int $startDateTs, int $endDateTs, ?int $soonestTs, int $nowTs): ?int
    {
        if ($startDateTs && $startDateTs > $nowTs) {
            $soonestTs = $soonestTs ? min($soonestTs, $startDateTs) : $startDateTs;
        }
        if ($endDateTs && $endDateTs > $nowTs) {
            $soonestTs = $soonestTs ? min($soonestTs, $endDateTs) : $endDateTs;
        }

        return $soonestTs;
    }
}
