<?php
// module/Admin/src/Admin/Form/AdminForm.php:
namespace Admin\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('admin');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control top',
                'placeholder' => 'Username',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control bottom',
                'placeholder' => 'Password',
            ),
        ));
       $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'remember',
            'options' => array(
                'checked_value' => 'good',
                'unchecked_value' => 'bad'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'class' => 'btn btn-lg btn-primary btn-block',
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}