<?php
/**
 * Plugin Name: EDD - Stripe Checkout
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: Check out using Stripe Checkout.
 * Version: 1.0
 * Author: Ashley Gibson
 * Author URI: https://www.nosegraze.com
 * License: GPL2+
 *
 * EDD Stripe Checkout is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * EDD Stripe Checkout is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with EDD Stripe Checkout. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout;

if (version_compare(phpversion(), '8.0', '<')) {
    return;
}

const EDD_STRIPE_CHECKOUT_FILE = __FILE__;

/**
 * Returns the requested object from the service container, or the main Plugin object.
 *
 * @since 1.0
 *
 * @param string|null $abstract Class name to retrieve.
 *
 * @return Plugin|object
 */
function app($abstract = null)
{
    static $instance = null;

    if ($instance === null) {
        $instance = new Plugin();
    }

    if ($abstract !== null) {
        return $instance->make($abstract);
    }

    return $instance;
}

require_once dirname(__FILE__).'/vendor/autoload.php';
\EDD\ExtensionUtils\v1\ExtensionLoader::loadOrQuit(
    __FILE__,
    function () {
        app()->boot();
    },
    [
        'php'                    => '8.0',
        'easy-digital-downloads' => '3.0-beta1',
    ]
);
