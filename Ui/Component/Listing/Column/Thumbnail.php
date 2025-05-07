<?php

declare(strict_types=1);

namespace Dnd\OffersBanner\Ui\Component\Listing\Column;

use Dnd\OffersBanner\Model\Constants;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Thumbnail
 *
 * Custom column for displaying thumbnails.
 */
class Thumbnail extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManagerInterface
     * @param UrlInterface $url
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        protected StoreManagerInterface $storeManagerInterface,
        protected UrlInterface $url,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     *
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource): array
    {
        foreach ($dataSource["data"]["items"] as &$item) {
            if (isset($item['image'])) {
                $baseUrl = $this->storeManagerInterface->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

                $imageUrl = sprintf('%s/%s/%s', $baseUrl . Constants::BANNERS_OFFER_IMAGE_PATH, $item['id'], $item['image']);
                $item['image_src'] = $imageUrl;
                $item['image_alt'] = '';
                $item['image_link'] = $this->url->getUrl(
                    Constants::OFFERS_BANNER_BO_EDIT_URL,
                    ['id' => $item['id']]
                );
                $item['image_orig_src'] = $imageUrl;

            }
        }

        return $dataSource;
    }
}
