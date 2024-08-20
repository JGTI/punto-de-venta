@extends('masterpage.admin')

@section('title', 'Gestión de Menús')

@section('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Gestión de Preguntas</h5>
                        </div>
                    </div>
                    <div class="table-responsive"> <!-- Contenedor para el scroll horizontal -->
                    <table id="questionsTable" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pregunta</th>
                                <th>Opción A</th>
                                <th>Opción B</th>
                                <th>Opción C</th>
                                <th>Opción D</th>
                                <th>Respuesta Correcta</th>
                                <th>order_question</th>
                                <th>Estatus</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </div>
            </div>
        </div>
        </div>
    </div>

    
    <!-- Modal for Create/Edit Question -->
    <div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionModalLabel">Crear/Editar Pregunta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="questionForm">
                        <input type="hidden" name="question_id" id="question_id">
                        <div class="mb-3">
                            <label for="question" class="form-label">Pregunta</label>
                            <input type="text" class="form-control" id="question" name="question" required>
                        </div>
                        <!-- Inputs for Options -->
                        <div class="mb-3">
                            <label for="option_a" class="form-label">Opción A</label>
                            <input type="text" class="form-control" id="option_a" name="option_a" required>
                        </div>
                        <div class="mb-3">
                            <label for="option_b" class="form-label">Opción B</label>
                            <input type="text" class="form-control" id="option_b" name="option_b" required>
                        </div>
                        <div class="mb-3">
                            <label for="option_c" class="form-label">Opción C</label>
                            <input type="text" class="form-control" id="option_c" name="option_c" required>
                        </div>
                        <div class="mb-3">
                            <label for="option_d" class="form-label">Opción D</label>
                            <input type="text" class="form-control" id="option_d" name="option_d" required>
                        </div>
                        <div class="mb-3">
                            <label for="correct_answer" class="form-label">Respuesta Correcta</label>
                            <input type="text" class="form-control" id="correct_answer" name="correct_answer" required>
                        </div>
                        <div class="mb-3">
                            <label for="order_question" class="form-label">Orden</label>
                            <input type="number" class="form-control" id="order_question" name="order_question" required>
                        </div>
                        <div class="mb-3">
                            <label for="active" class="form-label">Estatus</label>
                            <select id="active" name="active" class="form-select">
                                <option value="1">Activa</option>
                                <option value="0">Inactiva</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark form-control">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>


<script src="{{url('assets/js/bootstrap-notify.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.1/js/selectize.min.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#questionsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('questions.index') }}",
            dom: 'Bfrtip', 
            buttons: [
                {
                    text: 'Crear Nueva Pregunta',
                    className: 'btn btn-dark mb-2',
                    action: function ( e, dt, node, config ) {
                        $('#questionModal').modal('show');
                        $('#question_id').val('');
                        $('#questionForm').trigger("reset");
                        $('#questionModalLabel').text("Crear Nueva Pregunta");
                        $('#questionModal').modal('show');
                    }
                }
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'question', name: 'question'},
                {data: 'option_a', name: 'option_a'},
                {data: 'option_b', name: 'option_b'},
                {data: 'option_c', name: 'option_c'},
                {data: 'option_d', name: 'option_d'},
                {data: 'correct_answer', name: 'correct_answer'},
                {data: 'order_question', name: 'order_question'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('body').on('click', '.edit', function () {
            var question_id = $(this).data('id');
            $.get("{{ url('questions') }}" + '/' + question_id + '/edit', function (data) {
                console.log(data);
                $('#questionModalLabel').text("Editar Pregunta");
                $('#questionModal').modal('show');
                $('#question_id').val(data.question.id);
                $('#question').val(data.question.question);
                $('#option_a').val(data.question.option_a);
                $('#option_b').val(data.question.option_b);
                $('#option_c').val(data.question.option_c);
                $('#option_d').val(data.question.option_d);
                $('#correct_answer').val(data.question.correct_answer);
                $('#order_question').val(data.question.order_question);
                $('#active').val(data.question.active);
            });
        });


        $('body').on('submit', '#questionForm', function (e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('questions.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#questionForm').trigger("reset");
                    $('#questionModal').modal('hide');
                    table.draw();
                    $.notify({ message: 'Operación exitosa' }, { type: 'success' });
                },
                error: function (data) {
                    $.notify({ message: 'Error en la operación' }, { type: 'danger' });
                }
            });
        });

        // Handle button click for deleting a question
        $('body').on('click', '.delete', function () {
            var question_id = $(this).data('id');
            if (confirm("Are you sure want to delete this question?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('questions') }}" + '/' + question_id,
                    success: function (data) {
                        table.ajax.reload(null, false);
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            }
        });

    });

</script>
@endsection
