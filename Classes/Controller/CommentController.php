<?php
namespace Typovision\Simpleblog\Controller;

class CommentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \Typovision\Simpleblog\Domain\Repository\CommentRepository
     */
    protected $commentRepository;
    /**
     * @param \Typovision\Simpleblog\Domain\Repository\CommentRepository $commentRepository
     */
    public function injectCommentRepository(\Typovision\Simpleblog\Domain\Repository\CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    

    public function initializeAction()
    {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
        $querySettings->setIgnoreEnableFields(TRUE);
        $querySettings->setIncludeDeleted(TRUE);
        $this->commentRepository->setDefaultQuerySettings($querySettings);


    }

    public function indexAction()
    {
    }

    public function listAction()
    {
        $this->view->assign('commentsLive', $this->commentRepository->findByDeleted(0));
        $this->view->assign('commentsDeleted', $this->commentRepository->findByDeleted(1));
    }
    /**
     * @param \Typovision\Simpleblog\Domain\Model\Comment $comment
     */
    public function deleteAction(\Typovision\Simpleblog\Domain\Model\Comment $comment)
    {
        $this->commentRepository->remove($comment);
        $this->redirect('list');
    }
    public function testAction()
    {
        $propertyMapper = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Property\\PropertyMapper');
        $result = $propertyMapper->convert('42.5', 'float');

        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($result);

        $this->view->assign('result', $result);



        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->settings['loginpage']);
        $this->view->assign('jo', $this->settings['loginpage']);

        $this->view->assign('helloworld', 'Hello Backend Module.');
        #return 'Ausgabe der Action test';
    }
}