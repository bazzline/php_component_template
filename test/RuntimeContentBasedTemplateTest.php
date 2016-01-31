<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-08
 */
namespace Test\Net\Bazzline\Component\Template;

use Net\Bazzline\Component\Template\RuntimeContentBasedTemplate;
use PHPUnit_Framework_TestCase;

class RuntimeContentBasedTemplateTest extends PHPUnit_Framework_TestCase
{
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
        $template   = $this->getNewTemplate($templateContent);

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
        $template   = $this->getNewTemplate($templateContent);

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
        $template   = $this->getNewTemplate($templateContent);

        $content = $template($variables);

        $this->assertEquals($expectedContent, $content);
        $this->assertEquals($expectedContent, (string) $template);
    }

    public function testStackTemplates()
    {
        $innerTemplate  = $this->getNewTemplate('inner: {inner_content}');
        $outerTemplate  = $this->getNewTemplate('outer: {outer_content}');

        $innerTemplate->assignOne('inner_content', 'foo');
        $outerTemplate->assignOne('outer_content', $innerTemplate);

        $content        = $outerTemplate->render();

        $this->assertEquals('outer: inner: foo', $content);
    }

    /**
     * @param null|string $content
     * @return RuntimeContentBasedTemplate
     */
    private function getNewTemplate($content = null)
    {
        $template = new RuntimeContentBasedTemplate();

        if (!is_null($content)) {
            $template->setContent($content);
        }

        return $template;
    }
}
