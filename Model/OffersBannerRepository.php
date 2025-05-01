<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Model;

use Dnd\OffersBanner\Api\Data\OffersBannerInterface;
use Dnd\OffersBanner\Api\Data\OffersBannerSearchResultsInterface;
use Dnd\OffersBanner\Api\Data\OffersBannerSearchResultsInterfaceFactory;
use Dnd\OffersBanner\Api\OffersBannerRepositoryInterface;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner as OffersBannerResourceModel;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner\Collection as OffersBannerCollection;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner\CollectionFactory as OffersBannerCollectionFactory;
use Dnd\OffersBanner\Model\OffersBanner as OffersBannerModel;
use Dnd\OffersBanner\Model\OffersBannerFactory as OffersBannerModelFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class OffersBannerRepository
 */
class OffersBannerRepository implements OffersBannerRepositoryInterface
{
    /**
     * OffersBannerRepository constructor.
     *
     * @param OffersBannerResourceModel $offersBannerResourceModel
     * @param OffersBannerModelFactory $offersBannerModelFactory
     * @param OffersBannerCollectionFactory $offersBannerCollectionFactory
     * @param OffersBannerSearchResultsInterfaceFactory $offersBannerSearchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        protected OffersBannerResourceModel $offersBannerResourceModel,
        protected OffersBannerModelFactory $offersBannerModelFactory,
        protected OffersBannerCollectionFactory $offersBannerCollectionFactory,
        protected OffersBannerSearchResultsInterfaceFactory $offersBannerSearchResultsFactory,
        protected CollectionProcessorInterface $collectionProcessor,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(OffersBannerInterface $offersBanner): OffersBannerInterface
    {
        try {
            $this->offersBannerResourceModel->save($offersBanner);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $offersBanner;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $offerId): OffersBannerInterface
    {
        /** @var OffersBannerModel $offer */
        $offer = $this->offersBannerModelFactory->create();
        $this->offersBannerResourceModel->load($offer, $offerId);

        if (!$offer->getId()) {
            throw new NoSuchEntityException(__('Offer banner not found.'));
        }

        return $offer;
    }

    /**
     * @inheritDoc
     */
    public function delete(OffersBannerInterface $offersBanner): bool
    {
        try {
            $this->offersBannerResourceModel->delete($offersBanner);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $offerId): bool
    {
        return $this->delete($this->getById($offerId));
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): OffersBannerSearchResultsInterface
    {
        /** @var OffersBannerCollection $collection */
        $collection = $this->offersBannerCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var OffersBannerSearchResultsInterface $searchResults */
        $searchResults = $this->offersBannerSearchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
