<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace AgParsedown;

use Parsedown;
use RuntimeException;
use Zend\View\Helper\HelperInterface;
use Zend\View\Renderer\RendererInterface;

class AgParsedown implements HelperInterface
{
    /**
     * @var Parsedown
     */
    protected $parsedown;

    /**
     * @param Parsedown $parsedown
     */
    public function __construct(Parsedown $parsedown)
    {
        $this->parsedown = $parsedown;
    }

    /**
     * Invoke as a function
     *
     * @param string $string
     * @return string
     * @throws RuntimeException for non-string input
     */
    public function __invoke($string)
    {
        if (!is_string($string)) {
            throw new RuntimeException(sprintf(
                'Parsedown helper can only accept strings; received "%s"',
                (is_object($string) ? get_class($string) : gettype($string))
            ));
        }
        return $this->parsedown->parse($string);
    }

    /**
     * @return Parsedown
     */
    public function getParsedown()
    {
        return $this->parsedown;
    }

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * Implement HelperInterface
     *
     * @param RendererInterface $renderer
     */
    public function setView(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Implement HelperInterface
     *
     * @return RendererInterface
     */
    public function getView()
    {
        return $this->renderer;
    }
}
