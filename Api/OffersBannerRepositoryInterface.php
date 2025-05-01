<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Api;

use Dnd\OffersBanner\Api\Data\OffersBannerInterface;
use Dnd\OffersBanner\Api\Data\OffersBannerSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface OffersBannerRepository
 */
interface OffersBannerRepositoryInterface
{
    /**
     * Save offer banner.
     *
     * @param OffersBannerInterface $offersBanner
     * @return OffersBannerInterface
     * @throws CouldNotSaveException
     */
    public function save(OffersBannerInterface $offersBanner): OffersBannerInterface;

    /**
     * Get offer banner by offer ID.
     *
     * @param int $offerId
     * @return OffersBannerInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $offerId): OffersBannerInterface;

    /**
     * Delete offer banner.
     *
     * @param OffersBannerInterface $offersBanner
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(OffersBannerInterface $offersBanner): bool;

    /**
     * Delete offer banner by offer ID.
     *
     * @param int $offerId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $offerId): bool;

    /**
     * Retrieve list of offers banners.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return OffersBannerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): OffersBannerSearchResultsInterface;
}
