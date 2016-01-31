<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-28
 */
namespace Test\Net\Bazzline\Component\Template;

use Net\Bazzline\Component\Template\CallableComplexFileBasedTemplateManager;
use Net\Bazzline\Component\Template\RuntimeContentBasedTemplate;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit_Framework_TestCase;

class CallableComplexFileBasedTemplateManagerTest extends PHPUnit_Framework_TestCase
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
                <head><?php echo $this->title(); ?></head>
                <body>
                    <?php echo $this->headliner($headline); ?>
                    <?php echo $this->paragraph(array(\'content\' => $this->content)); ?>
                </body>
            </html>
        ';

        //a anonymous function
        $headliner = function($headline) {
            return '<h1>' . $headline . '</h1>' . PHP_EOL;
        };

        //a template
        $paragraph = new RuntimeContentBasedTemplate();
        $paragraph->setContent('<p>{content}</p>' . PHP_EOL);

        //an other template
        $title = new RuntimeContentBasedTemplate(
            array(
                'title' => 'there is no foo without a bar'
            ),
            '<title>{title}</title>'
        );

        return array(
            'content with a callable collection' => array(
                $defaultContent,
                array(
                    'headline' => 'foo',
                    'content' => 'bar'
                ),
                array(
                    'headliner' => $headliner,
                    'paragraph' => $paragraph,
                    'title'     => $title
                ),
                str_replace(
                    array(
                        '<?php echo $this->title(); ?>',
                        '<?php echo $this->headliner($headline); ?>',
                        '<?php echo $this->paragraph(array(\'content\' => $this->content)); ?>'
                    ),
                    array(
                        '<title>there is no foo without a bar</title>',
                        '<h1>foo</h1>',
                        '<p>bar</p>'
                    ),
                    $defaultContent
                )
            )
        );
    }

    /**
     * @dataProvider testCaseProvider
     * @param string $templateContent
     * @param array $variables
     * @param array $nameToCallableCollection
     * @param string $expectedContent
     */
    public function testRender($templateContent, array $variables, array $nameToCallableCollection = array(), $expectedContent)
    {
        $path       = $this->filePath;
        $template   = $this->getNewTemplate($path);

        file_put_contents($path, $templateContent);

        foreach ($nameToCallableCollection as $name => $callable) {
            $template->registerCallable($name, $callable);
        }

        $content = $template($variables);

        $this->assertEquals($expectedContent, $content);
        $this->assertEquals($expectedContent, (string) $template);
    }

    /**
     * @param null|string $filePath
     * @return CallableComplexFileBasedTemplateManager
     */
    private function getNewTemplate($filePath = null)
    {
        $template = new CallableComplexFileBasedTemplateManager();

        if (!is_null($filePath)) {
            $template->setFilePath($filePath);
        }

        return $template;
    }
}