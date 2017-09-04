<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Typovision.' . $extKey,
            'Bloglisting',
            'Simpleblog - Bloglisting'
        );

        if (TYPO3_MODE === 'BE') {
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'Typovision.simpleblog',
                'web',
                'SimpleblogAdmin',
                '',
                [
                    'Comment' => 'index,list,delete,test',
                    #'Blog' => 'list',
                ],
                [
                    'access'    => 'admin',
                    'icon'      => 'EXT:simpleblog/Resources/Public/Icons/module_administration.svg',
                    'labels'    => 'LLL:EXT:simpleblog/Resources/Private/Language/locallang_mod.xlf'
                ]
            );
        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'Simple Blog Extension');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_simpleblog_domain_model_blog', 'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_blog.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_simpleblog_domain_model_blog');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_simpleblog_domain_model_post', 'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_post.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_simpleblog_domain_model_post');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_simpleblog_domain_model_comment', 'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_comment.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_simpleblog_domain_model_comment');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_simpleblog_domain_model_author', 'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_author.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_simpleblog_domain_model_author');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_simpleblog_domain_model_tag', 'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_tag.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_simpleblog_domain_model_tag');
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_system_SimpleblogSimpleblogadmin', 'EXT:simpleblog/Resources/Private/Language/locallang_csh.xlf');
    },
    $_EXTKEY
);
