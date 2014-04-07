<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Documentation;

use AgParsedown\AgParsedown;
use Zend\Filter\FilterChain;
use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\Url as UrlHelper;
use Zend\View\Renderer\RendererInterface;

class ManualPageHelper implements HelperInterface
{
    /**
     * @var FilterChain;
     */
    protected $anchorFilterChain;

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
            $contents = preg_replace_callback("#(?P<prefix>\n(?:\>)?\s*)\`{3}(?P<lexer>[a-z0-9-]+)\n(?P<code>.*?)(?P<suffix>\n(?:\>)?\s*)\`{3}#is", array($this, 'highlightFencedBlock'), $contents);
        }

        // transform markdown to HTML
        $html = $this->parsedown->__invoke($contents);

        // transform links
        $html = preg_replace_callback('#(?P<attr>src|href)="/(?P<link>[^"]+)"#s', array($this, 'rewriteLinks'), $html);

        // add anchors to headers
        $html = preg_replace_callback('#<(?P<header>h[1-4])>(?P<content>.*?)</\1>#s', array($this, 'addAnchorsToHeaders'), $html);

        return $html;
    }

    /**
     * @param array $matches 
     * @return string
     */
    public function highlightFencedBlock(array $matches)
    {
        $prefix = $matches['prefix'];
        $lexer  = $matches['lexer'];
        $code   = $matches['code'];
        $suffix = $matches['suffix'];

        // Strip blockquote strings if found
        if (strstr($prefix, '> ')) {
            $code = preg_replace('#^\> #m', '', $code);
        }

        return $prefix . $this->pygmentize->transform($lexer, $code) . $suffix;
    }

    /**
     * @param array $matches 
     * @return string
     */
    public function rewriteLinks(array $matches)
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
     * @param array $matches 
     * @return string
     */
    public function addAnchorsToHeaders(array $matches)
    {
        $header  = $matches['header'];
        $content = $matches['content'];
        $name    = $this->getAnchorFilterChain()->filter($content);

        return sprintf('<%s><a name="%s"></a>%s</%s>', $header, $name, $content, $header);
    }

    /**
     * @return FilterChain
     */
    protected function getAnchorFilterChain()
    {
        if ($this->anchorFilterChain instanceof FilterChain) {
            return $this->anchorFilterChain;
        }

        $chain = new FilterChain();
        $chain->attachByName('StripTags');
        $chain->attachByName('PregReplace', array('pattern' => '/[^a-z0-9_ -]/i', 'replacement' => ''));
        $chain->attachByName('Word\SeparatorToDash'); // Uses " " as separator by default
        $chain->attachByName('StringToLower');

        $this->anchorFilterChain = $chain;
        return $this->anchorFilterChain;
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
