<?php
require_once('BaseController.php');
require_once('models/Sale.php');
require_once('models/Product.php');

class SaleController extends BaseController {
    private $saleModel;
    private $productModel;

    public function __construct() {
        parent::__construct();
        $this->saleModel = new Sale();
        $this->productModel = new Product();
    }

    public function index() {
        page_require_level(3);
        $sales = $this->saleModel->allJoined();
        return [
            'page_title' => 'Lista de ventas',
            'sales' => $sales
        ];
    }

    public function add() {
        page_require_level(3);
        if (isset($_POST['add_sale'])) {
            $req_fields = array('s_id', 'quantity', 'price', 'total', 'date');
            validate_fields($req_fields);

            if (empty($GLOBALS['errors'])) {
                $data = [
                    'product_id' => $_POST['s_id'],
                    'qty' => $_POST['quantity'],
                    'price' => $_POST['total'],
                    'date' => make_date()
                ];

                if ($this->saleModel->create($data)) {
                    $this->flash('s', "Sale added. ");
                    $this->redirect('add_sale.php', false);
                } else {
                    $this->flash('d', ' Sorry failed to add!');
                    $this->redirect('add_sale.php', false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('add_sale.php', false);
            }
        }

        return [
            'page_title' => 'Add Sale'
        ];
    }

    public function edit() {
        page_require_level(3);
        $id = (int)$_GET['id'];
        $sale = $this->saleModel->find($id);

        if (!$sale) {
            $this->flash("d", "Falta el ID del producto.");
            $this->redirect('sales.php');
        }

        $product = $this->productModel->find($sale['product_id']);

        if (isset($_POST['update_sale'])) {
            $req_fields = array('title', 'quantity', 'price', 'total', 'date');
            validate_fields($req_fields);

            if (empty($GLOBALS['errors'])) {
                $data = [
                    'product_id' => $product['id'],
                    'qty' => $_POST['quantity'],
                    'price' => $_POST['total'],
                    'date' => date("Y-m-d", strtotime($_POST['date']))
                ];

                if ($this->saleModel->update($id, $data)) {
                    $this->flash('s', "Venta actualizada.");
                    $this->redirect('edit_sale.php?id=' . $id, false);
                } else {
                    $this->flash('d', ' ¡Lo sentimos, falló la actualización!');
                    $this->redirect('sales.php', false);
                }
            } else {
                $this->flash("d", $GLOBALS['errors']);
                $this->redirect('edit_sale.php?id=' . $id, false);
            }
        }

        return [
            'page_title' => 'Editar venta',
            'sale' => $sale,
            'product' => $product
        ];
    }

    public function delete() {
        page_require_level(3);
        $id = (int)$_GET['id'];
        $sale = $this->saleModel->find($id);
        if (!$sale) {
            $this->flash("d", "ID de la venta faltante.");
            $this->redirect('sales.php');
        }
        if ($this->saleModel->delete($id)) {
            $this->flash("s", "Venta eliminada.");
            $this->redirect('sales.php');
        } else {
            $this->flash("d", "Eliminación falló.");
            $this->redirect('sales.php');
        }
    }

    public function daily() {
        page_require_level(3);
        $year  = date('Y');
        $month = date('m');
        $sales = $this->saleModel->daily($year, $month);
        return [
            'page_title' => 'Daily Sales',
            'sales' => $sales
        ];
    }

    public function monthly() {
        page_require_level(3);
        $year = date('Y');
        $sales = $this->saleModel->monthly($year);
        return [
            'page_title' => 'Monthly Sales',
            'sales' => $sales
        ];
    }
}
