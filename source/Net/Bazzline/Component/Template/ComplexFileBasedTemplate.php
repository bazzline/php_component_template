<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-03
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

class ComplexFileBasedTemplate extends AbstractFileBasedTemplate
{
    /**
     * @param null|string $filePath
     * @param array $variables
     * @throws InvalidArgumentException
     */
    public function __construct($filePath = null, $variables = array())
    {
        parent::__construct($variables, $filePath);
    }

    /**
     * enables support for $this->foo
     * @param string $name
     * @return null|mixed
     */
    public function __get($name)
    {
        return $this->getValueByKeyOrNull($name);
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function render()
    {
        $filePath   = $this->getFilePath();
        $variables  = $this->getVariables();

        $this->throwRuntimeExceptionIfFilePathIsInvalid($filePath);

        //enable support for $foo
        extract($variables, EXTR_SKIP);

        ob_start();
        include $filePath;
        $content = ob_get_clean();

        return $content;
    }
}
