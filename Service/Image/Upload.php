<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Service\Image;

use Dnd\OffersBanner\Model\Constants;
use Dnd\OffersBanner\Model\OffersBanner as OffersBannerModel;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\Filesystem\Driver\File\Mime;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Upload
 * Service for image upload
 */
class Upload
{
    protected ReadInterface $mediaDirectory;

    /**
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Mime $mime
     */
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly StoreManagerInterface $storeManager,
        private readonly Mime $mime
    ) {
        $this->mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
    }

    /**
     * Process image: move from tmp to permanent location, delete old image.
     *
     * @param OffersBannerModel $newModel
     * @param string $newImage
     * @param string|null $oldImage
     * @return void
     * @throws FileSystemException
     */
    public function processImageCopy(OffersBannerModel $newModel, string $newImage, ?string $oldImage): void
    {
        $mediaDir = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $tmpPath = sprintf('%s/%s', Constants::BANNERS_OFFER_IMAGE_TMP_PATH, $newImage);
        $destPath = sprintf('%s/%s/%s', Constants::BANNERS_OFFER_IMAGE_PATH, $newModel->getId(), $newImage);

        if ($mediaDir->isExist($tmpPath)) {
            $oldImagePath = sprintf('%s/%s/%s', Constants::BANNERS_OFFER_IMAGE_PATH, $newModel->getId(), $oldImage);
            if ($oldImage && $mediaDir->isExist($oldImagePath)) {
                $mediaDir->delete($oldImagePath);
            }

            $mediaDir->copyFile($tmpPath, $destPath);
            $mediaDir->delete($tmpPath);
        }
    }

    /**
     * Retrieve image data.
     *
     * @param int $offerId
     * @param string $imageName
     * @return array
     * @throws NoSuchEntityException
     * @throws FileSystemException
     */
    public function retrieveImageData(int $offerId, string $imageName): array
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $imageData['fullPath'] = sprintf('%s/%s/%s',
            $this->mediaDirectory->getAbsolutePath(Constants::BANNERS_OFFER_IMAGE_PATH),
            $offerId,
            $imageName
        );
        $imageData['imageUrl'] = sprintf('%s/%s/%s',
            $baseUrl . Constants::BANNERS_OFFER_IMAGE_PATH,
            $offerId,
            $imageName
        );
        $imageData['stat'] = $this->mediaDirectory->stat($imageData['fullPath']);
        $imageData['type'] = $this->mime->getMimeType($imageData['fullPath']);

        return $imageData;
    }
}
