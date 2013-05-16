<?php
namespace Application;

use PPI\Module\RoutesProviderInterface,
    PPI\Module\Module as BaseModule,
    PPI\Autoload,
    PPI\Module\Service;

class Module extends BaseModule
{
    protected $_moduleName = 'Application';

    public function init($e)
    {
        Autoload::add(__NAMESPACE__, dirname(__DIR__));
    }

    /**
     * Get the routes for this module
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function getRoutes()
    {
        return $this->loadYamlRoutes(__DIR__ . '/resources/config/routes.yml');
    }

    /**
     * Get the configuration for this module
     *
     * @return array
     */
    public function getConfig()
    {
        return include(__DIR__ . '/resources/config/config.php');
    }

    public function getServiceConfig()
    {

        return array('factories' => array(

            'user.storage' => function($sm) {
                return new \Application\Storage\Users($sm->getService('datasource'));
            },

            'visits.storage' => function($sm) {
                return new \Application\Storage\Visits($sm->getService('datasource'));
            },

            'purchases.storage' => function($sm) {
                return new \Application\Storage\Purchases($sm->getService('datasource'));
            },

        ));
    }

}