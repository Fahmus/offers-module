<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface OffersBannerSearchResults
 *
 * Provides a contract for the search results of offers banners.
 */
interface OffersBannerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get list of offers banners.
     *
     * @return OffersBannerInterface[]
     */
    public function getItems();

    /**
     * Set list of offers banners.
     *
     * @param OffersBannerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
