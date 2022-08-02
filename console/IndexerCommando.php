<?php namespace Yfktn\TntSastrawi\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use TeamTNT\TNTSearch\TNTSearch;
use Yfktn\TntSastrawi\Classes\TNTRemoveHTMLIndexer;

/**
 * IndexerCommando Command
 */
class IndexerCommando extends Command
{
    /**
     * @var string name is the console command name
     */
    protected $name = 'tntsastrawi:runindexer';

    /**
     * @var string description is the console command description
     */
    protected $description = 'Run indexer';

    /**
     * handle executes the console command
     */
    public function handle()
    {
        // $tnt = new TNTSearch;
        $indexer = new TNTRemoveHTMLIndexer();
        $indexer->loadConfig(config("yfktn.tntsastrawi::source"));
        $providers = config("yfktn.tntsastrawi::provider");
        foreach($providers as $provider) {
            $objProvider = new $provider;
            $this->info("Processing " . $objProvider->getIndexName());
            $stopWords = $objProvider->getStopWords();
            if(isset($stopWords[0])) {
                $indexer->setStopWords($stopWords);
            }
            $indexer->removeHtmlTag($objProvider->getRemoveHtmlTag());
            $indexer->createIndex($objProvider->getIndexName());
            $indexer->query($objProvider->getIndexQuery());
            $indexer->run();
        }
        $this->line("Finished!");
    }

    /**
     * getArguments get the console command arguments
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * getOptions get the console command options
     */
    protected function getOptions()
    {
        return [];
    }
}
