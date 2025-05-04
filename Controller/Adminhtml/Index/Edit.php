<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Controller\Adminhtml\Index;

use Dnd\OffersBanner\Api\OffersBannerRepositoryInterface;
use Dnd\OffersBanner\Model\OffersBannerFactory;
use Magento\Backend\App\Action as BackendAction;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 */
class Edit extends BackendAction implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Dnd_OffersBanner::offers_banner_edit';

    public function __construct(
        Context $context,
        private readonly PageFactory $resultPageFactory,
        private readonly Registry $coreRegistry,
        private readonly OffersBannerFactory  $offersBannerFactory,
        private readonly OffersBannerRepositoryInterface $offersBannerRepository,
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute(): Page|ResponseInterface
    {
        $offersBannerId = $this->getRequest()->getParam('id');
        if ($offersBannerId) {
            try {
                $offersBannerModel = $this->offersBannerRepository->getById((int) $offersBannerId);
            } catch (NoSuchEntityException) {
                $this->messageManager->addErrorMessage(__('Offers banner not found.'));
                return $this->_redirect('*/*/');
            }
        } else {
            $offersBannerModel = $this->offersBannerFactory->create();
        }

        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $offersBannerModel->setData($data);
        }

        $this->coreRegistry->register('offersbanner', $offersBannerModel);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dnd_OffersBanner::offers_banner');
        $resultPage->getConfig()->getTitle()->prepend($offersBannerId ? __('Edit Offer') : __('Create Offer'));

        return $resultPage;
    }
}
