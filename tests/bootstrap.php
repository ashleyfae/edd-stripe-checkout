<?php
/**
 * PHPUnit Bootstrap
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

$testsDir = getenv('WP_TESTS_DIR') ? : '/tmp/wordpress-tests-lib';
require_once $testsDir.'/includes/functions.php';

require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

/**
 * Load plugin files.
 */
tests_add_filter('muplugins_loaded', function () {
    // Load EDD
    if (file_exists('/tmp/wordpress/wp-content/plugins/easy-digital-downloads/easy-digital-downloads.php')) {
        require '/tmp/wordpress/wp-content/plugins/easy-digital-downloads/easy-digital-downloads.php';
    } else {
        require dirname(__FILE__).'/../../easy-digital-downloads/easy-digital-downloads.php';
    }

    require dirname(__FILE__).'/../edd-stripe-checkout.php';
});

// Start up the WP testing environment.
require $testsDir.'/includes/bootstrap.php';

echo "Installing Easy Digital Downloads...\n";
activate_plugin('easy-digital-downloads/easy-digital-downloads.php');
edd_run_install();

add_filter('pre_http_request', function ($status = false, $args = [], $url = '') {
    return new \WP_Error('no_reqs_in_unit_tests', 'HTTP Requests disabled for unit tests.');
});

echo "Installing Stripe Checkout...\n";
activate_plugin('edd-stripe-checkout/edd-stripe-checkout.php');

/** @var \EDD\StripeCheckout\Database\TableRegistry $tableRegistry */
$tableRegistry = \EDD\StripeCheckout\app(\EDD\StripeCheckout\Database\TableRegistry::class);
foreach ($tableRegistry->getTables() as $table) {
    if ($table->exists()) {
        $table->uninstall();
    }

    $table->createOrUpdateTable();
}

\EDD\StripeCheckout\app()->boot();
