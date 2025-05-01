<?php
declare(strict_types=1);

namespace Dnd\OffersBanner\Test\Unit\Model;

use DateTime;
use Dnd\OffersBanner\Api\Data\OffersBannerInterface;
use Dnd\OffersBanner\Model\OffersBanner;
use JsonException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * Class OffersBannerTest
 * Unit test for the OffersBanner model
 */
class OffersBannerTest extends TestCase
{
    private readonly OffersBanner $offersBanner;

    /**
     * Set up mocks and the object under test.
     *
     * @return void
     * @throws ReflectionException
     */
    protected function setUp(): void
    {
        $reflection = new ReflectionClass(OffersBanner::class);

        $this->offersBanner = $reflection->newInstanceWithoutConstructor();
    }

    /**
     * Test if the model can be instantiated.
     *
     * @return void
     */
    public function testModelCanBeInstantiated(): void
    {
        $this->assertInstanceOf(OffersBanner::class, $this->offersBanner);
        $this->assertInstanceOf(OffersBannerInterface::class, $this->offersBanner);
    }

    /**
     * Test OffersBanner setter and getter.
     *
     * @return void
     * @throws JsonException
     */
    public function testSetterAndGetter(): void
    {
        $this->offersBanner->setLabel('Offer Label');
        $this->assertEquals('Offer Label', $this->offersBanner->getLabel());

        $this->offersBanner->setImage('image1.png');
        $this->assertEquals('image1.png', $this->offersBanner->getImage());

        $this->offersBanner->setLink('https://test.com');
        $this->assertEquals('https://test.com', $this->offersBanner->getLink());

        $this->offersBanner->setCategories(json_encode([3,4], JSON_THROW_ON_ERROR));
        $this->assertEquals(json_encode([3,4]), $this->offersBanner->getCategories());

        $this->offersBanner->setStartDate(new DateTime('2025-05-01 00:00:00'));
        $this->assertEquals(new DateTime('2025-05-01 00:00:00'), $this->offersBanner->getStartDate());

        $this->offersBanner->setEndDate(new DateTime('2025-05-01 00:00:00'));
        $this->assertEquals(new DateTime('2025-05-01 00:00:00'), $this->offersBanner->getEndDate());
    }
}
