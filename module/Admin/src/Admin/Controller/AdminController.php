<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\Admin;
use Admin\Form\AdminForm;
use Admin\Form\LoginForm;

class AdminController extends AbstractActionController
{
    protected $adminTable;

    public function indexAction()
    {
        $form = new LoginForm();
        $form->get('submit')->setValue('Login');
        
        $this->layout('layout/login_layout.phtml');
        $request = $this->getRequest();
        if ($request->isPost()) {
            
        }
        return array('form' => $form);
        
        //return new ViewModel(array(
        //    'admins' => $this->getAdminTable()->fetchAll(),
        //));
    }

    public function addAction()
    {
        $form = new AdminForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $admin = new Admin();
            $form->setInputFilter($admin->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $admin->exchangeArray($form->getData());
                $this->getAdminTable()->saveAdmin($admin);

                // Redirect to list of admins
                return $this->redirect()->toRoute('admin');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin', array(
                'action' => 'add'
            ));
        }
        $admin = $this->getAdminTable()->getAdmin($id);

        $form  = new AdminForm();
        $form->bind($admin);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($admin->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAdminTable()->saveAdmin($form->getData());

                // Redirect to list of admins
                return $this->redirect()->toRoute('admin');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAdminTable()->deleteAdmin($id);
            }

            // Redirect to list of admins
            return $this->redirect()->toRoute('admin');
        }

        return array(
            'id'    => $id,
            'admin' => $this->getAdminTable()->getAdmin($id)
        );
    }

    public function getAdminTable()
    {
        if (!$this->adminTable) {
            $sm = $this->getServiceLocator();
            $this->adminTable = $sm->get('Admin\Model\AdminTable');
        }
        return $this->adminTable;
    }
}