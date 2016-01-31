<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-01
 */
namespace Test\Net\Bazzline\Component\Template;

use Net\Bazzline\Component\Template\FileBasedTemplate;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit_Framework_TestCase;

//@todo add tests for !file_exists and !readable
class FileBasedTemplateTest extends PHPUnit_Framework_TestCase
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

    /**
     * @return array
     */
    public function testCaseProvider()
    {
        $defaultContent = '
            <html>
                <head></head>
                <body>
                    <h1>{headline}</h1>
                    <p>{content}</p>
                </body>
            </html>
        ';

        return array(
            'content with all available variables' => array(
                $defaultContent,
                array('headline' => 'foo', 'content' => 'bar'),
                str_replace(array('{headline}', '{content}'), array('foo', 'bar'), $defaultContent)
            )
        );
    }

    /**
     * @dataProvider testCaseProvider
     * @param string $templateContent
     * @param array $variables
     * @param string $expectedContent
     */
    public function testRenderByUsingAssignMany($templateContent, array $variables, $expectedContent)
    {
        $path       = $this->filePath;
        $template   = $this->getNewTemplate($path);

        file_put_contents($path, $templateContent);

        $template->assignMany($variables);
        $content = $template->render();

        $this->assertEquals($expectedContent, $content);
        $this->assertEquals($expectedContent, (string) $template);
    }

    /**
     * @dataProvider testCaseProvider
     * @param string $templateContent
     * @param array $variables
     * @param string $expectedContent
     */
    public function testRenderByUsingAssignOne($templateContent, array $variables, $expectedContent)
    {
        $path       = $this->filePath;
        $template   = $this->getNewTemplate($path);

        file_put_contents($path, $templateContent);

        foreach ($variables as $key => $value) {
            $template->assignOne($key, $value);
        }
        $content = $template->render();

        $this->assertEquals($expectedContent, $content);
        $this->assertEquals($expectedContent, (string) $template);
    }

    /**
     * @dataProvider testCaseProvider
     * @param string $templateContent
     * @param array $variables
     * @param string $expectedContent
     */
    public function testRenderByUsingInvoke($templateContent, array $variables, $expectedContent)
    {
        $path       = $this->filePath;
        $template   = $this->getNewTemplate($path);

        file_put_contents($path, $templateContent);

        $content = $template($variables);

        $this->assertEquals($expectedContent, $content);
        $this->assertEquals($expectedContent, (string) $template);
    }

    /**
     * @param null|string $filePath
     * @return FileBasedTemplate
     */
    private function getNewTemplate($filePath = null)
    {
        $template = new FileBasedTemplate();

        if (!is_null($filePath)) {
            $template->setFilePath($filePath);
        }

        return $template;
    }
}
