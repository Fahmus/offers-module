<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Model\ResourceModel;

use Dnd\OffersBanner\Api\Data\OffersBannerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class OffersBanner resource model.
 */
class OffersBanner extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected string $_idFieldName = OffersBannerInterface::ID;

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('offers_banner', $this->_idFieldName);
    }
}
