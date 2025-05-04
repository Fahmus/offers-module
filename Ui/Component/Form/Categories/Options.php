<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Ui\Component\Form\Categories;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\Category as CategoryModel;
use Magento\Framework\Exception\LocalizedException;

/**
 * Options tree for "Categories" field
 */
class Options implements OptionSourceInterface
{
    protected ?array $categoriesTree = null;
    /**
     * Excluded category IDs
     */
    public const EXCLUDED_CATEGORIES = [CategoryModel::TREE_ROOT_ID, 2];

    /**
     * Categories options constructor.
     *
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param RequestInterface $request
     */
    public function __construct(
        protected CategoryCollectionFactory $categoryCollectionFactory,
        protected RequestInterface $request
    ) {
    }

    /**
     * @inheritDoc
     *
     * @throws LocalizedException
     */
    public function toOptionArray(): array
    {
        return $this->getCategoriesTree();
    }

    /**
     * Retrieve active categories tree
     *
     * @return array
     * @throws LocalizedException
     */
    protected function getCategoriesTree(): array
    {
        if ($this->categoriesTree === null) {
            $storeId = $this->request->getParam('store');
            $matchingNamesCollection = $this->categoryCollectionFactory->create();

            $matchingNamesCollection->addAttributeToSelect('path')
                ->addAttributeToFilter('entity_id', ['nin' => self::EXCLUDED_CATEGORIES])
                ->addIsActiveFilter() // Filter active categories
                ->setStoreId($storeId);

            $shownCategoriesIds = [];

            foreach ($matchingNamesCollection as $category) {
                foreach (explode('/', $category->getPath()) as $parentId) {
                    $shownCategoriesIds[$parentId] = 1;
                }
            }
            $collection = $this->categoryCollectionFactory->create();

            $collection->addAttributeToFilter('entity_id', ['in' => array_keys($shownCategoriesIds)])
                ->addAttributeToSelect(['name', 'is_active', 'parent_id'])
                ->addIsActiveFilter() // Filter active categories
                ->setStoreId($storeId);

            $categoryById = [
                CategoryModel::TREE_ROOT_ID => [
                    'value' => CategoryModel::TREE_ROOT_ID
                ],
            ];

            foreach ($collection as $category) {
                foreach ([$category->getId(), $category->getParentId()] as $categoryId) {
                    if (!isset($categoryById[$categoryId])) {
                        $categoryById[$categoryId] = ['value' => $categoryId];
                    }
                }

                $categoryById[$category->getId()]['is_active'] = $category->getIsActive();
                $categoryById[$category->getId()]['label'] = $category->getName();
                $categoryById[$category->getParentId()]['optgroup'][] = &$categoryById[$category->getId()];
            }

            $this->categoriesTree = $categoryById[CategoryModel::TREE_ROOT_ID]['optgroup'][0]['optgroup'];
        }

        return $this->categoriesTree;
    }
}
