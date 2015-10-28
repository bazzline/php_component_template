<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-28
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

class CallableComplexFileBasedTemplateManager extends ComplexFileBasedTemplate
{
    /** @var array|callable[] */
    private $nameToCallableCollection = array();

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        $callableIsNotRegistered = (!$this->callableIsRegistered($name));

        if ($callableIsNotRegistered) {
            throw new RuntimeException(
                'no callable found for name "' . $name . '"'
            );
        }

        $callable = $this->getCallable($name);

        return call_user_func_array($callable, $arguments);
    }

    /**
     * @param string $name
     * @param callable $callable
     * @return $this
     * @throws InvalidArgumentException
     */
    public function registerCallable($name, $callable)
    {
        $nameIsNotAString = (!is_string($name));

        if ($nameIsNotAString) {
            throw new InvalidArgumentException(
                'name must be a valid string'
            );
        }

        $isNotCallable = (!is_callable($callable));

        if ($isNotCallable) {
            throw new InvalidArgumentException(
                'callable must be callable'
            );
        }

        $callableAlreadyRegistered = $this->callableIsRegistered($name);

        if ($callableAlreadyRegistered) {
            throw new InvalidArgumentException(
                'a callable with the name "' . $name . '" is already registered'
            );
        }

        $this->nameToCallableCollection[$name] = $callable;

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    private function callableIsRegistered($name)
    {
        return (isset($this->nameToCallableCollection[$name]));
    }

    /**
     * @param string $name
     * @return callable
     */
    private function getCallable($name)
    {
        return $this->nameToCallableCollection[$name];
    }
}