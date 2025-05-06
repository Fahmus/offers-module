<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Model;

/**
 * Class Constants
 * Offers banner constants
 */
class Constants
{

    public const OFFERS_BANNER_CONFIG_PATH_ENABLED = 'catalog/offers_banner/enabled';
    public const OFFERS_BANNER_CONFIG_PATH_TTL = 'catalog/offers_banner/ttl';
    public const OFFERS_BANNER_DEFAULT_CACHE_TTL = 600;
    public const OFFERS_BANNER_CACHE_KEY = 'offers_banner_list';
    public const OFFERS_BANNER_BO_EDIT_URL = 'offersbanner/index/edit';
    public const OFFERS_BANNER_FO_AJAX_URL = 'offersbanner/offers/ajax';
    public const BANNERS_OFFER_IMAGE_TMP_PATH = 'tmp/offersbanner';
    public const BANNERS_OFFER_IMAGE_PATH = 'offersbanner/images';
    public const ALLOWED_IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png'];
}
