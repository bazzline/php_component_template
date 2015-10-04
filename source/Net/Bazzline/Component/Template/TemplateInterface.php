<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-02
 */
namespace Net\Bazzline\Component\Template;

use RuntimeException;

interface TemplateInterface
{
    /**
     * @param array $variables
     * @param bool $mergeWithExisting
     */
    public function assignMany(array $variables, $mergeWithExisting = true);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function assignOne($key, $value);

    /**
     * @param string $key
     * @return bool
     */
    public function isAssigned($key);

    /**
     * @return string
     * @throws RuntimeException
     */
    public function render();

    /**
     * @return string
     * @throws RuntimeException
     */
    public function __toString();
}
