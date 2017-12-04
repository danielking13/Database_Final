<?php

/**
 * Created by PhpStorm.
 * User: danielking
 * Date: 11/28/17
 * Time: 11:57 PM
 */
class TableModel
{
    private $error = '';
    private $mysqli;
    private $user;

    public function __construct()
    {
        session_start();
        $this->initDatabaseConnection();
//        $this->restoreUser();
    }

    public function __destruct() {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

    public function getError() {
        return $this->error;
    }

    private function initDatabaseConnection() {
        require('dbCredentials.php');
        $this->mysqli = new mysqli($servername, $username, $password, $dbname);
        if ($this->mysqli->connect_error) {
            $this->error = $this->mysqli->connect_error;
        }
    }

//    public function getUser() {
//        return $this->user;
//    }
//
//    private function restoreUser() {
//        if ($loginID = $_SESSION['loginid']) {
//            $this->user = new User();
//            if (!$this->user->load($loginID, $this->mysqli)) {
//                $this->user = null;
//            }
//        }
//    }
//
//    public function logout() {
//        $this->user = null;
//        $_SESSION['loginid'] = '';
//    }

    public function getDataSet() {
        $this->error = '';
        $dataItems = array();

//        if (!$this->user) {
//            $this->error = "User not specified. Unable to get data set";
//            return array($dataItems, $this->error);
//        }

        if (! $this->mysqli) {
            $this->error = "No connection to database.";
            return array($dataItems, $this->error);
        }
//TODO: Remove
//        $stmt = $this->mysqli->prepare("SELECT userId, img, tag FROM data WHERE type = 'TRAIN' ORDER BY id ASC");
//        if (! ($stmt->bind_param("i", $)) ) {
//            $this->error = "Prepare failed: " . $this->mysqli->error;
//            return array($dataItems, $this->error);
//        }
//
//        if (! $stmt->execute() ) {
//            $this->error = "Execute of statement failed: " . $stmt->error;
//            return array($dataItems, $this->error);
//        }
//        if (! ($result = $stmt->get_result()) ) {
//            $this->error = "Getting result failed: " . $stmt->error;
//            return array($dataItems, $this->error);
//        }
//
//        if ($result->num_rows > 0) {
//            while($row = $result->fetch_assoc()) {
//                array_push($dataItems, $row);
//            }
//        }

        $sql = "SELECT userId, img, tag FROM data WHERE type = 'TRAIN' ORDER BY id ASC LIMIT 50";
        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($dataItems, $row);
                }
            }
            $result->close();
        } else {
            $this->error = $this->mysqli->error;
        }
//        return array($tasks, $this->error);

//        $stmt->close();

        return array($dataItems, $this->error);
    }

    public function deleteDataItem($id) {
        $this->error = '';

//        if (!$this->user) {
//            $this->error = "User not specified. Unable to delete task.";
//            return $this->error;
//        }

        if (! $this->mysqli) {
            $this->error = "No connection to database. Unable to delete task.";
            return $this->error;
        }

        if (! $id) {
            $this->error = "No id specified for task to delete.";
            return $this->error;
        }

        $stmt = $this->mysqli->prepare("DELETE FROM data WHERE id = ?");

        if (! ($stmt->bind_param("i", $id)) ) {
            $this->error = "Prepare failed: " . $this->mysqli->error;
            return $this->error;
        }
        if (! $stmt->execute() ) {
            $this->error = "Execute of statement failed: " . $stmt->error;
            return $this->error;
        }

        $stmt->close();

        return $this->error;
    }

    /*
     * @param $data is the POST array with all our current data items
     */
    public function updateDataItem($data) {
        $this->error = '';

//        if (!$this->user) {
//            $this->error = "User not specified. Unable to update task.";
//            return $this->error;
//        }

        if (! $this->mysqli) {
            $this->error = "No connection to database. Unable to update task.";
            return $this->error;
        }

        $id = $data['id'];
        if (! $id) {
            $this->error = "No id specified for task to update.";
            return $this->error;
        }

        $tag = $data['tag'];
        if (! $tag) {
            $this->error = "No title found for task to update. A tag is required.";
            return $this->error;
        }

        $stmt = $this->mysqli->prepare("UPDATE data SET tag = ? WHERE id = ?");

        if (! ($stmt->bind_param("ii", $tag, $id)) ) {
            $this->error = "Prepare failed: " . $this->mysqli->error;
            return $this->error;
        }
        if (! $stmt->execute() ) {
            $this->error = "Execute of statement failed: " . $stmt->error;
            return $this->error;
        }

        $stmt->close();

        return $this->error;
    }
}

?>