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
    }

    /**
     * FE Editing
     *
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     * @param \Typovision\Simpleblog\Domain\Model\Post $post
     */
    public function addAction(\Typovision\Simpleblog\Domain\Model\Blog $blog, \Typovision\Simpleblog\Domain\Model\Post $post){
        //$this->postRepository->add($post);

        $blog->addPost($post); //AM: You do not add a Post, but you attach a post to the existing object post
        $this->objectManager->get('Typovision\\Simpleblog\Domain\\Repository\\BlogRepository')->update($blog); //wir holen das Blog-Repository per Dependency Injection "hinein"

        $this->redirect('show','Blog',NULL,['blog'=>$blog]);
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
}
