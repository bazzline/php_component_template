<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-01
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

class Template
{
    /** @var string */
    private $closingDelimiter;

    /** @var null|string */
    private $filePath;

    /** @var string */
    private $openDelimiter;

    /** @var array */
    private $variables;

    /**
     * @param null|string $filePath
     * @param array $variables
     * @param string $openDelimiter
     * @param string $closingDelimiter
     * @throws InvalidArgumentException
     */
    public function __construct($filePath = null, $variables = array(), $openDelimiter = '{', $closingDelimiter = '}')
    {
        if (!is_null($filePath)) {
            $this->setFilePath($filePath);
        }

        $this->assignMany($variables, false);
        $this->setOpenDelimiter($openDelimiter);
        $this->setClosingDelimiter($closingDelimiter);
    }

    /**
     * @param array $variables
     * @param bool $mergeWithExisting
     */
    public function assignMany(array $variables, $mergeWithExisting = true)
    {
        if ($mergeWithExisting) {
            $this->variables = array_merge($this->variables, $variables);
        } else {
            $this->variables = $variables;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function assignOne($key, $value)
    {
        $this->assignMany(array($key => $value));
    }

    /**
     * @param string $closingDelimiter
     */
    public function setClosingDelimiter($closingDelimiter)
    {
        $this->closingDelimiter = $closingDelimiter;
    }

    /**
     * @param null|string $filePath
     * @throws InvalidArgumentException
     */
    public function setFilePath($filePath)
    {
        if (!file_exists($filePath)) {
            throw new InvalidArgumentException(
                'file path: "' . $filePath . '" does not exist'
            );
        }

        if (!is_readable($filePath)) {
            throw new InvalidArgumentException(
                'file path: "' . $filePath . '" is not readable'
            );
        }

        $this->filePath = $filePath;
    }

    /**
     * @param string $openDelimiter
     */
    public function setOpenDelimiter($openDelimiter)
    {
        $this->openDelimiter = $openDelimiter;
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function render()
    {
        $content    = $this->tryToReadFileContentOrThrowRuntimeException();
        $variables  = $this->getVariablesWithDelimiters();
        $keys       = array_keys($variables);

        return str_replace($keys, $variables, $content);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return array
     */
    private function getVariablesWithDelimiters()
    {
        $prefix     = $this->openDelimiter;
        $suffix     = $this->closingDelimiter;
        $variables  = $this->variables;
        $array      = array();  //@todo find a better name

        foreach ($variables as $key => $value) {
            $array[$prefix . $key . $suffix] = $value;
        }

        return $array;
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    private function tryToReadFileContentOrThrowRuntimeException()
    {
        $filePath = $this->filePath;

        if (is_numeric($filePath)) {
            throw new RuntimeException(
                'no template file path provided'
            );
        }

        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new RuntimeException(
                'could not read content from "' . $filePath . '"'
            );
        }

        return $content;
    }
}