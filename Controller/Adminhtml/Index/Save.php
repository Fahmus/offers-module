<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Controller\Adminhtml\Index;

use Dnd\OffersBanner\Model\OffersBanner as OffersBannerModel;
use Dnd\OffersBanner\Model\OffersBannerFactory;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner as OffersBannerResourceModel;
use Dnd\OffersBanner\Service\Image\Upload as ImageUploader;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Class Save
 */
class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Dnd_OffersBanner::offers_banner_edit';

    /**
     * @param Context $context
     * @param OffersBannerFactory $offersBannerFactory
     * @param OffersBannerResourceModel $offersBannerResourceModel
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        private readonly OffersBannerFactory $offersBannerFactory,
        private readonly OffersBannerResourceModel $offersBannerResourceModel,
        private readonly ImageUploader $imageUploader,
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute(): Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        $id = $this->getRequest()->getParam('id');
        /** @var OffersBannerModel $offersBannerModel */
        $offersBannerModel = $this->offersBannerFactory->create();
        $oldCategories = [];
        $newCategories = $data['categories'];

        if ($id) {
            $this->offersBannerResourceModel->load($offersBannerModel, $id);
            $oldCategories = explode(',', $offersBannerModel->getCategories());
        }

        $imageData = $data['image'][0] ?? null;
        $newImage = $imageData['name'] ?? null;
        $data['image'] = $newImage;

        $oldImage = $offersBannerModel->getImage();
        $data['categories'] = implode(',', $data['categories']);
        $offersBannerModel->setData($data);

        try {
            $this->offersBannerResourceModel->save($offersBannerModel);
            $this->_eventManager->dispatch('offers_banner_save_after', ['categories' => array_unique(array_merge($oldCategories, $newCategories))]);
            $this->imageUploader->processImageCopy($offersBannerModel, $newImage, $oldImage);
            $this->messageManager->addSuccessMessage(__('Offer saved successfully.'));

            return $resultRedirect->setPath('*/*/');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
    }
}
