<?php
/**
 * This is the Dokuwiki export for FINDOLOGIC.
 *
 * If any bugs occur, please submit a new issue
 * @see https://github.com/findologic/dokuwiki-plugin-findologic-xml-export/issues/new
 * @author Dominik Brader <support@findologic.com>
 */

if (!defined('DOKU_INC')) {
    die('Must be run within DokuWiki!');
}

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/PageGetter.php');
require_once(__DIR__ . '/DokuwikiPage.php');

class admin_plugin_findologicxmlexport extends DokuWiki_Admin_Plugin
{

    // Names
    const EDIT_IMAGE_URL_NAME = 'editImageUrl';
    const PAGES_NAME = 'pages';
    const EXPORT_URL_NAME = 'exportUrl';
    const STYLESHEET_URL_NAME = 'stylesheetUrl';
    const SCRIPT_URL_NAME = 'scriptUrl';
    const MAX_PAGES_NAME = 'maxPages';
    const TOTAL_PAGES_NAME = 'totalPages';
    const LANGUAGE_NAME = 'languageText';
    const PAGES_SKIPPED_NAME = 'pagesSkipped';
    const INFORMATION_IMAGE_URL_NAME = 'informationImageUrl';
    const DOKUWIKI_LANG_NAME = 'lang';

    // Values
    const EDIT_IMAGE_URL = DOKU_URL . 'lib/plugins/findologicxmlexport/resources/edit.svg';
    const EXPORT_URL = DOKU_URL . 'lib/plugins/findologicxmlexport';
    const STYLESHEET_URL = DOKU_URL . 'lib/plugins/findologicxmlexport/resources/style.css';
    const SCRIPT_URL = DOKU_URL . 'lib/plugins/findologicxmlexport/resources/script.js';
    const INFORMATION_IMAGE_URL = DOKU_URL . 'lib/styles/../images/info.png';
    /**
     * Maximum amount of pages being displayed in the configuration.
     */
    const MAX_PAGES = 5;

    /**
     * * **true** => You do not to be superuser to access this plugin.
     * * **false** => You do need to be superuser to access this plugin.
     */
    const ADMINS_ONLY = true;

    /**
     * Sort plugin in the DokuWiki admin interface.
     * The lower this value is, the higher it is sorted.
     */
    const MENU_SORT = 1;

    const TEMPLATE_DIR = __DIR__ . '/tpl';

    /**
     * Template file name. Directory is set in constant TEMPLATE_DIR.
     */
    const TEMPLATE_FILE = 'admin.twig';

    /**
     * @return int sorting of the plugin in the plugin manager.
     */
    public function getMenuSort()
    {
        return self::MENU_SORT;
    }

    /**
     * * **true** => You do not to be superuser to access this plugin.
     * * **false** => You do need to be superuser to access this plugin.
     *
     * @return bool See method description.
     *
     */
    public function forAdminOnly()
    {
        return self::ADMINS_ONLY;
    }

    /**
     * HTML output (gets generated by twig).
     */
    public function html()
    {
        // Needs to be called once to initialize $this->lang.
        $this->setupLocale();

        $pagesWithoutTitle = [self::PAGES_NAME => PageGetter::getPagesWithoutTitle()];
        $totalPages = count($pagesWithoutTitle[self::PAGES_NAME]);

        $variables = [
            self::EDIT_IMAGE_URL_NAME => self::EDIT_IMAGE_URL,
            self::EXPORT_URL_NAME => self::EXPORT_URL,
            self::STYLESHEET_URL_NAME => self::STYLESHEET_URL,
            self::SCRIPT_URL_NAME => self::SCRIPT_URL,
            self::INFORMATION_IMAGE_URL_NAME => self::INFORMATION_IMAGE_URL,
            self::MAX_PAGES_NAME => self::MAX_PAGES,
            self::TOTAL_PAGES_NAME => $totalPages,
            self::LANGUAGE_NAME => $this->lang,
            self::PAGES_SKIPPED_NAME => ($totalPages - self::MAX_PAGES)
        ];

        $variablesForTemplate = array_merge($pagesWithoutTitle, $variables);

        // Set locale according to DokuWiki configuration
        global $conf;
        Locale::setDefault($conf[self::DOKUWIKI_LANG_NAME]);

        // Set up loader and environment for twig.
        $loader = new Twig_Loader_Filesystem(self::TEMPLATE_DIR);
        $twig = new Twig_Environment($loader);

        $twig->addExtension(new Twig_Extensions_Extension_Intl());

        echo $twig->render(self::TEMPLATE_FILE, $variablesForTemplate);
    }
    
    
    /**
     * @codeCoverageIgnore Ignored since this method is implemented, but does
     * nothing.
     */
    public function handle()
    {
        // Implements the function. Nothing to do here.
    }
}
