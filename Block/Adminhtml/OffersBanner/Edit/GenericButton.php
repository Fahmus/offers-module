<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Block\Adminhtml\OffersBanner\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;

/**
 * Class GenericButton
 */
class GenericButton
{
    protected UrlInterface $urlBuilder;

    public function __construct(
        protected Context $context
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * Returns ID
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return (int) $this->context->getRequest()->getParam('id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array  $params
     *
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
