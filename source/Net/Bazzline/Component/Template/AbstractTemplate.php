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
    /** @var array */
    private $variables;

    /**
     * @param array $variables
     */
    public function __construct($variables = array())
    {
        $this->assignMany($variables, false);
    }

    /**
     * @param array $variables
     * @return string
     */
    public function __invoke($variables = array())
    {
        $this->assignMany($variables);

        return $this->render();
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
     * @return string
     * @throws RuntimeException
     */
    public function render()
    {
        $content    = $this->getContent();
        $variables  = $this->getVariables();
        $keys       = array_keys($variables);

        return str_replace($keys, $variables, $content);
    }

    public function reset()
    {
        $this->assignMany(array(), false);
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
    protected function getValueByKeyOrNull($key)
    {
        return ($this->isAssigned($key))
            ? $this->variables[$key]
            : null;
    }

    /**
     * @return array
     */
    protected function getVariables()
    {
        return $this->variables;
    }
}
