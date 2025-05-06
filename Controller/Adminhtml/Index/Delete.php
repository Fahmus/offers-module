<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Controller\Adminhtml\Index;

use Dnd\OffersBanner\Api\Data\OffersBannerInterface;
use Dnd\OffersBanner\Api\OffersBannerRepositoryInterface;
use Exception;
use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Class Delete
 */
class Delete extends BackendAction implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Dnd_OffersBanner::offers_banner_delete';

    /**
     * @param Context $context
     * @param OffersBannerRepositoryInterface $offersBannerRepository
     */
    public function __construct(
        Context $context,
        private readonly OffersBannerRepositoryInterface $offersBannerRepository,
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute(): Redirect
    {
        $offerId = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($offerId) {
            try {
                $offer = $this->offersBannerRepository->getById($offerId);
                $categories = explode(',', $offer->getCategories());

                $this->offersBannerRepository->delete($offer);
                $this->_eventManager->dispatch('offers_banner_save_after', ['categories' => $categories]);
                $this->messageManager->addSuccessMessage(
                    __('Offer deleted successfully.')
                );
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['id' => $offerId]);
            }
        }
        $this->messageManager->addErrorMessage(__('Offer with ID: "%1" not found.', $offerId));

        return $resultRedirect->setPath('*/*/');
    }
}
