<?php declare(strict_types=1);
namespace Diva\Form;

use Laminas\Form\Fieldset;
use Omeka\Form\Element\PropertySelect;

class SettingsFieldset extends Fieldset
{
    protected $label = 'Diva IIIF viewer'; // @translate

    public function init(): void
    {
        $this
            ->add([
                'name' => 'diva_manifest_property',
                'type' => PropertySelect::class,
                'options' => [
                    'label' => 'Manifest property', // @translate
                    'info' => 'The property supplying the manifest URL for the viewer, for example "dcterms:hasFormat".', // @translate
                    'empty_option' => '',
                    'term_as_value' => true,
                ],
                'attributes' => [
                    'id' => 'diva_manifest_property',
                    'class' => 'chosen-select',
                    'data-placeholder' => 'Select a property…', // @translate
                ],
            ]);
    }
}
