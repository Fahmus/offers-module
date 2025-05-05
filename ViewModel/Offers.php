<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\ViewModel;

use DateTime;
use Dnd\OffersBanner\Api\Data\OffersBannerInterface;
use Dnd\OffersBanner\Model\Constants;
use Dnd\OffersBanner\Model\OffersBanner;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner\Collection as OffersBannerCollection;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner\CollectionFactory as OffersBannerCollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Offers
 * The offers banner view model
 */
class Offers implements ArgumentInterface
{
    protected ReadInterface $mediaDirectory;

    /**
     * @param OffersBannerCollectionFactory $offersBannerCollectionFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private readonly OffersBannerCollectionFactory $offersBannerCollectionFactory,
        private readonly Filesystem $filesystem,
        private readonly StoreManagerInterface $storeManager,
    ) {
        $this->mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
    }

    /**
     * Get current offers by Category ID.
     *
     * @return OffersBannerInterface[]
     */
    public function getCurrentOffersByCategoryId(int $categoryId): array
    {
        $now = (new DateTime())->format('Y-m-d H:i:s');
        /** @var OffersBannerCollection $offersBannerCollection */
        $offersBannerCollection = $this->offersBannerCollectionFactory->create();
        $offersBannerCollection->getSelect()->where('FIND_IN_SET(?, main_table.categories)', $categoryId);

        return $offersBannerCollection
            ->addFieldToFilter('start_date', ['lteq' => $now])
            ->addFieldToFilter('end_date', ['gteq' => $now])
            ->getItems();
    }

    /**
     * Get offer image url.
     *
     * @param OffersBanner $offer
     * @return string
     * @throws NoSuchEntityException
     */
    public function getImageUrl(OffersBanner $offer): string
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $baseUrl . Constants::BANNERS_OFFER_IMAGE_PATH. DIRECTORY_SEPARATOR . $offer->getId() . DIRECTORY_SEPARATOR . $offer->getImage();
    }
}
