<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Block\Category;

use Dnd\OffersBanner\Api\Data\OffersBannerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Dnd\OffersBanner\ViewModel\Offers as OffersBannerViewModel;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Offers
 * The offers banner block
 */
class Offers extends Template
{
    /**
     * @param OffersBannerViewModel $offersBannerViewModel
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        protected OffersBannerViewModel $offersBannerViewModel,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get offers list.
     *
     * @return OffersBannerInterface[]
     */
    public function getOffersBannerList(): array
    {
        return $this->offersBannerViewModel->getCurrentOffersByCategoryId($this->getCurrentCategoryId());
    }

    /**
     * Get offer image url.
     *
     * @param OffersBannerInterface $offer
     * @return string
     * @throws NoSuchEntityException
     */
    public function getImageUrl(OffersBannerInterface $offer): string
    {
        return $this->offersBannerViewModel->getImageUrl($offer);
    }

    /**
     * Get current category ID.
     *
     * @return int
     */
    public function getCurrentCategoryId(): int
    {
        return (int) $this->getData('category_id');
    }
}
