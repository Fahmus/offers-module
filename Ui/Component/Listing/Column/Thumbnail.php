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
class Thumbnail  extends Column
{
    const URL_PATH_EDIT = 'offersbanner/index/edit';

    /**
     *
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManagerInterface;

    /**
     * @var UrlInterface
     */
    protected UrlInterface $url;

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
        StoreManagerInterface $storeManagerInterface,
        UrlInterface $url,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManagerInterface = $storeManagerInterface;
        $this->url = $url;
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource): array
    {
        foreach ($dataSource["data"]["items"] as &$item) {
            if (isset($item['image'])) {
                $baseUrl = $this->storeManagerInterface->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

                $imageUrl = $baseUrl . Constants::BANNERS_OFFER_IMAGE_PATH. DIRECTORY_SEPARATOR . $item['id'] . DIRECTORY_SEPARATOR . $item['image'];
                $item['image_src'] = $imageUrl;
                $item['image_alt'] = '';
                $item['image_link'] = $this->url->getUrl(
                    self::URL_PATH_EDIT,
                    ['id' => $item['id']]
                );
                $item['image_orig_src'] = $imageUrl;

            }
        }

        return $dataSource;
    }
}
