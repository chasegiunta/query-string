<?php
/**
 * Query String plugin for Craft CMS 3.x
 *
 * Work with query strings
 *
 * @link      https://chasegiunta.com
 * @copyright Copyright (c) 2018 Chase Giunta
 */

namespace chasegiunta\querystring\variables;

use chasegiunta\querystring\QueryString;

use Craft;

/**
 * Query String Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.queryString }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Chase Giunta
 * @package   QueryString
 * @since     1.0.0
 */
class QueryStringVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.queryString.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.queryString.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
