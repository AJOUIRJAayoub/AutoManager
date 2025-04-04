<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Piece.php';

class PieceController {
    private $model;

    public function __construct() {
        $this->model = new Piece();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'list';

        switch ($action) {
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->model->add(
                        $_POST['nom'],
                        $_POST['description'],
                        $_POST['prix'],
                        $_POST['stock'],
                        $_POST['category_id'] ?? null
                    );
                    header('Location: index.php');
                } else {
                    $piece = null;
                    $categories = $this->model->getCategories();
                    include __DIR__ . '/../views/piece_form.php';
                }
                break;

            case 'edit':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->model->update(
                        $_POST['id'],
                        $_POST['nom'],
                        $_POST['description'],
                        $_POST['prix'],
                        $_POST['stock'],
                        $_POST['category_id'] ?? null
                    );
                    header('Location: index.php');
                } else {
                    $piece = $this->model->get($_GET['id']);
                    $categories = $this->model->getCategories();
                    include __DIR__ . '/../views/piece_form.php';
                }
                break;

            case 'delete':
                $this->model->delete($_GET['id']);
                header('Location: index.php');
                break;

            default:
                $pieces = $this->model->getAll();
                include __DIR__ . '/../views/piece_list.php';
                break;
        }
    }
}