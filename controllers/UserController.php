<?php
require_once('BaseController.php');
require_once('models/User.php');

class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function index() {
        page_require_level(1);
        $all_users = $this->userModel->allJoined();
        return [
            'page_title' => 'Lista de usuarios',
            'all_users' => $all_users
        ];
    }

    public function add() {
        page_require_level(1);
        $groups = find_all('user_groups');
        
        if (isset($_POST['add_user'])) {
            $req_fields = array('full-name', 'username', 'password', 'level');
            validate_fields($req_fields);

            if (empty($GLOBALS['errors'])) {
                if ($this->userModel->create($_POST['full-name'], $_POST['username'], $_POST['password'], $_POST['level'])) {
                    $this->flash('s', "¡La cuenta de usuario ha sido creada! ");
                    $this->redirect('add_user.php', false);
                } else {
                    $this->flash('d', ' ¡Lo sentimos, falló la creación de la cuenta!');
                    $this->redirect('add_user.php', false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('add_user.php', false);
            }
        }

        return [
            'page_title' => 'Agregar usuario',
            'groups' => $groups
        ];
    }

    public function edit() {
        page_require_level(1);
        $id = (int)$_GET['id'];
        $e_user = $this->userModel->find($id);
        $groups = find_all('user_groups');

        if (!$e_user) {
            $this->flash("d", "Missing user id.");
            $this->redirect('users.php');
        }

        if (isset($_POST['update'])) {
            $req_fields = array('name', 'username', 'level');
            validate_fields($req_fields);
            if (empty($GLOBALS['errors'])) {
                if ($this->userModel->update($id, $_POST['name'], $_POST['username'], (int)$_POST['level'])) {
                    $this->flash('s', "Cuenta actualizada ");
                    $this->redirect('edit_user.php?id=' . (int)$e_user['id'], false);
                } else {
                    $this->flash('d', ' Lo sentimos, ¡Fallo la actualización!');
                    $this->redirect('edit_user.php?id=' . (int)$e_user['id'], false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('edit_user.php?id=' . (int)$e_user['id'], false);
            }
        }

        // Change Password logic in the same page
        if (isset($_POST['update-pass'])) {
            $req_fields = array('password');
            validate_fields($req_fields);
            if (empty($GLOBALS['errors'])) {
                if ($this->userModel->updatePassword($id, $_POST['password'])) {
                    $this->flash('s', "Contraseña actualizada ");
                    $this->redirect('edit_user.php?id=' . (int)$e_user['id'], false);
                } else {
                    $this->flash('d', ' Lo sentimos, ¡Fallo la actualización!');
                    $this->redirect('edit_user.php?id=' . (int)$e_user['id'], false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('edit_user.php?id=' . (int)$e_user['id'], false);
            }
        }

        return [
            'page_title' => 'Editar usuario',
            'e_user' => $e_user,
            'groups' => $groups
        ];
    }

    public function delete() {
        page_require_level(1);
        $id = (int)$_GET['id'];
        $user = $this->userModel->find($id);
        if (!$user) {
            $this->flash("d", "ID de usuario faltante.");
            $this->redirect('users.php');
        }
        if ($this->userModel->delete($id)) {
            $this->flash("s", "Usuario eliminado.");
            $this->redirect('users.php');
        } else {
            $this->flash("d", "Se ha producido un error en la eliminación del usuario");
            $this->redirect('users.php');
        }
    }
}
