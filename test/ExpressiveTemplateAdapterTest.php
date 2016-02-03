<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-02-03
 */
namespace Test\Net\Bazzline\Component\Template;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit_Framework_TestCase;

class ExpressiveTemplateAdapterTest extends PHPUnit_Framework_TestCase
{
    /** @var string */
    private $filePath;

    /** @var vfsStreamDirectory */
    private $fileSystem;

    protected function setUp()
    {
        $file               = vfsStream::newFile('template');
        $this->fileSystem   = vfsStream::setup();
        $this->fileSystem->addChild($file);
        $this->filePath     = $file->url();
    }

    public function testAddAndGetPaths()
    {

    }
}