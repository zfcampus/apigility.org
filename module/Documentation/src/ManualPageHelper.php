<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Documentation;

use AgParsedown\AgParsedown;
use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\Url as UrlHelper;
use Zend\View\Renderer\RendererInterface;

class ManualPageHelper implements HelperInterface
{
    /**
     * @var AgParsedown
     */
    protected $parsedown;

    /**
     * @var Pygmentize
     */
    protected $pygmentize;

    /**
     * @var UrlHelper
     */
    protected $url;

    /**
     * @param AgParsedown $parsedown
     */
    public function __construct(AgParsedown $parsedown, UrlHelper $url, Pygmentize $pygmentize)
    {
        $this->parsedown  = $parsedown;
        $this->url        = $url;
        $this->pygmentize = $pygmentize;
    }

    /**
     * Invoke as a function
     *
     * @param string $string
     * @param DocumentationModel $model
     * @param bool $highlightContents
     * @return string
     * @throws RuntimeException for non-string input
     */
    public function __invoke($page, DocumentationModel $model, $highlightContents = true)
    {
        $contents = $model->getPageContents($page);

        // highlight fenced code blocks
        if ($highlightContents) {
            $contents = preg_replace_callback("#\n\`{3}(?P<lexer>[a-z0-9-]+)\n(?P<code>.*?)\n\`{3}#is", array($this, 'highlightFencedBlock'), $contents);
        }

        // transform markdown to HTML
        $html = $this->parsedown->__invoke($contents);

        // transform links
        $html = preg_replace_callback('#(?P<attr>src|href)="/(?P<link>[^"]+)"#s', array($this, 'rewriteLinks'), $html);

        return $html;
    }

    /**
     * @param array $matches 
     * @return string
     */
    public function highlightFencedBlock(array $matches)
    {
        $lexer = $matches['lexer'];
        $code  = $matches['code'];
        return $this->pygmentize->transform($lexer, $code);
    }

    /**
     * @param array $matches 
     * @return string
     */
    public function rewriteLinks($matches)
    {
        $attr = $matches['attr'];
        $link = '/' . preg_replace('%^(?:asset/)?(.*?)(?:\.md)?(?P<anchor>#[a-z0-9_-]+)?$%i', '$1', $matches['link']);

        // Non-asset link needs to be relative to documentation route
        if (0 !== strpos($matches['link'], 'asset/')) {
            $link = $this->url->__invoke('documentation') . $link;
        }

        if (isset($matches['anchor']) && !empty($matches['anchor'])) {
            $link .= $matches['anchor'];
        }

        return sprintf('%s="%s"', $attr, $link);
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
