<?php
namespace Typovision\Simpleblog\Xclass;
use \TYPO3\CMS\Backend\Controller\NewRecordController;

class NewRecordControllerForSimpleblog extends NewRecordController
{
    function regularNew() {
        parent::regularNew();
        $this->code .= "Hello World";
    }
}