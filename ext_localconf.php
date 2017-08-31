<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Typovision.Simpleblog',
            'Bloglisting',
            [
                'Blog' => 'list,addForm,add,show,updateForm,update,deleteConfirm,delete',
                'Post' => 'addForm,add,show,updateForm,update,deleteConfirm,delete,ajax',
            ],
            // non-cacheable actions
            [
                'Blog' => 'list,addForm,add,show,updateForm,update,deleteConfirm,delete',
                'Post' => 'addForm,add,show,updateForm,update,deleteConfirm,delete,ajax',
            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        bloglisting {
                            icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_bloglisting.svg
                            title = LLL:EXT:simpleblog/Resources/Private/Language/locallang_db.xlf:tx_simpleblog_domain_model_bloglisting
                            description = LLL:EXT:simpleblog/Resources/Private/Language/locallang_db.xlf:tx_simpleblog_domain_model_bloglisting.description
                            tt_content_defValues {
                                CType = list
                                list_type = simpleblog_bloglisting
                            }
                        }
                    }
                    show = *
                }
           }'
        );

        /*
         * https://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/Hooks/Index.html
         * Search for a hook
         *      ['SC_OPTIONS']['t3lib/
         *      ['TYPO3_CONF_VARS']['EXTCONF']
         *
         * Hook in Code
         *          // Call post processing function for clear-cache:
                    if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'])) {
                        $_params = ['table' => $table, 'uid' => $uid, 'uid_page' => $pageUid, 'TSConfig' => $TSConfig];
                        foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'] as $_funcRef) {
                            GeneralUtility::callUserFunction($_funcRef, $_params, $this);
                        }
                    }
         *
         *
         * Hook 1 callUserFunction
         * Hook 2 getUserObj
         */

        //a hook
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']['simpleblog_clearcache'] = \Typovision\Simpleblog\Hooks\DataHandler::class . '->clearCachePostProc';


        /*
         * https://somethingphp.com/extending-classes-typo3/
         * Search for a signal emission
         *      signalSlotDispatcher->dispatch
         *
         * signal in code
         *      $this->signalSlotDispatcher->dispatch(__CLASS__, 'beforeGettingObjectData', [$query]);
         *
         */

        //a signal slot
        $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            'TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher'
        );
        $signalSlotDispatcher->connect(
            'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Backend',
            'afterUpdateObject',
            'Typovision\\Simpleblog\\Service\\SignalService',
            'handleUpdateEvent'
        );

        /*
         * Search for an xclass possibility
         *
         *
         *
         */

        //XCLASS
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Backend\\Controller\\NewRecordController'] = array(
            'className' => 'Typovision\\Simpleblog\\Xclass\\NewRecordControllerForSimpleblog'
        );
        
    },
    $_EXTKEY
);

