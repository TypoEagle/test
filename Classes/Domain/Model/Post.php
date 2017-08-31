<?php
namespace Typovision\Simpleblog\Domain\Model;

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
 * Post
 */
class Post extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Title of a blogpost
     *
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';

    /**
     * Text of a blogpost
     *
     * @var string
     */
    protected $content = '';

    /**
     * Date of the blogpost
     *
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $postdate = null;

    /**
     * mp3 Ressource of a blogpost
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $mp3 = null;

    /**
     * Post comments relation: One post has many comments
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Typovision\Simpleblog\Domain\Model\Comment>
     * @cascade remove
     * @lazy
     */
    protected $comments = null;

    /**
     * Post author relation: one post has one author.
     *
     * @var \Typovision\Simpleblog\Domain\Model\Author
     */
    protected $author = null;

    /**
     * Post tags relation: Many posts has many tags
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Typovision\Simpleblog\Domain\Model\Tag>
     */
    protected $tags = null;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the mp3
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $mp3
     */
    public function getMp3()
    {
        return $this->mp3;
    }

    /**
     * Sets the mp3
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $mp3
     * @return void
     */
    public function setMp3(\TYPO3\CMS\Extbase\Domain\Model\FileReference $mp3)
    {
        $this->mp3 = $mp3;
    }

    /**
     * Returns the postdate
     *
     * @return \DateTime postdate
     */
    public function getPostdate()
    {
        return $this->postdate;
    }

    /**
     * Sets the postdate
     *
     * @param \DateTime $postdate
     * @return void
     */
    public function setPostdate(\DateTime $postdate)
    {
        $this->postdate = $postdate;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();

        $this->setPostdate(new \DateTime());
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->comments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->tags = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the content
     *
     * @return string content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the content
     *
     * @param string $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Adds a Comment
     *
     * @param \Typovision\Simpleblog\Domain\Model\Comment $comment
     * @return void
     */
    public function addComment(\Typovision\Simpleblog\Domain\Model\Comment $comment)
    {
        $this->comments->attach($comment);
    }

    /**
     * Removes a Comment
     *
     * @param \Typovision\Simpleblog\Domain\Model\Comment $commentToRemove The Comment to be removed
     * @return void
     */
    public function removeComment(\Typovision\Simpleblog\Domain\Model\Comment $commentToRemove)
    {
        $this->comments->detach($commentToRemove);
    }

    /**
     * Returns the comments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Typovision\Simpleblog\Domain\Model\Comment> comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Sets the comments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Typovision\Simpleblog\Domain\Model\Comment> $comments
     * @return void
     */
    public function setComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $comments)
    {
        $this->comments = $comments;
    }

    /**
     * Returns the author
     *
     * @return \Typovision\Simpleblog\Domain\Model\Author author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the author
     *
     * @param \Typovision\Simpleblog\Domain\Model\Author $author
     * @return void
     */
    public function setAuthor(\Typovision\Simpleblog\Domain\Model\Author $author)
    {
        $this->author = $author;
    }

    /**
     * Adds a Tag
     *
     * @param \Typovision\Simpleblog\Domain\Model\Tag $tag
     * @return void
     */
    public function addTag(\Typovision\Simpleblog\Domain\Model\Tag $tag)
    {
        $this->tags->attach($tag);
    }

    /**
     * Removes a Tag
     *
     * @param \Typovision\Simpleblog\Domain\Model\Tag $tagToRemove The Tag to be removed
     * @return void
     */
    public function removeTag(\Typovision\Simpleblog\Domain\Model\Tag $tagToRemove)
    {
        $this->tags->detach($tagToRemove);
    }

    /**
     * Returns the tags
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Typovision\Simpleblog\Domain\Model\Tag> tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Sets the tags
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Typovision\Simpleblog\Domain\Model\Tag> $tags
     * @return void
     */
    public function setTags(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags)
    {
        $this->tags = $tags;
    }
}
