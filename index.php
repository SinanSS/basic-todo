<?php
require_once __DIR__ . '/system/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="açıklama">
    <meta name="keywords" content="etiket">
    <meta name="author" content="SinanSS">

    <title>TODO</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link
            href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
            rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/css/main.min.css" rel="stylesheet">
</head>

<body>
<div class="app menu-off-canvas align-content-stretch d-flex flex-wrap">

    <div class="app-container">

        <div class="app-content">
            <div class="content-wrapper">
                <div class="container justify-content-center">

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="page">
                                <h3>PHP ile Basit To Do Uygulaması</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#addTodo"><i class="material-icons">add</i>Yeni
                            </button>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="table-responsive-md">
                                        <table class="table" id="todoList">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Yapılacak</th>
                                                <th scope="col">Durum</th>
                                                <th scope="col">İşlem</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $getTodos = $db->prepare("SELECT * FROM todos ORDER BY todo_id DESC");
                                            $getTodos->execute();
                                            $listTodos = $getTodos->fetchAll(PDO::FETCH_OBJ);
                                            $i = 1;
                                            foreach ($listTodos as $row) { ?>
                                                <tr id="Todo_<?= $row->todo_id ?>">
                                                    <th scope="row"><?= $i ?></th>
                                                    <td><?= $row->todo_name ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row->todo_status == 1) {
                                                            echo '<span class="badge badge-danger">Yapılmadı</span>';
                                                        } elseif ($row->todo_status == 0) {
                                                            echo '<span class="badge badge-success">Yapıldı</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                class="btn btn-sm btn-danger btn-style-light deleteTodoBtn"
                                                                data-id="<?= $row->todo_id ?>">
                                                            <i class="material-icons">delete</i>Sil
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-sm btn-info btn-style-light editTodoBtn"
                                                                data-id="<?= $row->todo_id ?>">
                                                            <i class="material-icons">edit</i>Düzenle
                                                        </button>
                                                    </td>
                                                </tr>

                                                <?php
                                                $i++;
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="addTodo" tabindex="-1" aria-labelledby="addTodoTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTodoTitle">To Do Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="newTodoForm">
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="form-label">Yapılacak</label>
                        <div class="col-sm-12">
                            <input type="text" name="newTodoName" id="newTodoName" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="newTodoStatus" id="newTodoStatus">
                                Yapıldı olarak işaretle
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="newTodoBtn" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editTodo" tabindex="-1" aria-labelledby="addTodoTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTodoTitle">To Do Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="editTodoForm">
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="form-label">Yapılacak</label>
                        <div class="col-sm-12">
                            <input type="text" name="editTodoName" id="editTodoName" placeholder=""
                                   class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="editTodoStatus"
                                       id="editTodoStatus">
                                Yapıldı olarak işaretle
                            </label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="todoID" value="" id="editTodoID">
                <div class="modal-footer">
                    <button type="submit" name="editBtnModal" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalert.min.js"></script>

<script src="assets/js/main.min.js"></script>
<script src="assets/js/app.js"></script>
</body>

</html>
