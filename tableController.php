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

        private $action = '';
        private $message = '';
        private $data = array();

        public function __construct()
        {
            $this->model = new TableModel();
            $this->views = new TableView();
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

            //handle deletes and updates of page
            switch($this->action) {
                case 'delete':
                    $this->handleDelete();
                    break;
                case 'update':
                    $this->handleUpdate();
                    break;
                default:
                    //Do nothing
            }

            //generate view
            list($items, $error) = $this->model->getDataSet();
            if($error) {
                $this->message = $error;
            }
            print $this->views->tableView($items, $this->message);
        }

        private function handleDelete() {

            if ($error = $this->model->deleteDataItem($_POST['id'])) {
                $this->message = $error;
            }
        }

        private function handleUpdate() {

            if ($error = $this->model->updateDataItem($_POST)) {
                $this->message = $error;
                $this->data = $_POST;
                return;
            }
        }

    }
?>