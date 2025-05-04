<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Api\Data;

use DateTime;

/**
 * Interface OffersBannerInterface
 */
interface OffersBannerInterface
{
    const ID = 'id';
    const LABEL = 'label';
    const IMAGE = 'image';
    const LINK = 'link';
    const CATEGORIES = 'categories';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';

    /**
     * Get Label
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Set Label
     *
     * @param string $label
     * @return OffersBannerInterface
     */
    public function setLabel(string $label): OffersBannerInterface;

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage(): ?string;

    /**
     * Set Image
     *
     * @param string $image
     * @return OffersBannerInterface
     */
    public function setImage(string $image): OffersBannerInterface;

    /**
     * Get Redirect Link
     *
     * @return string
     */
    public function getLink(): string;

    /**
     * Set Redirect Link
     *
     * @param string $link
     * @return OffersBannerInterface
     */
    public function setLink(string $link): OffersBannerInterface;

    /**
     * Get Categories
     *
     * @return string
     */
    public function getCategories(): string;

    /**
     * Set Categories
     *
     * @param string $categories
     * @return OffersBannerInterface
     */
    public function setCategories(string $categories): OffersBannerInterface;

    /**
     * Get Start Date
     *
     * @return DateTime
     */
    public function getStartDate(): DateTime;

    /**
     * Set Start Date
     *
     * @param DateTime $startDate
     * @return OffersBannerInterface
     */
    public function setStartDate(DateTime $startDate): OffersBannerInterface;

    /**
     * Get End Date
     *
     * @return DateTime
     */
    public function getEndDate(): DateTime;

    /**
     * Set End Date
     *
     * @param DateTime $endDate
     * @return OffersBannerInterface
     */
    public function setEndDate(DateTime $endDate): OffersBannerInterface;
}
