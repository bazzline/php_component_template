<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since: 2015-10-02
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

class RuntimeContentBasedTemplate extends AbstractTemplate implements DelimiterInterface
{
    /** @var string */
    private $closingDelimiter;

    /** @var null|string */
    private $content;

    /** @var string */
    private $openingDelimiter;

    /**
     * @param array $variables
     * @param null|string $content
     * @param string $openingDelimiter
     * @param string $closingDelimiter
     * @throws InvalidArgumentException
     */
    public function __construct($variables = array(), $content = null, $openingDelimiter = '{', $closingDelimiter = '}')
    {
        parent::__construct($variables);

        $this->setPropertiesIfProvided($content, $openingDelimiter, $closingDelimiter);
    }

    /**
     * @param array $variables
     * @param null|string $content
     * @param null|string $openingDelimiter
     * @param null|string $closingDelimiter
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __invoke($variables = array(), $content = null, $openingDelimiter = null, $closingDelimiter = null)
    {
        $this->setPropertiesIfProvided($content, $openingDelimiter, $closingDelimiter);

        return parent::__invoke($variables);
    }

    /**
     * @param string $closingDelimiter
     */
    public function setClosingDelimiter($closingDelimiter)
    {
        $this->closingDelimiter = $closingDelimiter;
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
     * @param string $openingDelimiter
     */
    public function setOpeningDelimiter($openingDelimiter)
    {
        $this->openingDelimiter = $openingDelimiter;
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

    /**
     * @param null $content
     * @param null|string $closingDelimiter
     * @param null|string $openingDelimiter
     * @throws InvalidArgumentException
     */
    private function setPropertiesIfProvided($content = null, $closingDelimiter = null, $openingDelimiter = null)
    {
        if (!is_null($content)) {
            $this->setContent($content);
        }

        if (!is_null($closingDelimiter)) {
            $this->setClosingDelimiter($closingDelimiter);
        }

        if (!is_null($openingDelimiter)) {
            $this->setOpeningDelimiter($openingDelimiter);
        }
    }
}
