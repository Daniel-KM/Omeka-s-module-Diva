<?php

namespace Diva\Service\ViewHelper;

use Interop\Container\ContainerInterface;
use Diva\View\Helper\Mirador;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Service factory for the Diva view helper.
 */
class DivaFactory implements FactoryInterface
{
    /**
     * Create and return the Diva view helper
     *
     * @return Diva
     */
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        $currentTheme = $serviceLocator->get('Omeka\Site\ThemeManager')
            ->getCurrentTheme();
        return new Diva($currentTheme);
    }
}
