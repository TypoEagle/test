<?php
namespace Typovision\Simpleblog\Hooks;

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

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typovision\Simpleblog\Service\DBugOutputService;
    
/**
 * Hook into tcemain which is used to show preview of news item
 *
 */
class DataHandler
{
    

    /**
     * Flushes the cache if a news record was edited.
     * This happens on two levels: by UID and by PID.
     *
     * @param array $params
     */
    public function clearCachePostProc(array $params){

        if (isset($params['table']) && $params['table'] === 'tx_simpleblog_domain_model_blog') {
            $cacheTagsToFlush = [];
            if (isset($params['uid'])) {
                $cacheTagsToFlush[] = 'tx_simpleblog_uid_' . $params['uid'];
            }
            if (isset($params['uid_page'])) {
                $cacheTagsToFlush[] = 'tx_simpleblog_pid_' . $params['uid_page'];
            }

            foreach ($cacheTagsToFlush as $cacheTag) {
                $this->getCacheManager()->flushCachesInGroupByTag('pages', $cacheTag);
            }
        }

    }

    /**
     * Create and returns an instance of the CacheManager
     *
     * @return CacheManager
     */
    protected function getCacheManager()
    {
        return GeneralUtility::makeInstance(CacheManager::class);
    }


}