<?php
include '../config/connection.php';

class Tasks
{
    private $conn;

    public function __construct()
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function addedTask()
    {
        if (isset($_POST['added_task_btn'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $due_date = $_POST['due_date'];

            $query = "INSERT INTO tasks (title, description, due_date) VALUES (:title, :description, :due_date)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([
                'title' => $title,
                'description' => $description,
                'due_date' => $due_date,
            ]);

            if ($result) {
                $_SESSION['status'] = "Added Task Successfully";
                header("Location: ../views/listTask.php");
            } else {
                $_SESSION['status'] = "Added Task Failed";
                header("Location: ../views/addedTask.php");
            }
        }
    }

    public function displayTask()
    {
        $query = "SELECT * FROM tasks";
        $sth = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        return $sth;
    }

    public function getTaskById($id)
    {
        $query = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTask()
    {
        if (isset($_POST['update_task_btn'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $due_date = $_POST['due_date'];
            $status = $_POST['status'];
            $id = $_POST['id'];

            
            $query = "UPDATE tasks SET title = :title, description = :description, due_date = :due_date, status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt) {
                $_SESSION['status'] = "Update Task Successfully";
                header("Location: ../views/listTask.php");
            } else {
                $_SESSION['status'] = "Update Task Failed";
                header("Location: ../views/updateTask.php");
            }
        }
    }

    public function deleteTaskById()
    {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']); // Pastikan ID adalah integer

            $query = "DELETE FROM tasks WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['status'] = "Delete Task Successfully";
            } else {
                $_SESSION['status'] = "Delete Task Failed";
            }
        } else {
            $_SESSION['status'] = "Invalid Task ID";
        }

        header("Location: ../views/listTask.php");
        exit();
    }


}

$code = new Tasks();
$code->addedTask();
$code->updateTask();
