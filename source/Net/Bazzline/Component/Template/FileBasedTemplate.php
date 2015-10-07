<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since: 2015-10-02
 */
namespace Net\Bazzline\Component\Template;

use InvalidArgumentException;
use RuntimeException;

class FileBasedTemplate extends AbstractFileBasedTemplate implements DelimiterInterface
{
    /** @var string */
    private $closingDelimiter;

    /** @var string */
    private $openingDelimiter;

    /**
     * @param null|string $filePath
     * @param array $variables
     * @param string $openingDelimiter
     * @param string $closingDelimiter
     * @throws InvalidArgumentException
     */
    public function __construct($filePath = null, $variables = array(), $openingDelimiter = '{', $closingDelimiter = '}')
    {
        parent::__construct($variables, $filePath);

        $this->setClosingDelimiter($closingDelimiter);
        $this->setOpeningDelimiter($openingDelimiter);
    }

    /**
     * @param array $variables
     * @param null $filePath
     * @param null|string $openingDelimiter
     * @param null|string $closingDelimiter
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __invoke($variables = array(), $filePath = null, $openingDelimiter = null, $closingDelimiter = null)
    {
        parent::__invoke($variables, $filePath);

        if (!is_null($closingDelimiter)) {
            $this->setClosingDelimiter($closingDelimiter);
        }
        if (!is_null($openingDelimiter)) {
            $this->setOpeningDelimiter($openingDelimiter);
        }

        return $this->render();
    }

    /**
     * @param string $closingDelimiter
     */
    public function setClosingDelimiter($closingDelimiter)
    {
        $this->closingDelimiter = $closingDelimiter;
    }

    /**
     * @param string $openingDelimiter
     */
    public function setOpeningDelimiter($openingDelimiter)
    {
        $this->openingDelimiter = $openingDelimiter;
    }

    /**
     * @return array
     */
    protected function getVariables()
    {
        $prefix     = $this->openingDelimiter;
        $suffix     = $this->closingDelimiter;
        $variables  = parent::getVariables();
        $array      = array();  //@todo find a better name

        foreach ($variables as $key => $value) {
            $array[$prefix . $key . $suffix] = $value;
        }

        return $array;
    }
}
