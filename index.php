<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container">
    <h1 class="mt-5">CRUD Example</h1>
    <button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#addModal">Adicionar Novo Registro</button>
    <div id="records_content"></div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Adicionar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="name" class="form-control" placeholder="Nome" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="addRecord()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_id">
                <input type="text" id="edit_name" class="form-control" placeholder="Nome">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="updateRecord()">Salvar Mudanças</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    readRecords(); // Load records on page load

    $('#addModal').on('show.bs.modal', function () {
        $('#name').val('');  // Clear the input field
    });
});

// Fetch records
function readRecords(page = 1) {
    $.get("fetch.php?page=" + page, function(data, status) {
        $("#records_content").html(data);
    });
}

// Add record
function addRecord() {
    var name = $("#name").val();
    $.post("add.php", {
        name: name
    }, function(data, status) {
        $('#addModal').modal('hide');
        readRecords(); // Refresh the list
    });
}

// Get record details for edit
function editRecord(id) {
    $.post("edit.php", {
        id: id
    }, function(data, status) {
        var record = JSON.parse(data);
        $("#edit_id").val(record.id);
        $("#edit_name").val(record.name);
        $('#editModal').modal('show');
    });
}

// Update record
function updateRecord() {
    var id = $("#edit_id").val();
    var name = $("#edit_name").val();
    $.post("edit.php", {
        id: id,
        name: name,
        update: true
    }, function(data, status) {
        $('#editModal').modal('hide');
        readRecords(); // Refresh the list
    });
}

// Delete record
function deleteRecord(id) {
    if (confirm("Você realmente quer excluir este registro?")) {
        $.post("delete.php", {
            id: id
        }, function(data, status) {
            readRecords(); // Refresh the list
        });
    }
}
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
