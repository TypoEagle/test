<?php
namespace Typovision\Simpleblog\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Arend Maubach <arend.maubach@outlook.com>
 */
class TagTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Typovision\Simpleblog\Domain\Model\Tag
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Typovision\Simpleblog\Domain\Model\Tag();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTagvalueReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTagvalue()
        );

    }

    /**
     * @test
     */
    public function setTagvalueForStringSetsTagvalue()
    {
        $this->subject->setTagvalue('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'tagvalue',
            $this->subject
        );

    }
}
