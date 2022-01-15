<?php
/**
 * CheckoutSessionsRepository.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Database\Repositories;

use EDD\StripeCheckout\Database\Tables\CheckoutSessionsTable;
use EDD\StripeCheckout\Exceptions\ModelNotFoundException;
use EDD\StripeCheckout\Models\CheckoutSession;

class CheckoutSessionsRepository
{

    protected \wpdb $wpdb;

    public function __construct(protected CheckoutSessionsTable $table)
    {
        global $wpdb;

        $this->wpdb = $wpdb;
    }

    public function insert(string $sessionId, array $cart, ?int $orderId = null): int
    {
        $this->wpdb->insert(
            $this->table->tableName(),
            [
                'session_id' => $sessionId,
                'order_id'   => $orderId,
                'cart'       => json_encode($cart),
            ],
            [
                '%s',
                '%d',
                '%s',
            ]
        );

        return (int) $this->wpdb->insert_id;
    }

    public function getBySessionId(string $sessionId): CheckoutSession
    {
        $row = $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT * FROM {$this->table->tableName()}
            WHERE session_id = %s",
            $sessionId
        ), ARRAY_A);

        if (empty($row)) {
            throw new ModelNotFoundException();
        }

        return new CheckoutSession($row);
    }

    public function setOrderIdForSession(string $sessionId, int $orderId): void
    {
        $this->wpdb->query($this->wpdb->prepare(
            "UPDATE {$this->table->tableName()} SET order_id = %d WHERE session_id = %s",
            $orderId,
            $sessionId
        ));
    }

}
