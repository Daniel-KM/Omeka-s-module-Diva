<?php

namespace Diva;

if (!class_exists(\Generic\AbstractModule::class)) {
    require file_exists(dirname(__DIR__) . '/Generic/AbstractModule.php')
        ? dirname(__DIR__) . '/Generic/AbstractModule.php'
        : __DIR__ . '/src/Generic/AbstractModule.php';
}

use Generic\AbstractModule;
use Diva\Form\ConfigForm;
use Omeka\Module\Exception\ModuleCannotInstallException;
use Omeka\Module\Manager as ModuleManager;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Renderer\PhpRenderer;

class Module extends AbstractModule
{
    const NAMESPACE = __NAMESPACE__;

    public function onBootstrap(MvcEvent $event)
    {
        parent::onBootstrap($event);

        $acl = $this->getServiceLocator()->get('Omeka\Acl');
        $acl->allow(null, ['Diva\Controller\Player']);
    }

    public function attachListeners(SharedEventManagerInterface $sharedEventManager)
    {
        /*
        $sharedEventManager->attach(
            'Omeka\Controller\Site\Item',
            'view.browse.after',
            [$this, 'handleViewBrowseAfterItem']
        );

        $sharedEventManager->attach(
            'Omeka\Controller\Site\ItemSet',
            'view.browse.after',
            [$this, 'handleViewBrowseAfterItemSet']
        );
        */

        $sharedEventManager->attach(
            'Omeka\Controller\Site\Item',
            'view.show.after',
            [$this, 'handleViewShowAfterItem']
        );

        $sharedEventManager->attach(
            \Omeka\Form\SiteSettingsForm::class,
            'form.add_elements',
            [$this, 'handleSiteSettings']
        );
        $sharedEventManager->attach(
            \Omeka\Form\SiteSettingsForm::class,
            'form.add_input_filters',
            [$this, 'handleSiteSettingsFilters']
        );
    }

    public function getConfigForm(PhpRenderer $renderer)
    {
        $services = $this->getServiceLocator();
        $config = $services->get('Config');
        $settings = $services->get('Omeka\Settings');
        $form = $services->get('FormElementManager')->get(ConfigForm::class);

        $defaultSettings = $config[strtolower(__NAMESPACE__)]['config'];
        $data = $this->prepareDataToPopulate($settings, $defaultSettings);

        $view = $renderer;
        $html = '<p>';
        $html .= $this->iiifServerIsActive()
            ? $view->translate('The IIIF Server is active, so when no url is set, the viewer will use the standard routes.') // @translate
            : ($view->translate('The IIIF Server is not active, so when no url is set, the viewer won’t be displayed.') // @translate
                . ' ' . $view->translate('Furthermore, the Diva Viewer can’t display lists of items.')); // @translate
        $html .= '</p>';
        $html .= '<p>'
            . $view->translate('The viewer itself can be basically configured in settings of each site, or in the theme.') // @translate
            . '</p>';

        $form->init();
        $form->setData($data);
        $html .= $renderer->formCollection($form);
        return $html;
    }

    public function handleSiteSettingsFilters(Event $event)
    {
        $inputFilter = $event->getParam('inputFilter');
        $inputFilter->get('diva')->add([
            'name' => 'diva_append_item_set_browse',
            'required' => false,
        ]);
        $inputFilter->get('diva')->add([
            'name' => 'diva_append_item_browse',
            'required' => false,
        ]);
    }

    public function handleViewBrowseAfterItem(Event $event)
    {
        $view = $event->getTarget();
        $services = $this->getServiceLocator();
        $config = $services->get('Config');
        $siteSettings = $services->get('Omeka\Settings\Site');
        // Note: there is no item-set show, but a special case for items browse.
        $isItemSetShow = (bool) $services->get('Application')->getMvcEvent()->getRouteMatch()->getParam('item-set-id');
        if ($isItemSetShow) {
            if ($siteSettings->get(
                'diva_append_item_set_show',
                $config['diva']['site_settings']['diva_append_item_set_show']
            )) {
                echo $view->diva($view->itemSet);
            }
        } elseif ($this->iiifServerIsActive()
            && $siteSettings->get(
                'diva_append_item_browse',
                $config['diva']['site_settings']['diva_append_item_browse']
            )
        ) {
            echo $view->diva($view->items);
        }
    }

    public function handleViewBrowseAfterItemSet(Event $event)
    {
        if (!$this->iiifServerIsActive()) {
            return;
        }

        $view = $event->getTarget();
        $services = $this->getServiceLocator();
        $config = $services->get('Config');
        $siteSettings = $services->get('Omeka\Settings\Site');
        if ($siteSettings->get(
            'diva_append_item_set_browse',
            $config['diva']['site_settings']['diva_append_item_set_browse']
        )) {
            echo $view->diva($view->itemSets);
        }
    }

    public function handleViewShowAfterItem(Event $event)
    {
        $view = $event->getTarget();
        $services = $this->getServiceLocator();
        $config = $services->get('Config');
        $siteSettings = $services->get('Omeka\Settings\Site');
        if ($siteSettings->get(
            'diva_append_item_show',
            $config['diva']['site_settings']['diva_append_item_show']
        )) {
            echo $view->diva($view->item);
        }
    }

    protected function preInstall()
    {
        $js = __DIR__ . '/asset/vendor/diva/diva.js';
        if (!file_exists($js)) {
            $t = $this->getServiceLocator()->get('MvcTranslator');
            throw new ModuleCannotInstallException(
                $t->translate('The Diva library should be installed.') // @translate
                    . ' ' . $t->translate('See module’s installation documentation.') // @translate
            );
        }
    }

    protected function iiifServerIsActive()
    {
        static $iiifServerIsActive;

        if (is_null($iiifServerIsActive)) {
            $module = $this->getServiceLocator()
                ->get('Omeka\ModuleManager')
                ->getModule('IiifServer');
            $iiifServerIsActive = $module && $module->getState() === ModuleManager::STATE_ACTIVE;
        }
        return $iiifServerIsActive;
    }
}
