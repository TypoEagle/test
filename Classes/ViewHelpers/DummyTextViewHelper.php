<?php
namespace Typovision\Simpleblog\ViewHelpers;


class DummyTextViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @param int $length
     * @return string
     */
    public function render($length = 100){
        $dummytext = 'Lorem ipsum dolor sit amet.  ';
        $len = strlen($dummytext);
        $repeat = ceil($length / $len);
        $dummytext_neu = substr(str_repeat($dummytext, $repeat),0,$length);
        return $dummytext_neu;
    }
}