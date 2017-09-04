<?php
namespace Typovision\Simpleblog\Domain\Repository;


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
 * The repository for Author
 */
class AuthorRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $defaultOrderings = array('fullname' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);

    /**
     * @param $searchUID
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAuthorByUID($searchUID)
    {
        echo $searchUID;
        echo $searchUID;
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uid',$searchUID)
        );
        #$query->setOrderings(array('fullname' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));

        $query->setLimit(1);

        return $query->execute();
    }


}