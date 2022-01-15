<?php
/**
 * Table.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Database\Tables;

abstract class Table implements TableInterface
{
    protected \wpdb $wpdb;

    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;
    }

    protected function getVersionOptionName(): string
    {
        return $this->tableName().'_db_version';
    }

    protected function getDbVersion(): ?string
    {
        $version = get_option($this->getVersionOptionName());

        return $version ? : null;
    }

    public function needsUpdate(): bool
    {
        return ! $this->getDbVersion() || version_compare($this->getDbVersion(), $this->tableVersion(), '<');
    }

    public function createOrUpdateTable(): void
    {
        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        dbDelta(
            "CREATE TABLE {$this->tableName()} ({$this->createSql()}) DEFAULT CHARACTER SET {$this->wpdb->charset} COLLATE {$this->wpdb->collate};"
        );

        update_option($this->getVersionOptionName(), $this->tableVersion());
    }

    public function truncate(): void
    {
        $this->wpdb->query("TRUNCATE TABLE {$this->tableName()}");
    }

    public function uninstall(): void
    {
        $this->wpdb->query("DROP TABLE IF EXISTS {$this->tableName()}");

        delete_option($this->getVersionOptionName());
    }

    public function exists(): bool
    {
        $result = $this->wpdb->get_var($this->wpdb->prepare(
            "SHOW TABLES LIKE %s",
            $this->wpdb->esc_like($this->tableName())
        ));

        return ! empty($result);
    }

}
