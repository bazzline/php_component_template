<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-07
 */
namespace Net\Bazzline\Component\Template;

interface DelimiterInterface
{
    /**
     * @param string $closingDelimiter
     */
    public function setClosingDelimiter($closingDelimiter);

    /**
     * @param string $openingDelimiter
     */
    public function setOpeningDelimiter($openingDelimiter);
}