<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Model\ResourceModel\OffersBanner;

use Dnd\OffersBanner\Model\OffersBanner as OffersBannerModel;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner as OffersBannerResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection for OffersBanner
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(OffersBannerModel::class, OffersBannerResourceModel::class);
    }
}
