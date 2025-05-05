<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Controller\Offers;
use Dnd\OffersBanner\Block\Category\Offers as CategoryOffers;
use Dnd\OffersBanner\Model\Config;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Ajax
 * Class used to retrieve content of category offer block via ajax
 */
class Ajax implements ActionInterface
{
    /**
     * @param Config $config
     * @param RequestInterface $request
     * @param RawFactory $resultRawFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        protected Config $config,
        protected RequestInterface $request,
        protected RawFactory $resultRawFactory,
        protected PageFactory $resultPageFactory
    ) {
    }

    /**
     * @inheritdoc
     */
    public function execute(): Raw
    {
        $resultRaw = $this->resultRawFactory->create();
        if (!$this->config->isEnabled()) {
            $resultRaw->setContents('');
            return $resultRaw;
        }

        $categoryId = (int) $this->request->getParam('categoryId');
        $layout = $this->resultPageFactory->create()->getLayout();

        /** @var CategoryOffers $block */
        $block = $layout->createBlock(
            CategoryOffers::class,
            '',
            ['data' => ['category_id' => $categoryId]]
        );
        $block->setTemplate('Dnd_OffersBanner::category/ajax_offers.phtml');

        $resultRaw->setContents($block->toHtml());

        return $resultRaw;
    }
}
