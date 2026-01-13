<?php
require_once('BaseController.php');
require_once('models/Category.php');

class CategoryController extends BaseController {
    private $categoryModel;

    public function __construct() {
        parent::__construct();
        $this->categoryModel = new Category();
    }

    public function index() {
        page_require_level(1);
        $all_categories = $this->categoryModel->all();
        
        if (isset($_POST['add_cat'])) {
            $this->add();
        }

        return [
            'page_title' => 'Todas las categorías',
            'all_categories' => $all_categories
        ];
    }

    private function add() {
        $req_field = array('categorie-name');
        validate_fields($req_field);
        
        if (empty($GLOBALS['errors'])) {
            if ($this->categoryModel->create($_POST['categorie-name'])) {
                $this->flash("s", "Categoría agregada exitosamente");
                $this->redirect('categorie.php', false);
            } else {
                $this->flash("d", "Lo sentimos, falló el registro.");
                $this->redirect('categorie.php', false);
            }
        } else {
            $this->flash("d", $GLOBALS['errors']);
            $this->redirect('categorie.php', false);
        }
    }

    public function edit() {
        page_require_level(1);
        $id = (int)$_GET['id'];
        $categorie = $this->categoryModel->find($id);
        
        if (!$categorie) {
            $this->flash("d", "ID de categoría faltante.");
            $this->redirect('categorie.php');
        }

        if (isset($_POST['edit_cat'])) {
            $req_field = array('categorie-name');
            validate_fields($req_field);
            
            if (empty($GLOBALS['errors'])) {
                if ($this->categoryModel->update($id, $_POST['categorie-name'])) {
                    $this->flash("s", "Categoría actualizada exitosamente");
                    $this->redirect('categorie.php', false);
                } else {
                    $this->flash("d", "Lo sentimos, falló la actualización.");
                    $this->redirect('categorie.php', false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('categorie.php', false);
            }
        }

        return [
            'page_title' => 'Editar categoría',
            'categorie' => $categorie
        ];
    }

    public function delete() {
        page_require_level(1);
        $id = (int)$_GET['id'];
        $categorie = $this->categoryModel->find($id);
        
        if (!$categorie) {
            $this->flash("d", "ID de categoría faltante.");
            $this->redirect('categorie.php');
        }

        if ($this->categoryModel->delete($id)) {
            $this->flash("s", "Categoría eliminada.");
            $this->redirect('categorie.php');
        } else {
            $this->flash("d", "Falló la eliminación.");
            $this->redirect('categorie.php');
        }
    }
}
