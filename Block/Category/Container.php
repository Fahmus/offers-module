<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Block\Category;

use Dnd\OffersBanner\Model\Constants;
use Magento\Catalog\Model\Layer\Resolver as LayerResolver;
use Magento\Framework\View\Element\Template;

class Container extends Template
{
    /**
     * @param LayerResolver $layerResolver
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        private readonly LayerResolver $layerResolver,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get offers banner ajax url.
     *
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->getUrl(Constants::OFFERS_BANNER_FO_AJAX_URL);
    }

    /**
     * Get current category ID.
     *
     * @return int
     */
    public function getCategoryId(): int
    {
        $layer = $this->layerResolver->get();
        $currentCategory = $layer->getCurrentCategory();

        return (int) $currentCategory->getId();
    }
}
