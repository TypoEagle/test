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
 * BlogController
 */
class BlogController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController{

    /**
     * @var \Typovision\Simpleblog\Domain\Repository\BlogRepository
     */
    protected $blogRepository;

    /**
     * @param \Typovision\Simpleblog\Domain\Repository\BlogRepository $blogRepository
     */
    public function injectBlogRepository(\Typovision\Simpleblog\Domain\Repository\BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }


    public function listAction(){
        #$this->view->assign('blogs', $this->blogRepository->findAll());

        //instead of public function listAction($search=''){
        if($this->request->hasArgument('search')){
            $search = $this->request->getArgument('search');
        }else{
            $search = '';
        }
        
        $limit = ($this->settings['blog']['max'])?:NULL;

        $this->view->assign('blogs', $this->blogRepository->findSearchForm($search,$limit));
        $this->view->assign('search',$search);
    }

    public function initializeObject()
    {
        /*$this->databaseHandle = $GLOBALS['TYPO3_DB'];
        $this->databaseHandle->explainOutput = 2;
        $this->databaseHandle->store_lastBuildQuery = TRUE;
        $this->databaseHandle->debugOutput = 2;*/
    }

    /**
     * FE Editing
     *
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     */
    public function addFormAction(\Typovision\Simpleblog\Domain\Model\Blog $blog = NULL){
        $this->view->assign('blog',$blog);
    }

    /**
     * FE Editing
     *
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     * @validate $blog \Typovision\Simpleblog\Validation\Validator\AutocompleteValidator(property=title)
     */
    public function addAction(\Typovision\Simpleblog\Domain\Model\Blog $blog){
        $this->blogRepository->add($blog);
        $this->redirect('list');
    }

    /**
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     */
    public function showAction(\Typovision\Simpleblog\Domain\Model\Blog $blog)
    {
        $this->view->assign('blog',$blog);
    }

    /**
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     */
    public function updateFormAction(\Typovision\Simpleblog\Domain\Model\Blog $blog)
    {
        $this->view->assign('blog',$blog);
    }
    /**
     * FE Editing
     *
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     */
    public function updateAction(\Typovision\Simpleblog\Domain\Model\Blog $blog)
    {
        $this->blogRepository->update($blog);
        $this->redirect('list');
    }


    /**
     * FE Editing
     *
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     */
    public function deleteConfirmAction(\Typovision\Simpleblog\Domain\Model\Blog $blog)
    {
        $this->view->assign('blog',$blog);
    }
    /**
     * FE Editing
     *
     * @param \Typovision\Simpleblog\Domain\Model\Blog $blog
     */
    public function deleteAction(\Typovision\Simpleblog\Domain\Model\Blog $blog)
    {
        $this->blogRepository->remove($blog);
        $this->redirect('list');
    }

}
