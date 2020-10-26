<?php declare(strict_types=1);

namespace Diva\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Omeka\Mvc\Exception\NotFoundException;

class PlayerController extends AbstractActionController
{
    /**
     * Forward to the 'play' action
     *
     * @see self::playAction()
     */
    public function indexAction(): void
    {
        $params = $this->params()->fromRoute();
        $params['action'] = 'play';
        return $this->forward()->dispatch(__CLASS__, $params);
    }

    public function playAction()
    {
        $id = $this->params('id');
        if (empty($id)) {
            throw new NotFoundException;
        }

        // Map iiif resources with Omeka Classic and Omeka S records.
        $matchingResources = [
            'item' => 'items',
            'items' => 'items',
            'item-set' => 'item_sets',
            'item-sets' => 'item_sets',
            'item_set' => 'item_sets',
            'item_sets' => 'item_sets',
            'collection' => 'item_sets',
            'collections' => 'item_sets',
        ];
        $resourceName = $this->params('resourcename');
        if (!isset($matchingResources[$resourceName])) {
            throw new NotFoundException;
        }
        $resourceName = $matchingResources[$resourceName];

        $response = $this->api()->read($resourceName, $id);
        $resource = $response->getContent();
        if (empty($resource)) {
            throw new NotFoundException;
        }

        $view = new ViewModel([
            'resource' => $resource,
        ]);
        return $view
            ->setTerminal(true);
    }
}
