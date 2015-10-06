<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-03
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

class ViewTemplate extends FileTemplate
{

    /**
     * @param null|string $filePath
     * @param array $variables
     * @throws InvalidArgumentException
     */
    public function __construct($filePath = null, $variables = array())
    {
        parent::__construct($filePath, $variables, '$', '');
    }

    /**
     * enables support for $this->foo
     * @param string $name
     * @return null|mixed
     */
    public function __get($name)
    {
        return $this->getValue($name);
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function render()
    {
        $filePath   = $this->getFilePath();
        $values     = $this->getValues();

        $this->throwRuntimeExceptionIfFilePathIsInvalid($filePath);

        //enable support for $foo
        extract($values);

        ob_start();
        include $filePath;
        $content = ob_get_clean();

        return $content;
    }
}
