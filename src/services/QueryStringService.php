<?php
/**
 * Query String plugin for Craft CMS 3.x
 *
 * Work with query strings
 *
 * @link      https://chasegiunta.com
 * @copyright Copyright (c) 2018 Chase Giunta
 */

namespace chasegiunta\querystring\services;

use chasegiunta\querystring\QueryString;

use Craft;
use craft\base\Component;

/**
 * QueryStringService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Chase Giunta
 * @package   QueryString
 * @since     1.0.0
 */
class QueryStringService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     QueryString::$plugin->queryStringService->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';

        return $result;
    }
}
