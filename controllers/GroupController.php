<?php
require_once('BaseController.php');
require_once('models/Group.php');

class GroupController extends BaseController {
    private $groupModel;

    public function __construct() {
        parent::__construct();
        $this->groupModel = new Group();
    }

    public function index() {
        page_require_level(1);
        $all_groups = $this->groupModel->all();

        return [
            'page_title' => 'Lista de grupos',
            'all_groups' => $all_groups
        ];
    }

    public function add() {
        page_require_level(1);
        if (isset($_POST['add'])) {
            $req_fields = array('group-name', 'group-level');
            validate_fields($req_fields);

            if ($this->groupModel->findByName($_POST['group-name'])) {
                $this->flash('d', '<b>Sorry!</b> Entered Group Name already in database!');
                $this->redirect('add_group.php', false);
            } elseif ($this->groupModel->findByLevel($_POST['group-level'])) {
                $this->flash('d', '<b>Sorry!</b> Entered Group Level already in database!');
                $this->redirect('add_group.php', false);
            }

            if (empty($GLOBALS['errors'])) {
                if ($this->groupModel->create($_POST['group-name'], $_POST['group-level'], $_POST['status'])) {
                    $this->flash('s', "Group has been created! ");
                    $this->redirect('add_group.php', false);
                } else {
                    $this->flash('d', ' Sorry failed to create Group!');
                    $this->redirect('add_group.php', false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('add_group.php', false);
            }
        }

        return [
            'page_title' => 'Add Group'
        ];
    }

    public function edit() {
        page_require_level(1);
        $id = (int)$_GET['id'];
        $e_group = $this->groupModel->find($id);

        if (!$e_group) {
            $this->flash("d", "Missing Group id.");
            $this->redirect('group.php');
        }

        if (isset($_POST['update'])) {
            $req_fields = array('group-name', 'group-level');
            validate_fields($req_fields);

            if (empty($GLOBALS['errors'])) {
                if ($this->groupModel->update($id, $_POST['group-name'], $_POST['group-level'], $_POST['status'])) {
                    $this->flash('s', "Group has been updated! ");
                    $this->redirect('edit_group.php?id=' . (int)$e_group['id'], false);
                } else {
                    $this->flash('d', ' Sorry failed to update Group!');
                    $this->redirect('edit_group.php?id=' . (int)$e_group['id'], false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('edit_group.php?id=' . (int)$e_group['id'], false);
            }
        }

        return [
            'page_title' => 'Edit Group',
            'e_group' => $e_group
        ];
    }

    public function delete() {
        page_require_level(1);
        $id = (int)$_GET['id'];
        $group = $this->groupModel->find($id);

        if (!$group) {
            $this->flash("d", "Missing Group id.");
            $this->redirect('group.php');
        }

        if ($this->groupModel->delete($id)) {
            $this->flash("s", "Group has been deleted.");
            $this->redirect('group.php');
        } else {
            $this->flash("d", "Group deletion failed.");
            $this->redirect('group.php');
        }
    }
}
