<?php declare(strict_types=1);
namespace Diva;

/**
 * @var Module $this
 * @var \Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator
 * @var string $oldVersion
 * @var string $newVersion
 */
$services = $serviceLocator;

/**
 * @var \Omeka\Settings\Settings $settings
 * @var \Doctrine\DBAL\Connection $connection
 * @var array $config
 * @var array $config
 * @var \Omeka\Mvc\Controller\Plugin\Api $api
 */
$settings = $services->get('Omeka\Settings');
$connection = $services->get('Omeka\Connection');
$config = require dirname(__DIR__, 2) . '/config/module.config.php';
$plugins = $services->get('ControllerPluginManager');
$api = $plugins->get('api');

if (version_compare($oldVersion, '3.1.0', '<')) {
    $sql = <<<SQL
DELETE FROM site_setting
WHERE id IN ('diva_append_item_set_show', 'diva_append_item_set_browse', 'diva_append_item_browse', 'diva_class', 'diva_style', 'diva_locale');
SQL;
    $connection->exec($sql);
}

if (version_compare($oldVersion, '3.1.2', '<')) {
    $sql = <<<'SQL'
DELETE FROM site_setting
WHERE id IN ("diva_append_item_set_show", "diva_append_item_show", "diva_append_item_set_browse", "diva_append_item_browse");
SQL;
    $connection->exec($sql);
}
