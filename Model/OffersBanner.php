<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Model;

use DateTime;
use Dnd\OffersBanner\Api\Data\OffersBannerInterface;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner as OffersBannerResourceModel;
use Magento\Framework\Model\AbstractModel;

/**
 * Class OffersBanner model.
 */
class OffersBanner extends AbstractModel implements OffersBannerInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(OffersBannerResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        return (string) $this->getData(OffersBannerInterface::LABEL);
    }

    /**
     * @inheritDoc
     */
    public function setLabel(string $label): OffersBannerInterface
    {
        $this->setData(OffersBannerInterface::LABEL, $label);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getImage(): ?string
    {
        return (string) $this->getData(OffersBannerInterface::IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setImage(string $image): OffersBannerInterface
    {
        $this->setData(OffersBannerInterface::IMAGE, $image);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLink(): string
    {
        return (string) $this->getData(OffersBannerInterface::LINK);
    }

    /**
     * @inheritDoc
     */
    public function setLink(string $link): OffersBannerInterface
    {
        $this->setData(OffersBannerInterface::LINK, $link);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCategories(): string
    {
        return (string) $this->getData(OffersBannerInterface::CATEGORIES);
    }

    /**
     * @inheritDoc
     */
    public function setCategories(string $categories): OffersBannerInterface
    {
        $this->setData(OffersBannerInterface::CATEGORIES, $categories);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStartDate(): DateTime
    {
        $dateStr = $this->getData(OffersBannerInterface::START_DATE);
        return new DateTime($dateStr);
    }

    /**
     * @inheritDoc
     */
    public function setStartDate(DateTime $startDate): OffersBannerInterface
    {
        $this->setData(OffersBannerInterface::START_DATE, $startDate->format('Y-m-d H:i:s'));
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEndDate(): DateTime
    {
        $dateStr = $this->getData(OffersBannerInterface::END_DATE);
        return new DateTime($dateStr);
    }

    /**
     * @inheritDoc
     */
    public function setEndDate(DateTime $endDate): OffersBannerInterface
    {
        $this->setData(OffersBannerInterface::END_DATE, $endDate->format('Y-m-d H:i:s'));
        return $this;
    }
}
