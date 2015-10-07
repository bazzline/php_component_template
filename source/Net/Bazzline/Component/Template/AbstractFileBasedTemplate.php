<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-07
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

abstract class AbstractFileBasedTemplate extends AbstractTemplate
{
    /** @var null|string */
    private $filePath;

    /**
     * @param array $variables
     * @param null|string $filePath
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __construct($variables = array(), $filePath = null)
    {
        parent::__construct($variables);

        $this->setFilePathIfProvided($filePath);
    }

    /**
     * @param array $variables
     * @param null $filePath
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __invoke($variables = array(), $filePath = null)
    {
        $this->setFilePathIfProvided($filePath);

        return parent::__invoke($variables);
    }

    /**
     * @param string $filePath
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function setFilePath($filePath)
    {
        $this->throwRuntimeExceptionIfFilePathIsInvalid($filePath);

        if (!is_readable($filePath)) {
            throw new InvalidArgumentException(
                'file path: "' . $filePath . '" is not readable'
            );
        }

        $this->filePath = $filePath;
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    protected function getContent()
    {
        $filePath = $this->getFilePath();

        $this->throwRuntimeExceptionIfFilePathIsInvalid($filePath);

        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new RuntimeException(
                'could not read content from "' . $filePath . '"'
            );
        }

        return $content;
    }

    /**
     * @return null|string
     */
    protected function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     * @throws RuntimeException
     */
    protected function throwRuntimeExceptionIfFilePathIsInvalid($filePath)
    {
        if (is_null($filePath)) {
            throw new RuntimeException(
                'file path must be a valid string'
            );
        }

        if (!file_exists($filePath)) {
            throw new InvalidArgumentException(
                'file path: "' . $filePath . '" does not exist'
            );
        }

        if (!is_readable($filePath)) {
            throw new RuntimeException(
                'file path: "' . $filePath . '" is not readable'
            );
        }
    }

    /**
     * @param null|string $filePath
     * @throws RuntimeException
     */
    protected function setFilePathIfProvided($filePath = null)
    {
        if (!is_null($filePath)) {
            $this->setFilePath($filePath);
        }
    }
}