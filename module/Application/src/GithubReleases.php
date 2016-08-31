<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Application;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class GithubReleases implements Countable, IteratorAggregate
{
    /**
     * @var array
     */
    protected $releases;

    /**
     * @param array $releases
     */
    public function __construct(array $releases = [])
    {
        $this->releases = $this->parseReleases($releases);
    }

    /**
     * Implements Countable
     *
     * @return int
     */
    public function count()
    {
        return count($this->releases);
    }

    /**
     * Implements IteratorAggregate
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->releases);
    }

    /**
     * Parses releases for information of interest, and sorts by version in desc order
     *
     * @param array $releases
     * @return array
     */
    protected function parseReleases(array $releases)
    {
        $parsed = [];
        foreach ($releases as $release) {
            if (! is_object($release)) {
                continue;
            }
            if (! isset($release->tag_name)
                || ! isset($release->html_url)
            ) {
                continue;
            }

            $parsed[] = [
                'tag'   => $release->tag_name,
                'url'   => $release->html_url,
                'notes' => (isset($release->body) && ! empty($release->body))
                    ? $release->body
                    : 'No changelog available',
            ];
        }

        usort($parsed, function ($a, $b) {
            $compare = version_compare($a['tag'], $b['tag']);
            if ($compare === -1) {
                return 1;
            }
            if ($compare === 1) {
                return -1;
            }
            return 0;
        });

        return $parsed;
    }
}
