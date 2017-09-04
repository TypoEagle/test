<?php
namespace Typovision\Simpleblog\Controller;

/***
 *
 * This file is part of the "Simple Blog Extension" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Arend Maubach <arend.maubach@outlook.com>, typovision GmbH
 *
 ***/

/**
 * PostController
 */
class PostController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \Typovision\Simpleblog\Domain\Repository\PostRepository
     */
    protected $postRepository;

    /**
     * @param \Typovision\Simpleblog\Domain\Repository\PostRepository $blogRepository
     */
    public function injectPostRepository(\Typovision\Simpleblog\Domain\Repository\PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }



    public function initializeAction()
    {
        $action = $this->request->getControllerActionName();
        // pruefen, ob eine andere Action ausser "show" oder "ajax" aufgerufen wurde
        if ($action != 'show' && $action != 'ajax') {
            // Redirect zur Login Seite falls nicht eingeloggt
            if (!$GLOBALS['TSFE']->fe_user->user['uid']) {
                $this->redirect(NULL, NULL, NULL, NULL, $this->settings['loginpage']);
            }
        }
    }

    public function listAction(){
        #$this->view->assign('posts', $this->postRepository->findAll());

        //instead of public function listAction($search=''){
        if($this->request->hasArgument('search')){
            $search = $this->request->getArgument('search');
        }else{
            $search = '';
        }

        $limit = ($this->settings['post']['max'])?:NULL;

        $this->view->assign('posts', $this->postRepository->findSearchForm($search,$limit));
        $this->view->assign('search',$search);
    }


    /**
     * FE Editing
     *
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     * @param \Typovision\Simpleblog\Domain\Model\Post $post
     */
    public function addFormAction(\Typovision\Simpleblog\Domain\Model\Blog $blog, \Typovision\Simpleblog\Domain\Model\Post $post = NULL){
        $this->view->assign('blog',$blog);
        $this->view->assign('post',$post);
        $this->view->assign('tags',$this->objectManager->get('Typovision\\Simpleblog\\Domain\\Repository\\TagRepository')->findAll());
        #$this->view->assign('authors',$this->objectManager->get('Typovision\\Simpleblog\\Domain\\Repository\\AuthorRepository')->findAll());
    }

    /**
     * FE Editing
     *
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     * @param \Typovision\Simpleblog\Domain\Model\Post $post
     */
    public function addAction(\Typovision\Simpleblog\Domain\Model\Blog $blog, \Typovision\Simpleblog\Domain\Model\Post $post){
        //$this->postRepository->add($post);
        $post->setAuthor($this->objectManager->get('Typovision\\Simpleblog\\Domain\\Repository\\AuthorRepository')->findOneByUid( $GLOBALS['TSFE']->fe_user->user['uid']));
        $blog->addPost($post);
        $this->objectManager->get('Typovision\\Simpleblog\\Domain\\Repository\\BlogRepository')->update($blog);
        $this->redirect('show','Blog',NULL,array('blog'=>$blog));
    }

    /**
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     * @param \Typovision\Simpleblog\Domain\Model\Post $post
     */
    public function showAction(\Typovision\Simpleblog\Domain\Model\Blog $blog, \Typovision\Simpleblog\Domain\Model\Post $post){
        $this->view->assign('blog',$blog);
        $this->view->assign('post',$post);
    }

    /**
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     * @param \Typovision\Simpleblog\Domain\Model\Post $post
     */
    public function updateFormAction(\Typovision\Simpleblog\Domain\Model\Blog $blog,\Typovision\Simpleblog\Domain\Model\Post $post){
        $this->view->assign('blog',$blog);
        $this->view->assign('post',$post);
        $this->view->assign('tags',   $this->objectManager->get('Typovision\\Simpleblog\\Domain\\Repository\\TagRepository')->findAll());
        #$this->view->assign('authors',$this->objectManager->get('Typovision\\Simpleblog\\Domain\\Repository\\AuthorRepository')->findAll());
    }

    /**
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     * @param \Typovision\Simpleblog\Domain\Model\Post $post
     */
    public function updateAction(\Typovision\Simpleblog\Domain\Model\Blog $blog,\Typovision\Simpleblog\Domain\Model\Post $post){
        $this->postRepository->update($post);
        $this->redirect('show','Blog',NULL,array('blog'=>$blog));
    }

    /**
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     * @param \Typovision\Simpleblog\Domain\Model\Post $post
     */
    public function deleteConfirmAction(\Typovision\Simpleblog\Domain\Model\Blog $blog,\Typovision\Simpleblog\Domain\Model\Post $post){
        $this->view->assign('blog',$blog);
        $this->view->assign('post',$post);
    }

    /**
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     * @param \Typovision\Simpleblog\Domain\Model\Post $post
     */
    public function deleteAction(\Typovision\Simpleblog\Domain\Model\Blog $blog,\Typovision\Simpleblog\Domain\Model\Post $post){
        $blog->removePost($post);
        $this->objectManager->get('Typovision\\Simpleblog\\Domain\\Repository\\BlogRepository')->update($blog);
        $this->postRepository->remove($post); // nur wegen der Sauberkeit. 
        $this->redirect('show','Blog',NULL,array('blog'=>$blog));
    }

    /**
     * @param \Typovision\Simpleblog\Domain\Model\Post $post
     * @param \Typovision\Simpleblog\Domain\Model\Comment $comment
     */
    public function ajaxAction(\Typovision\Simpleblog\Domain\Model\Post $post, \Typovision\Simpleblog\Domain\Model\Comment $comment = NULL)
    {
        // Wenn der Kommentar leer ist, wird nicht persistiert
        if ($comment->getComment()=="") return FALSE;

        // Datum des Kommentars setzen und den Kommentar zum Post hinzufügen
        $comment->setCommentdate(new \DateTime());
        $post->addComment($comment);

        // Signal for comment
        $this->signalSlotDispatcher->dispatch(
            __CLASS__,
            'beforeCommentCreation',
            array($comment,$post)
        );

        $this->postRepository->update($post);
        $this->objectManager->get( 'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager' )->persistAll();

        $comments = $post->getComments();
        foreach ($comments as $comment){
            $json[$comment->getUid()] = array(
                'comment'=>$comment->getComment(),
                'commentdate' => $comment->getCommentdate()
            );
        }

        return json_encode($json);
    }
}
