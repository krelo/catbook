<?php

namespace Cat\Form;

use Zend\Form\Form;

class CatForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('cat');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'name' => 'race',
            'type' => 'text',
            'options' => [
                'label' => 'Race',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
        $this->add([
            'name' => 'owner_id',
            'type' => 'hidden',
        ]);
    }
}