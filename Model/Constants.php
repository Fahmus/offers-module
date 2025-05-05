<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Model;

/**
 * Class Constants
 * Offers banner constants
 */
class Constants
{
    /**
     * Path to the configuration setting that enables the offers banner.
     */
    public const CONFIG_PATH_ENABLED = 'catalog/offers_banner/enabled';
    public const OFFERS_BANNER_BO_EDIT_URL = 'offersbanner/index/edit';
    public const OFFERS_BANNER_FO_AJAX_URL = 'offersbanner/offers/ajax';
    public const BANNERS_OFFER_IMAGE_TMP_PATH = 'tmp/offersbanner';
    public const BANNERS_OFFER_IMAGE_PATH = 'offersbanner/images';
    public const ALLOWED_IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png'];
}
