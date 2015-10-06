<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-01
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

abstract class AbstractTemplate implements TemplateInterface
{
    /** @var string */
    private $closingDelimiter;

    /** @var string */
    private $openDelimiter;

    /** @var array */
    private $variables;

    /**
     * @param array $variables
     * @param string $openDelimiter
     * @param string $closingDelimiter
     * @throws InvalidArgumentException
     */
    public function __construct($variables = array(), $openDelimiter = '{', $closingDelimiter = '}')
    {
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
     * @param string $key
     * @return bool
     */
    public function isAssigned($key)
    {
        return (isset($this->variables[$key]));
    }

    /**
     * @param string $closingDelimiter
     */
    public function setClosingDelimiter($closingDelimiter)
    {
        $this->closingDelimiter = $closingDelimiter;
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
        $content    = $this->getContent();
        $variables  = $this->getVariablesWithDelimiters();
        $keys       = array_keys($variables);

        return str_replace($keys, $variables, $content);
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    abstract protected function getContent();

    /**
     * @param string $key
     * @return null|mixed
     */
    protected function getValue($key)
    {
        return ($this->isAssigned($key))
            ? $this->variables[$key]
            : null;
    }

    /**
     * @return array
     */
    protected function getValues()
    {
        return $this->variables;
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
}
