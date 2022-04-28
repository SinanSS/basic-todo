const SITE_URL = "http://siteadresi.com/";

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
$(function () {
    //Delete To Do
    $('.deleteTodoBtn').click(function (e) {
        e.preventDefault();
        const todoID = $(this).attr('data-id');
        Swal.fire({
            title: 'Emin misiniz?',
            text: 'Bu veriyi silmek istediğinize emin misiniz!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Evet',
            cancelButtonText: 'Hayır'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: SITE_URL + "system/ajax.php?operation=delete",
                    data: {"Todo_ID": todoID},
                    dataType: "json",
                    success: function (data) {
                        if (data.success){
                            Toast.fire({icon: 'success', title: data.success});
                            $('#Todo_' + todoID).remove();
                        } else {
                            Toast.fire({icon: 'error', title: data.error});
                        }
                    }
                });
            }
        });

    });
    //Edit To Do
    $('.editTodoBtn').click(function (e) {
        e.preventDefault();
        const todoID = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: SITE_URL + "system/ajax.php?operation=edit",
            data: {"Todo_ID": todoID},
            dataType: "json",
            success: function (data) {
                $('#editTodoName').val(data.todoName);
                $('#editTodoID').val(data.todoID);
                $('#editTodo').modal('show');
                if (data.todoStatus == 0){
                    $('#editTodoStatus').prop('checked', true);
                } else {
                    $('#editTodoStatus').prop('checked', false);
                }
            }
        });
    });

    $('#editTodoForm').on('submit', function (e){
        e.preventDefault();
        let formData = $('#editTodoForm').serialize();

        $.ajax({
            type: "POST",
            url: SITE_URL + "system/ajax.php?operation=update",
            data: formData,
            dataType: "json",
            success: function (data) {
                if (data.success){
                    Swal.fire({
                        title: data.success,
                        text: 'Lütfen Bekleyin!',
                        icon: 'success',
                        showConfirmButton: false
                    });
                    $('#editTodoForm').trigger("reset");
                    $('#editTodo').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    Toast.fire({icon: 'error', title: data.error});
                    $('#editTodo').modal('hide');
                }
            }
        });
    });
    //New To Do
    $('#newTodoForm').on('submit', function (e){
        e.preventDefault();
        let formData = $('#newTodoForm').serialize();
        $.ajax({
            type: "POST",
            url: SITE_URL + "system/ajax.php?operation=new",
            data: formData,
            dataType: "json",
            success: function (data) {
                if (data.success){
                    Swal.fire({
                        title: data.success,
                        text: 'Lütfen Bekleyin!',
                        icon: 'success',
                        showConfirmButton: false
                    });
                    $('#newTodoForm').trigger("reset");
                    $('#addTodo').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    Toast.fire({icon: 'error', title: data.error});
                    $('#addTodo').modal('hide');
                }
            }
        });
    });

});
