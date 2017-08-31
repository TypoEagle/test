<?php
namespace Typovision\Simpleblog\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Arend Maubach <arend.maubach@outlook.com>
 */
class PostControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Typovision\Simpleblog\Controller\PostController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Typovision\Simpleblog\Controller\PostController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllPostsFromRepositoryAndAssignsThemToView()
    {

        $allPosts = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $postRepository = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $postRepository->expects(self::once())->method('findAll')->will(self::returnValue($allPosts));
        $this->inject($this->subject, 'postRepository', $postRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('posts', $allPosts);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
