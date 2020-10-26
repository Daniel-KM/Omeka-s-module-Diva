<?php declare(strict_types=1);

namespace Diva\Service\ViewHelper;

use Diva\View\Helper\Diva;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

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
