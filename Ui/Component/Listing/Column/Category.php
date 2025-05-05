<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Ui\Component\Listing\Column;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Category
 *
 * Custom column for displaying category names.
 */
class Category extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CategoryRepositoryInterface $categoryRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
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
        $fieldName = $this->getData('name');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $categoryIds = explode(',', $item['categories']);
                $categories = [];
                if (count($categoryIds)) {
                    foreach ($categoryIds as $categoryId) {
                            $categoryData = $this->categoryRepository->get($categoryId);
                            $categories[] = $categoryData->getName();
                    }
                }
                $item[$fieldName] = implode(', ', $categories);
            }
        }

        return $dataSource;
    }
}
