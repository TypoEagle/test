<?php
namespace Typovision\Simpleblog\Service;
use \TYPO3\CMS\Core\SingletonInterface;

class SignalService implements SingletonInterface
{
    /**
     * @param \TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $object
     */
    public function handleUpdateEvent(\TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $object,$signalInformation)
    {
        if ($object instanceof \Typovision\Simpleblog\Domain\Model\Blog) {
            $content = 'Comment: '. $object->getTitle();
            #$content .= ' / ' . $object->getCommentdate()->format('Y-m-d H:i:s');
            $content .= " / " . $signalInformation . chr(10);
            $this->writeLogFile($content);
            $object->setTitle("Bullshit");


        }
    }
    /**
     * @param \TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $comment
     * @param \TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $post
     * @param $signalInformation string
     */
    public function handleCommentInsertion(
        \TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $comment,
        \TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $post,
        $signalInformation)
    {
        $content = 'Comment: '. $comment->getComment();
        $content .= ' (Post: ' . $post->getTitle() . ')';
        $content .= " / " . $signalInformation . chr(10);
        $this->writeLogFile($content);
    }
    /**
     * @param $content string
     */
    public function writeLogFile($content)
    {
        $logfile = "logfile.txt";
        $handle = fopen($logfile, "a+");
        fwrite ($handle, $content);
        fclose ($handle);
    }
}