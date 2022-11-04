<?php namespace Yfktn\TntSastrawi;

use Backend;
use Sastrawi\Stemmer\StemmerFactory;
use System\Classes\PluginBase;

/**
 * TntSastrawi Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'TntSastrawi',
            'description' => 'Indonesian Sastrawi and TNT Search Plugin For OctoberCMS.',
            'author'      => 'Yfktn',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        // register di sini supaya tidak silalu diinisialisasi oleh stem
        \App::singleton('sastrawiStemmerFactory', function() {
            return (new StemmerFactory())->createStemmer();
        });
        $this->registerConsoleCommand('yfktn.tntsastrawi', \Yfktn\TntSastrawi\Console\IndexerCommando::class);
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Yfktn\TntSastrawi\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'yfktn.tntsastrawi.management' => [
                'tab' => 'TntSastrawi',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'tntsastrawi' => [
                'label'       => 'TntSastrawi',
                'url'         => Backend::url('yfktn/tntsastrawi/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['yfktn.tntsastrawi.*'],
                'order'       => 500,
            ],
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'getTulisanRelated' => function($punyaSlugIni, $keyword, $kontennya, $setelahTagPKe = 1, $cntRecommended = 1) {
                    $tnt = new \TeamTNT\TNTSearch\TNTSearch();
                    $tnt->loadConfig(config("yfktn.tntsastrawi::source"));
                    $tnt->selectIndex('Yfktn.Tulisan');
                    $keywords = $keyword ; //. ' ' . \Html::strip($kontennya);
                    $res = $tnt->search($keywords, $cntRecommended + 1);
                    $orderByRaw = 'FIELD(id, ' . implode(",", $res['ids']) . ')';
                    // trace_log($keyword, $res, $cntRecommended, $orderByRaw);
                    $hasil = \Yfktn\Tulisan\Models\Tulisan//::with(['gambar_header', 'kategori'])
                        ::yangSudahDitampilkan()
                        ->whereIn('id', $res['ids'])
                        ->orderByRaw($orderByRaw)
                        ->where('slug', '<>', $punyaSlugIni) // jangan double tampilkan!
                        ->listDiFrontEnd([
                            // 'page' => $this->variable['halamanAktif'],
                            'jumlahItemPerHalaman' => $cntRecommended,
                            'order' => [
                                'tgl_tampil' => 'DESC'
                            ]
                        ]);
                    $retValue = [];
                    $retValue[3] = $hasil->count();
                    if($hasil->count() > 0) {
                        $the1stParagraphEnd = stripos($kontennya, '</p>');
                        if($the1stParagraphEnd === false) {
                            // tambahkan di bagian akhir
                            $retValue[0] = $kontennya;
                            $retValue[2] = "";
                        } else {
                            $retValue[0] = substr($kontennya, 0, $the1stParagraphEnd + 4);
                            $retValue[2] = substr($kontennya, $the1stParagraphEnd + 4);
                        }
                        $retValue[1] = $hasil;
                    } else {
                        $retValue[0] = $kontennya;
                        $retValue[2] = "";
                        $retValue[1] = false;
                    }
                    return $retValue;
                }
            ]
        ];
    }
}
