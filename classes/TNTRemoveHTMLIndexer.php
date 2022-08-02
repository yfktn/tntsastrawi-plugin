<?php namespace Yfktn\TntSastrawi\Classes;

use Html;
use TeamTNT\TNTSearch\Indexer\TNTIndexer;
/**
 * I need to add HTML strip for spesific content.
 * 
 * @package Yfktn\TntSastrawi\Classes
 */
class TNTRemoveHTMLIndexer extends TNTIndexer
{
    protected $needRemoveHtmlTag = false;

    public function removeHtmlTag($value = false)
    {
        $this->needRemoveHtmlTag = $value;
    }
    
    public function breakIntoTokens($text)
    {
        if($this->needRemoveHtmlTag) {
            $text = Html::strip($text);
        }
        if ($this->decodeHTMLEntities) {
            $text = html_entity_decode($text);
        }
        return $this->tokenizer->tokenize($text, $this->stopWords);
    }
}