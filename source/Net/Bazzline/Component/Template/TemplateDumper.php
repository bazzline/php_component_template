<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-09
 */
namespace Net\Bazzline\Component\Template;

class TemplateDumper
{
    /**
     * @param TemplateInterface $template
     * @param string $filePath
     * @return bool
     */
    public function __invoke(TemplateInterface $template, $filePath)
    {
        return $this->dump($template, $filePath);
    }

    /**
     * @param TemplateInterface $template
     * @param string $filePath
     * @return bool
     */
    public function dump(TemplateInterface $template, $filePath)
    {
        $wasSuccessful = (file_put_contents($filePath, $template->render()) !== false);

        return $wasSuccessful;
    }
}