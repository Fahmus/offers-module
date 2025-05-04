<?php
declare(strict_types=1);

use Dnd\OffersBanner\Model\OffersBanner as OffersBannerModel;
use Dnd\OffersBanner\Model\ResourceModel\OffersBanner as OffersBannerResourceModel;
use Magento\TestFramework\Helper\Bootstrap;

$objectManager = Bootstrap::getObjectManager();

/**
 * @var OffersBannerResourceModel $offersBannerResourceModel
 */
$offersBannerResourceModel = $objectManager->create(OffersBannerResourceModel::class);

/** @var OffersBannerModel $offersBannerModel */
$offersBannerModel = $objectManager->create(OffersBannerModel::class);
$offersBannerModel->setLabel('Offer 1')
    ->setImage('image1.png')
    ->setLink('http://www.google.com')
    ->setCategories('5,6')
    ->setStartDate(new \DateTime())
    ->setEndDate(new \DateTime('+1 day'));
$offersBannerResourceModel->save($offersBannerModel);

/** @var OffersBannerModel $offersBannerModel */
$offersBannerModel = $objectManager->create(OffersBannerModel::class);
$offersBannerModel->setLabel('Offer 2')
    ->setImage('image2.png')
    ->setLink('http://www.google2.com')
    ->setCategories('5,10')
    ->setStartDate(new \DateTime())
    ->setEndDate(new \DateTime('+1 day'));
$offersBannerResourceModel->save($offersBannerModel);

/** @var OffersBannerModel $offersBannerModel */
$offersBannerModel = $objectManager->create(OffersBannerModel::class);
$offersBannerModel->setLabel('Offer 3')
    ->setImage('image3.png')
    ->setLink('http://www.google3.com')
    ->setCategories('5,10')
    ->setStartDate(new \DateTime())
    ->setEndDate(new \DateTime('+1 day'));
$offersBannerResourceModel->save($offersBannerModel);
