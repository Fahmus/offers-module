<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Controller\Adminhtml\Image;

use Dnd\OffersBanner\Model\Constants;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;

/**
 * Class Upload
 * Manage upload image field
 */
class Upload extends Action
{
    public const ADMIN_RESOURCE = 'Dnd_OffersBanner::offers_banner_edit';

    /**
     * @param Context $context
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        private readonly UploaderFactory $uploaderFactory,
        private readonly Filesystem $filesystem,
        private readonly JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        $result = $this->resultJsonFactory->create();
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
            $uploader->setAllowedExtensions(Constants::ALLOWED_IMAGE_EXTENSIONS);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);

            $mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $target = $mediaDirectory->getAbsolutePath(Constants::BANNERS_OFFER_IMAGE_TMP_PATH);

            $resultData = $uploader->save($target);

            if (!$resultData) {
                throw new Exception(__('File cannot be saved.')->render());
            }

            $resultData['url'] = $this->_url->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA])
                . Constants::BANNERS_OFFER_IMAGE_TMP_PATH . DIRECTORY_SEPARATOR . $resultData['file'];

            return $result->setData($resultData);
        } catch (Exception $e) {
            return $result->setData(['error' => $e->getMessage()]);
        }
    }
}
