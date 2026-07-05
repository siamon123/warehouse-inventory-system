<?php
require_once('BaseController.php');
require_once('models/Product.php');

class ProductController extends BaseController {
    private $productModel;

    public function __construct() {
        parent::__construct();
        $this->productModel = new Product();
    }

    public function index() {
        page_require_level(2);
        $products = $this->productModel->allJoined();
        return [
            'page_title' => 'Lista de productos',
            'products' => $products
        ];
    }

    public function add() {
        page_require_level(2);
        $all_categories = find_all('categories');
        $all_photo = find_all('media');

        if (isset($_POST['add_product'])) {
            $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
            validate_fields($req_fields);

            if (empty($GLOBALS['errors'])) {
                $data = [
                    'name' => $_POST['product-title'],
                    'categorie_id' => $_POST['product-categorie'],
                    'quantity' => $_POST['product-quantity'],
                    'buy_price' => $_POST['buying-price'],
                    'sale_price' => $_POST['saleing-price'],
                    'media_id' => (empty($_POST['product-photo']) ? 0 : $_POST['product-photo'])
                ];

                if ($this->productModel->create($data)) {
                    $this->flash('s', "Producto agregado ");
                    $this->redirect('add_product.php', false);
                } else {
                    $this->flash('d', ' ¡Lo sentimos, falló el registro!');
                    $this->redirect('product.php', false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('add_product.php', false);
            }
        }

        return [
            'page_title' => 'Agregar producto',
            'all_categories' => $all_categories,
            'all_photo' => $all_photo
        ];
    }

    public function edit() {
        page_require_level(2);
        $id = (int)$_GET['id'];
        $product = $this->productModel->find($id);
        $all_categories = find_all('categories');
        $all_photo = find_all('media');

        if (!$product) {
            $this->flash("d", "Falta el ID del producto.");
            $this->redirect('product.php');
        }

        if (isset($_POST['product'])) {
            $req_fields = array('product-title', 'product-categorie', 'product-quantity', 'buying-price', 'saleing-price');
            validate_fields($req_fields);

            if (empty($GLOBALS['errors'])) {
                $data = [
                    'name' => $_POST['product-title'],
                    'categorie_id' => $_POST['product-categorie'],
                    'quantity' => $_POST['product-quantity'],
                    'buy_price' => $_POST['buying-price'],
                    'sale_price' => $_POST['saleing-price'],
                    'media_id' => (empty($_POST['product-photo']) ? 0 : $_POST['product-photo'])
                ];

                if ($this->productModel->update($id, $data)) {
                    $this->flash('s', "Producto actualizado ");
                    $this->redirect('product.php', false);
                } else {
                    $this->flash('d', ' ¡Lo sentimos, falló la actualización!');
                    $this->redirect('edit_product.php?id=' . $id, false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('edit_product.php?id=' . $id, false);
            }
        }

        return [
            'page_title' => 'Editar producto',
            'product' => $product,
            'all_categories' => $all_categories,
            'all_photo' => $all_photo
        ];
    }

    public function delete() {
        page_require_level(2);
        $id = (int)$_GET['id'];
        $product = $this->productModel->find($id);
        if (!$product) {
            $this->flash("d", "ID del producto faltante.");
            $this->redirect('product.php');
        }
        if ($this->productModel->delete($id)) {
            $this->flash("s", "Producto eliminado.");
            $this->redirect('product.php');
        } else {
            $this->flash("d", "Eliminación falló.");
            $this->redirect('product.php');
        }
    }
}
