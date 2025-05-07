<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Block\Adminhtml\OffersBanner\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;

/**
 * Class GenericButton
 *
 * This class provides generic button functionalities such as retrieving the request ID
 * and generating URLs based on routes and parameters in the admin panel.
 */
class GenericButton
{
    /**
     * @var UrlInterface $urlBuilder
     */
    protected UrlInterface $urlBuilder;

    /**
     * @param Context $context
     */
    public function __construct(
        protected Context $context
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * Returns the request ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return (int) $this->context->getRequest()->getParam('id');
    }

    /**
     * Generate url by route and parameters.
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
