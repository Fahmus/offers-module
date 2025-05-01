<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action as BackendAction;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * Offers banner listing page
 */
class Index extends BackendAction implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Dnd_OffersBanner::offers_banner_list';

    public function __construct(
        Context $context,
        private readonly PageFactory $pageResultFactory
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute(): Page
    {
        /** @var Page $result */
        $result = $this->pageResultFactory->create();
        $result->setActiveMenu('Dnd_OffersBanner::offers_banner')
            ->getConfig()->getTitle()->prepend(__('Offers Banner'));

        return $result;
    }
}
