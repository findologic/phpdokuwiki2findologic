<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/dokuwiki_export/filesAndDirectories.php';



class DokuwikiXMLExportTest extends TestCase
{
    public function testForAnEmptyDokuwikiNoPagesAreExported()
    {
        $getFilesAndDirectories = new filesAndDirectories();
        $test = $getFilesAndDirectories->getFilesAndDirectories(__DIR__ . '/fakeDokuwikis/fakeDokuwikiPages0');

        $failMessage = 'An empty array should be returned if no pages are in the Dokuwiki directory.';
        $this->assertEmpty($test, $failMessage);
    }
    public function testForADokuwikiWithOnePageOnlyOnePageIsExported()
    {
        $getFilesAndDirectories = new filesAndDirectories();
        $test = $getFilesAndDirectories->getFilesAndDirectories(__DIR__ . '/fakeDokuwikis/fakeDokuwikiPages1');

        $expected = array();
        $expected[0] = __DIR__ .  '/fakeDokuwikis/fakeDokuwikiPages1/test/home.txt';

        $failMessage = 'A array with one value should be returned if only one page is in the Dokuwiki directory.';
        $this->assertEquals($expected, $test, $failMessage);
    }
    public function testForADokuwikiWithTwoPagesAnArrayWithTwoValuesIsExported()
    {
        $getFilesAndDirectories = new filesAndDirectories();
        $test = $getFilesAndDirectories->getFilesAndDirectories(__DIR__ . '/fakeDokuwikis/fakeDokuwikiPages2');

        $expected = array();
        $expected[0] = __DIR__ . '/fakeDokuwikis/fakeDokuwikiPages2/findologic_documentation.txt';
        $expected[1] = __DIR__ . '/fakeDokuwikis/fakeDokuwikiPages2/home.txt';

        $failMessage = 'An array which should have two keys should be returned if there are two pages in the Dokuwiki directory';
        $this->assertEquals($expected, $test, $failMessage);
    }
}