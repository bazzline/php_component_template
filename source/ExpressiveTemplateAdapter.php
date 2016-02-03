<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-02-03
 */
namespace Net\Bazzline\Component\Template;

use Zend\Expressive\Template\TemplatePath;
use Zend\Expressive\Template\TemplateRendererInterface;

class ExpressiveTemplateAdapter implements TemplateRendererInterface
{
    /** @var AbstractFileBasedTemplate */
    private $baseTemplate;

    /** @var array */
    private $defaultParameters = array();

    /** @var bool */
    private $defaultParametersProvided = false;

    /** @var array */
    private $fullQualifiedPathNameWithDefaultParameters = array();

    /** @var array|TemplatePath[] */
    private $fullQualifiedPathNameWithTemplatePath = array();

    /**
     * @param AbstractFileBasedTemplate $template
     */
    public function injectBaseTemplate(AbstractFileBasedTemplate $template)
    {
        $this->baseTemplate = $template;
    }

    /**
     * Render a template, optionally with parameters.
     *
     * Implementations MUST support the `namespace::template` naming convention,
     * and allow omitting the filename extension.
     *
     * @param string $name
     * @param array|object $params
     * @return string
     */
    public function render($name, $params = [])
    {
        if (isset($this->fullQualifiedPathNameWithTemplatePath[$name])) {
            $template   = $this->getNewTemplate();
            $path       = $this->fullQualifiedPathNameWithTemplatePath[$name];

            $template->setFilePath($path->getPath() . '.phtml');

            if ($this->defaultParametersProvided) {
                $template->assignMany($this->defaultParameters);
            }

            if (isset($this->fullQualifiedPathNameWithDefaultParameters[$name])) {
                $template->assignMany($this->fullQualifiedPathNameWithDefaultParameters[$name]);
            }

            if (!empty($params)) {
                $template->assignMany($params);
            }

            $content = $template->render();
        } else {
            $content = '';
        }

        return $content;
    }

    /**
     * Add a template path to the engine.
     *
     * Adds a template path, with optional namespace the templates in that path
     * provide.
     *
     * @param string $path
     * @param string $namespace
     */
    public function addPath($path, $namespace = null)
    {
        $key = (is_null($namespace)) ? $path : $namespace . '::' . $path;

        $this->fullQualifiedPathNameWithTemplatePath[$key] = new TemplatePath($path, $namespace);
    }

    /**
     * Retrieve configured paths from the engine.
     *
     * @return TemplatePath[]
     */
    public function getPaths()
    {
        return $this->fullQualifiedPathNameWithTemplatePath;
    }

    /**
     * Add a default parameter to use with a template.
     *
     * Use this method to provide a default parameter to use when a template is
     * rendered. The parameter may be overridden by providing it when calling
     * `render()`, or by calling this method again with a null value.
     *
     * The parameter will be specific to the template name provided. To make
     * the parameter available to any template, pass the TEMPLATE_ALL constant
     * for the template name.
     *
     * If the default parameter existed previously, subsequent invocations with
     * the same template name and parameter name will overwrite.
     *
     * @param string $templateName Name of template to which the param applies;
     *     use TEMPLATE_ALL to apply to all templates.
     * @param string $param Param name.
     * @param mixed $value
     */
    public function addDefaultParam($templateName, $param, $value)
    {
        $isDefaultForAllTemplates = ($templateName === self::TEMPLATE_ALL);

        if ($isDefaultForAllTemplates) {
            $this->defaultParameters[$param] = $value;
            $this->defaultParametersProvided = true;
        } else {
            $this->fullQualifiedPathNameWithDefaultParameters[$templateName] = array($param => $value);
        }
    }

    /**
     * @return AbstractFileBasedTemplate
     */
    private function getNewTemplate()
    {
        return clone $this->baseTemplate;
    }
}