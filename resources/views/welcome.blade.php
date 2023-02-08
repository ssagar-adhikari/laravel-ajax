<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container">

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary" id="add_todo">
            Add Todo
        </button>
        <table class="table table-bordered">
            <thead>
                <th>Sr.No.</th>
                <th>Name</th>
                <th>Action</th>
            </thead>
            <tbody id="list_todo">
                @foreach ($todos as $todo)
                    <tr id="row_todo_{{ $todo->id }}">
                        <td>{{ $todo->id }}</td>
                        <td>{{ $todo->name }}</td>
                        <td> <button type="button" id="edit_todo" data-id="{{ $todo->id }}"
                                class="btn btn-sm btn-info ml-1">Edit</button>
                            <button type="button" id="delete_todo" data-id="{{ $todo->id }}"
                                class="btn btn-sm btn-danger mr-1">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- The Modal -->
        <div class="modal" id="modal_todo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form_todo" action="">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <input type="text" name="name" id="name_todo" class="form-control"
                                placeholder="Enter Todo .....">
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Submit</button>
                            <button type="button" class="btn btn-danger">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                }
            })
        });
        $("#add_todo").on('click', function() {
            $("#form-todo").trigger('reset');
            $("#modal_title").html('Add Todo');
            $("#modal_todo").modal('show');
        });

        //Edit Button
        $("body").on('click', '#edit_todo', function() {
            var id = $(this).data('id'); //
            $.get('todos/' + id + '/edit', function(res) {
                $('#modal_title').html('Edit Todo');
                $("#id").val(res.id);
                $("#name_todo").val(res.name);
                $("#modal_todo").modal('show');
            })
        })
        //Delete Button
        $("body").on('click', '#delete_todo', function() {
            var id = $(this).data('id');
            confirm('Are you sure You want to delete ?');

            $.ajax({
                url: "todos/delete/" + id,
                type: 'DELETE'
            }).done(function(res) {
                $("#row_todo_" + id).remove();
            })

        });
        //Save Data
        $("form").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "todos/store",
                data: $("#form_todo").serialize(),
                type: 'POST'
            }).done(function(res) {
                var row = '<tr id="row_todo_' + res.id + '">';
                row += '<td>' + res.id + '</td>';
                row += '<td>' + res.name + '</td>';
                row += '<td>' + '<button type="button" id="edit_todo" data-id="' + res.id +
                    '" class="btn btn-info btn-sm mr-1">Edit</button>' +
                    '<button type="button" id="delete_todo" data-id="' + res.id +
                    '" class="btn btn-danger btn-sm">Delete</button>' + '</td>';

                if ($("#id").val()) {
                    $('#row_todo_' + res.id).replaceWith(row);
                } else {
                    $("#list_todo").prepend(row);
                }

                $("#form_todo").trigger('reset');
                $("#modal_todo").modal('hide');
            })
        });
    </script>
</body>

</html>
