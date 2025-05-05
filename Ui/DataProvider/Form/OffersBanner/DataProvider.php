<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Ui\DataProvider\Form\OffersBanner;

use Dnd\OffersBanner\Model\ResourceModel\OffersBanner\CollectionFactory;
use Dnd\OffersBanner\Service\Image\Upload as ImageUploader;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class OffersBanner form data provider
 */
class DataProvider extends AbstractDataProvider
{
    protected array $loadedData;

    /**
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param ImageUploader $imageUploader
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        protected DataPersistorInterface $dataPersistor,
        private readonly ImageUploader $imageUploader,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = [];

        foreach ($items as $item) {
            $data = $item->getData();
            if (!empty($data['image'])) {
                $imageData = $this->imageUploader->retrieveImageData((int) $item->getId(), $data['image']);
                $data['image'] = [[
                    'name' => $data['image'],
                    'url' => $imageData['imageUrl'],
                    'size' => $imageData['stat']['size'],
                    'type' => $imageData['type'],
                ]];
            }
            if (!empty($data['categories'])) {
                $data['categories'] = explode(',', $data['categories']);
            }

            $this->loadedData[$item->getId()] = $data;
        }
        $data = $this->dataPersistor->get('offersbannerdata');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('offersbannerdata');
        }

        return $this->loadedData;
    }
}
