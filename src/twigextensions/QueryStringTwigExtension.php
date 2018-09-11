<?php
/**
 * Query String plugin for Craft CMS 3.x
 *
 * Work with query strings
 *
 * @link      https://chasegiunta.com
 * @copyright Copyright (c) 2018 Chase Giunta
 */

namespace chasegiunta\querystring\twigextensions;

use chasegiunta\querystring\QueryString;

use Craft;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Chase Giunta
 * @package   QueryString
 * @since     1.0.0
 */
class QueryStringTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'QueryString';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('addParams', [$this, 'addParams']),
            new \Twig_SimpleFilter('removeParams', [$this, 'removeParam']),
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
    * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('addParams', [$this, 'addParams']),
            new \Twig_SimpleFunction('removeParams', [$this, 'removeParams']),
            new \Twig_SimpleFunction('removeKeys', [$this, 'removeKeys']),
            new \Twig_SimpleFunction('removeValues', [$this, 'removeValues']),
            new \Twig_SimpleFunction('replaceParams', [$this, 'replaceParams']),
        ];
    }

    public function getCurrentParams($url = null) {
        if ($url === NULL) {
            return Craft::$app->request->queryParams;
        } else {
            $query = parse_url($url)['query'];
            parse_str($query, $output);
            return $output;
        }
    }

    /**
     * Our function called via Twig; it can do anything you want
     *
     * @param mixed $payload
     *
     * @return string
     */
    public function addParams($addedParams, $url = null)
    {
        $currentParams = $this->getCurrentParams($url);

        $merged = array_merge($currentParams, $addedParams);

        return $this->build($merged, $url);
    }

    /**
     * Our function called via Twig; it can do anything you want
     *
     * @param mixed $payload
     *
     * @return string
     */
    public function removeParams($params, $url = null)
    {
        $currentParams = $this->getCurrentParams($url);

        // There could be multiple keys with the same value
        foreach ($currentParams as $currentKey => $currentValue) {
            foreach ($params as $key => $value) {
                if ($key == $currentKey && $value == $currentValue) {
                    unset($currentParams[$key]);
                }
            }
        }
        
        return $this->build($currentParams);
    }

    /**
     * Our function called via Twig; it can do anything you want
     *
     * @param mixed $payload
     *
     * @return string
     */
    public function removeKeys($keys, $url = null)
    {
        $currentParams = $this->getCurrentParams($url);

        if (is_string($keys)) {
            $keys = [$keys];
        }

        foreach ($keys as $key) {
            unset($currentParams[$key]);
        }
        
        return $this->build($currentParams);
    }

    /**
     * Our function called via Twig; it can do anything you want
     *
     * @param mixed $payload
     *
     * @return string
     */
    public function removeValues($values, $url = null)
    {
        $currentParams = $this->getCurrentParams($url);

        if (is_string($values)) {
            $values = [$values];
        }

        // There could be multiple keys with the same value
        foreach ($currentParams as $key => $param) {
            foreach ($values as $value) {
                if ($param == $value) {
                    unset($currentParams[$key]);
                }
            }
        }
        
        return $this->build($currentParams);
    }

    /**
     * Our function called via Twig; it can do anything you want
     *
     * @param mixed $payload
     *
     * @return string
     */
    public function replaceParams($params, $url = null)
    {
        $currentParams = $this->getCurrentParams($url);

        foreach ($params as $key => $value) {
            unset($currentParams[$key]);
        }

        $merged = array_merge($currentParams, $params);

        return $this->build($merged);
    }

    
    public function build($params, $url = null)
    {
        if ($url === NULL) {
            $currentPath = Craft::$app->request->fullPath;
        } else {
            $currentPath = ltrim(parse_url($url)['path'], '/');
        }

        $builtQuery = http_build_query($params);
        return "/$currentPath?$builtQuery";
    }


}
