<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Test\Integration\Model;

use DateTime;
use Dnd\OffersBanner\Model\OffersBannerRepository;
use Dnd\OffersBanner\Model\OffersBanner as OffersBannerModel;
use Dnd\OffersBanner\Model\OffersBannerFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 */
class OffersBannerRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->offerBannerFactory = $objectManager->get(OffersBannerFactory::class);
        $this->offersBannerRepository = $objectManager->get(OffersBannerRepository::class);
        $this->critereaBuilder = $objectManager->get(SearchCriteriaBuilder::class);
    }

    /**
     * Integration test for \Dnd\OffersBanner\Model\OffersBannerRepository::save
     *
     * @return void
     * @throws CouldNotSaveException
     */
    public function testSave(): void
    {
        /** @var OffersBannerModel $offersBannerModel */
        $offersBannerModel  = $this->offerBannerFactory->create();
        $offersBannerModel->setLabel('Offer 1')
            ->setImage('image1.png')
            ->setLink('http://www.google.com')
            ->setCategories('5,6')
            ->setStartDate(new DateTime())
            ->setEndDate(new DateTime('+1 day'));

        $this->offersBannerRepository->save($offersBannerModel);
        $totalCount = $this->offersBannerRepository->getList($this->critereaBuilder->create())->getTotalCount();
        $this->assertEquals(1, $totalCount);
    }

    /**
     * Integration test for \Dnd\OffersBanner\Model\OffersBannerRepository::getById
     *
     * @return void
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function testGetById(): void
    {
        /** @var OffersBannerModel $offersBannerModel */
        $offersBannerModel  = $this->offerBannerFactory->create();
        $offersBannerModel->setLabel('Offer 2')
            ->setImage('image2.png')
            ->setLink('http://www.google2.com')
            ->setCategories('5,10')
            ->setStartDate(new DateTime())
            ->setEndDate(new DateTime('+1 day'));

        $this->offersBannerRepository->save($offersBannerModel);

        $offersBannerModelSaved = $this->offersBannerRepository->getById((int) $offersBannerModel->getId());

        $this->assertInstanceOf(OffersBannerModel::class, $offersBannerModelSaved);
        $this->assertEquals($offersBannerModel->getId(), $offersBannerModelSaved->getId());
        $this->assertEquals($offersBannerModel->getLabel(), $offersBannerModelSaved->getLabel());
        $this->assertEquals($offersBannerModel->getImage(), $offersBannerModelSaved->getImage());
        $this->assertEquals($offersBannerModel->getLink(), $offersBannerModelSaved->getLink());
        $this->assertEquals($offersBannerModel->getCategories(), $offersBannerModelSaved->getCategories());
        $this->assertEquals($offersBannerModel->getStartDate(), $offersBannerModelSaved->getStartDate());
        $this->assertEquals($offersBannerModel->getEndDate(), $offersBannerModelSaved->getEndDate());
    }

    /**
     * Integration test for \Dnd\OffersBanner\Model\OffersBannerRepository::delete
     *
     * @return void
     * @throws CouldNotSaveException
     * @throws CouldNotDeleteException
     */
    public function testDelete(): void
    {
        $offersBannerModel  = $this->offerBannerFactory->create();
        $offersBannerModel->setLabel('Offer 3')
            ->setImage('image3.png')
            ->setLink('http://www.google3.com')
            ->setCategories('5,15')
            ->setStartDate(new DateTime())
            ->setEndDate(new DateTime('+1 day'));

        $this->offersBannerRepository->save($offersBannerModel);

        $totalCount = $this->offersBannerRepository->getList($this->critereaBuilder->create())->getTotalCount();
        $this->assertEquals(1, $totalCount);

        $this->offersBannerRepository->delete($offersBannerModel);

        $totalCount = $this->offersBannerRepository->getList($this->critereaBuilder->create())->getTotalCount();
        $this->assertEquals(0, $totalCount);
    }

    /**
     * Integration test for \Dnd\OffersBanner\Model\OffersBannerRepository::deleteById
     *
     * @return void
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function testDeleteById(): void
    {
        $offersBannerModel  = $this->offerBannerFactory->create();
        $offersBannerModel->setLabel('Offer 5')
            ->setImage('image5.png')
            ->setLink('http://www.google5.com')
            ->setCategories('5,15')
            ->setStartDate(new DateTime())
            ->setEndDate(new DateTime('+1 day'));

        $this->offersBannerRepository->save($offersBannerModel);

        $offersBannerModelTwo  = $this->offerBannerFactory->create();
        $offersBannerModelTwo->setLabel('Offer 6')
            ->setImage('image6.png')
            ->setLink('http://www.google6.com')
            ->setCategories('5,57')
            ->setStartDate(new DateTime())
            ->setEndDate(new DateTime('+1 day'));

        $this->offersBannerRepository->save($offersBannerModelTwo);

        $totalCount = $this->offersBannerRepository->getList($this->critereaBuilder->create())->getTotalCount();
        $this->assertEquals(2, $totalCount);

        $this->offersBannerRepository->deleteById((int) $offersBannerModel->getId());

        $totalCount = $this->offersBannerRepository->getList($this->critereaBuilder->create())->getTotalCount();
        $this->assertEquals(1, $totalCount);
    }

    /**
     * Integration test for \Dnd\OffersBanner\Model\OffersBannerRepository::getList
     *
     * @return void
     *
     * @magentoDataFixture Dnd_OffersBanner::Test/Integration/_files/offers_banner_items.php
     */
    public function testGetList(): void
    {
        $totalCount = $this->offersBannerRepository->getList($this->critereaBuilder->create())->getTotalCount();
        $this->assertEquals(3, $totalCount);
    }
}
