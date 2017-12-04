<?php
/**
 * Created by PhpStorm.
 * User: danielking
 * Date: 11/28/17
 * Time: 4:52 PM
 */
    require('TableModel.php');
    require('TableView.php');

    class TableController {
        private $model;
        private $views;

        private $view = '';
        private $action = '';
        private $message = '';
        private $data = array();

        public function __construct()
        {
            $this->model = new TableModel();
            $this->views = new TableView();

            //TODO: probably default it to home page
            $this->view = $_GET['view'] ? $_GET['view'] : 'default';

            $this->action = $_POST['action'];
        }

        public function __destruct()
        {
            $this->views = null;
        }

        public function run()
        {
            if ($error = $this->model->getError()) {
                print $this->views->errorView($error);
                exit;
            }

//            $this->processLogout();

            //handle deletes and updates of page
            switch($this->action) {
                case 'delete':
                    $this->handleDelete();
                    break;
                case 'update':
                    $this->handleUpdate();
                    break;
                default:
//                    $this->verifyLogin();
            }

            //generate view
            switch ($this->view) {
                case 'loginform':
                    print $this->views->loginView($this->data);
                    break;
                case 'updateForm':
                    print $this->views->updateView($this->data);
                    break;
                case 'default': //aka table view
                    list($items, $error) = $this->model->getDataSet();
                    if($error) {
                        $this->message = $error;
                    }
                    print $this->views->tableView($items, $this->message);
            }
        }
        //TODO: check if this method is needed or if I need to change it
//        private function verifyLogin() {
//            if (! $this->model->getUser()) {
//                $this->view = 'loginform';
//                return false;
//            } else {
//                return true;
//            }
//        }
        //TODO: same here
//        private function processLogout() {
//            if ($_GET['logout']) {
//                $this->model->logout();
//            }
//        }

        private function handleDelete() {
//            if (!$this->verifyLogin()) return;

            if ($error = $this->model->deleteDataItem($_POST['id'])) {
                $this->message = $error;
            }
            $this->view = 'table';
        }

        private function handleUpdate() {
//            if (!$this->verifyLogin()) return;

            if ($_POST['cancel']) {
                $this->view = 'table';
                return;
            }

            if ($error = $this->model->updateDataItem($_POST)) {
                $this->message = $error;
                $this->view = 'updateForm';
                $this->data = $_POST;
                return;
            }

            $this->view = 'table';
        }

    }
?>