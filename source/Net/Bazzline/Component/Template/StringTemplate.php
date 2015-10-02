<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since: 2015-10-02
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

class StringTemplate extends AbstractTemplate
{
    /** @var null|string */
    private $content;

    /**
     * @param null|string $content
     * @param array $variables
     * @param string $openDelimiter
     * @param string $closingDelimiter
     * @throws InvalidArgumentException
     */
    public function __construct($content = null, $variables = array(), $openDelimiter = '{', $closingDelimiter = '}')
    {
        parent::__construct($variables, $openDelimiter, $closingDelimiter);

        if (!is_null($content)) {
            $this->setContent($content);
        }
    }

    /**
     * @param string $content
     * @throws InvalidArgumentException
     */
    public function setContent($content)
    {
        $content = (string) $content;

        if (strlen($content < 1)) {
            throw new InvalidArgumentException(
                'content must have a string length of at least one character'
            );
        }

        $this->content = $content;
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    protected function getContent()
    {
        if (is_null($this->content)) {
            throw new RuntimeException(
                'no content provided'
            );
        }

        return $this->content;
    }
}
