<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since: 2015-10-02
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

class FileTemplate extends AbstractTemplate
{
    /** @var null|string */
    private $filePath;

    /**
     * @param null|string $filePath
     * @param array $variables
     * @param string $openDelimiter
     * @param string $closingDelimiter
     * @throws InvalidArgumentException
     */
    public function __construct($filePath = null, $variables = array(), $openDelimiter = '{', $closingDelimiter = '}')
    {
        parent::__construct($variables, $openDelimiter, $closingDelimiter);

        if (!is_null($filePath)) {
            $this->setFilePath($filePath);
        }
    }

    /**
     * @param string $filePath
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
     * @return string
     * @throws RuntimeException
     */
    protected function getContent()
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
