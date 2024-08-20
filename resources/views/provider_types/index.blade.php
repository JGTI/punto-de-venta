@extends('masterpage.admin')

@section('title', 'Gestión de Tipos de Proveedor')

@section('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Gestión de Tipos de Proveedor</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="providerTypesTable" class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Estatus</th>
                                    <th>Seguimiento Especial</th>
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

    <!-- Modal for Create/Edit ProviderType -->
    <div class="modal fade" id="providerTypeModal" tabindex="-1" aria-labelledby="providerTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="providerTypeModalLabel">Crear/Editar Tipo de Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="providerTypeForm">
                        <input type="hidden" name="id" id="providerType_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="need_control" class="form-label">Necesita Seguimiento Especial <small>(Validar datos cedulas etc...)</small></label>
                            <select id="need_control" name="need_control" class="form-select">
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estatus</label>
                            <select id="status" name="status" class="form-select">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
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
        var table = $('#providerTypesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('provider-types.index') }}",
            dom: 'Bfrtip', 
            buttons: [
                {
                    text: 'Crear Nuevo Tipo de Proveedor',
                    className: 'btn btn-dark mb-2',
                    action: function (e, dt, node, config) {
                        $('#providerTypeModal').modal('show');
                        $('#providerType_id').val('');
                        $('#providerTypeForm').trigger("reset");
                        $('#providerTypeModalLabel').text("Crear Nuevo Tipo de Proveedor");
                        $('#providerTypeModal').modal('show');
                    }
                }
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'need_control', name: 'need_control'},
                {data: 'action', name: 'action', orderable: true, searchable: true}
            ]
        });

        $('body').on('click', '.edit', function () {
            var id = $(this).data('id');
            $.get("{{ url('provider-types') }}" + '/' + id + '/edit', function (data) {
                $('#providerTypeModalLabel').text("Editar Tipo de Proveedor");
                $('#providerTypeModal').modal('show');
                $('#providerType_id').val(data.id);
                $('#name').val(data.name);
                $('#status').val(data.status ? '1' : '0');
                $('#need_control').val(data.need_control ? '1' : '0');
            });
        });

        $('body').on('submit', '#providerTypeForm', function (e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('provider-types.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#providerTypeForm').trigger("reset");
                    $('#providerTypeModal').modal('hide');
                    table.draw();
                    $.notify({ message: 'Operación exitosa' }, { type: 'success' });
                },
                error: function (data) {
                    $.notify({ message: 'Error en la operación' }, { type: 'danger' });
                }
            });
        });

        $('body').on('click', '.delete', function () {
            var id = $(this).data('id');
            if (confirm("¿Estás seguro de que quieres eliminar este tipo de proveedor?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('provider-types') }}" + '/' + id,
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
