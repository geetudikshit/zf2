<?php
// module/Admin/src/Admin/Model/AdminTable.php:
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;

class AdminTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getAdmin($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveAdmin(Admin $admin)
    {
        $data = array(
            'artist' => $admin->artist,
            'title'  => $admin->title,
        );

        $id = (int)$admin->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAdmin($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteAdmin($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}