<?php namespace Yfktn\TntSastrawi\Classes;

use App;
use TeamTNT\TNTSearch\Stemmer\Stemmer;

class IndonesianStemmer implements Stemmer
{
    public static function stem($word) 
    { 
        // $stemmerFactory = new StemmerFactory();
        // $stemmer = $stemmerFactory->createStemmer();
        return App::make('sastrawiStemmerFactory')->stem($word);
    }
}