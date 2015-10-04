<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-03
 */
namespace Net\Bazzline\Component\Template;

use RuntimeException;

class ViewTemplate extends FileTemplate
{
    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getValue($name);
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function render()
    {
        ob_start();
        eval($this->getContent());
        //include $this->getF
        $content = ob_get_clean();

        return $content;
    }
}