<?php
require_once __DIR__ . '/database.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    $data = array();
    $operation = $_GET['operation'];
    switch ($operation) {
        case 'delete':
            $todoID = post('Todo_ID');
            $deleteTodo = $db->prepare("DELETE FROM todos WHERE todo_id=:id");
            $delete = $deleteTodo->execute(['id' => $todoID]);
            if ($delete) {
                $data['success'] = "To Do Başarıyla Silindi.";
            } else {
                $data['error'] = "Bir Sorun Oluştu";
            }
            $data['success'] = "Tebrikler, kayıt silindi.";
            break;
        case 'new':
            $todoName = post('newTodoName');
            $todoStatus = post('newTodoStatus');

            if (empty($todoName)) {
                $data['error'] = "Lütfen Boş Alan Bırakmayınız";
            } else {
                if ($todoStatus == "on") {
                    $addTodo = $db->prepare("INSERT INTO todos SET todo_name= :todo, todo_status = :status");
                    $insert = $addTodo->execute([
                        'todo' => $todoName,
                        'status' => "0"
                    ]);
                    if ($insert) {
                        $data['success'] = "To do Başarıyla Eklendi";
                    } else {
                        $data['error'] = "Bir Sorun Oluştu";
                    }
                } else {
                    $addTodo = $db->prepare("INSERT INTO todos SET todo_name= :todo, todo_status = :status");
                    $insert = $addTodo->execute([
                        'todo' => $todoName,
                        'status' => "1"
                    ]);
                    if ($insert) {
                        $data['success'] = "To do Başarıyla Eklendi";

                    } else {
                        $data['error'] = "Bir Sorun Oluştu";
                    }
                }
            }
            break;
        case 'edit':
            $todoID = post('Todo_ID');
            $getTodo = $db->prepare("SELECT * FROM todos WHERE todo_id=:id");
            $getTodo->execute(['id' => $todoID]);
            $rowTodo = $getTodo->fetch(PDO::FETCH_OBJ);

            $data['todoName'] = $rowTodo->todo_name;
            $data['todoStatus'] = $rowTodo->todo_status;
            $data['todoID'] = $rowTodo->todo_id;
            break;
        case 'update':
            $todoName = post('editTodoName');
            $todoStatus = post('editTodoStatus');
            $todoID = post('todoID');

            if (empty($todoName)) {
                $data['error'] = "Lütfen Boş Alan Bırakmayınız";
            } else {
                if ($todoStatus == "on") {
                    $updateTodo = $db->prepare("UPDATE todos SET todo_name= :todo, todo_status = :status WHERE todo_id = :id");
                    $insert = $updateTodo->execute([
                        'todo' => $todoName,
                        'status' => "0",
                        'id' => $todoID
                    ]);
                    if ($insert) {
                        $data['success'] = "To do Başarıyla Güncellendi";
                    } else {
                        $data['error'] = "Bir Sorun Oluştu";
                    }
                } else {
                    $updateTodo = $db->prepare("UPDATE todos SET todo_name= :todo, todo_status = :status WHERE todo_id = :id");
                    $insert = $updateTodo->execute([
                        'todo' => $todoName,
                        'status' => "1",
                        'id' => $todoID
                    ]);
                    if ($insert) {
                        $data['success'] = "To do Başarıyla Güncellendi";
                    } else {
                        $data['error'] = "Bir Sorun Oluştu";
                    }
                }
            }
            break;
    }
    echo json_encode($data);
} else {
    die('Bu sayfaya giriş yetkiniz bulunmamaktadır.');
}
