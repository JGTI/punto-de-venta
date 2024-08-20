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
                            <h5 class="card-title fw-semibold">Gestión de Menús</h5>
                        </div>
                    </div>
                    <div class="table-responsive"> <!-- Contenedor para el scroll horizontal -->
                <table class="table table-bordered data-table" id="menusTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Menú</th>
                            <th>Sub Menú</th>
                            <th>Sub-Sub Menú</th>
                            <th>Ruta</th>
                            <th>Estado</th>
                            <th>Roles</th>
                            <th>Icono</th>
                            <th>Orden</th>
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

    
    <!-- Modal -->
    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="menuModalLabel">Crear Nuevo Menú</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="menuForm" name="menuForm">
                        <input type="hidden" name="menu_id" id="menu_id">
                        <div class="mb-3">
                            <label for="menu_name" class="form-label">Nombre del Menú</label>
                            <input type="text" class="form-control" id="menu_name" name="menu_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="sub_menu_name" class="form-label">Sub Menú</label>
                            <input type="text" class="form-control" id="sub_menu_name" name="sub_menu_name">
                        </div>
                        <div class="mb-3">
                            <label for="subsub_menu_name" class="form-label">Sub-Sub Menú</label>
                            <input type="text" class="form-control" id="subsub_menu_name" name="subsub_menu_name">
                        </div>
                        <div class="mb-3">
                            <label for="route" class="form-label">Ruta</label>
                            <input type="text" class="form-control" id="route" name="route" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    
                        <div class="mb-3">
                            <label for="roles" class="form-label">Roles</label>
                            <select id="roles" name="roles[]" class="form-select" multiple="multiple">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Icono</label>
                            <input type="text" class="form-control" id="icon" name="icon" required>
                        </div>


                        <div class="mb-3">
                            <label for="order" class="form-label">Orden</label>
                            <input type="text" class="form-control" id="order" name="order" required>
                        </div>

                        <button type="submit" class="btn btn-dark form-control" id="saveBtn">Guardar</button>
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
    $(document).ready(function() {

        // Inicializa Selectize para el select múltiple de roles
        $('#roles').selectize({
            placeholder: 'Selecciona roles',
            plugins: ['remove_button'],
            maxItems: null, // Permite múltiples selecciones
            create: false // No permite crear nuevas opciones
        });
        

        var table = $('#menusTable').DataTable({
            proce3ssing: true,
            serverSide: true,
            ajax: "{{ route('menus.index') }}",
            language: {
                url: 'public/assets/js/es-ES.json'
            },
            dom: 'Bfrtip', 
            buttons: [
                {
                    text: 'Crear Nuevo Menú',
                    className: 'btn btn-dark mb-2 createNewMenu',
                    action: function ( e, dt, node, config ) {
                        $('#menuModal').modal('show');
                        $('#saveBtn').val("create-menu");
                        $('#menu_id').val('');
                        $('#menuForm').trigger("reset");
                        $('#menuModalLabel').text("Crear Nuevo Menú");
                        $('#menuModal').modal('show');
                    }
                }
            ],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'menu_name', name: 'menu_name' },
                { data: 'sub_menu_name', name: 'sub_menu_name' },
                { data: 'subsub_menu_name', name: 'subsub_menu_name' },
                { data: 'route', name: 'route' },
                { data: 'status', name: 'status' },
                { data: 'roles', name: 'roles' },
                { data: 'icon', name: 'icon' },
                { data: 'order', name: 'order' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('body').on('click', '.editMenu', function () {
            var menuId = $(this).data('id');
            $.get("{{ url('menus') }}" + '/' + menuId + '/edit', function (data) {
                $('#menuModalLabel').text("Editar Menú");
                $('#saveBtn').val("edit-menu");
                $('#menuModal').modal('show');
                $('#menu_id').val(data.menu.id);
                $('#menu_name').val(data.menu.menu_name);
                $('#sub_menu_name').val(data.menu.sub_menu_name);
                $('#subsub_menu_name').val(data.menu.subsub_menu_name);
                $('#route').val(data.menu.route);
                $('#status').val(data.menu.status);
                // Inicializa el select múltiple
                var selectize = $('#roles')[0].selectize;
                selectize.clear(); // Limpia las selecciones actuales
                selectize.setValue(JSON.parse(data.menu.roles)); // Establece los valores predefinidos
                selectize.refreshOptions(); // Actualiza las opciones del select
                $('#icon').val(data.menu.icon);
                $('#order').val(data.menu.order);
            });
        });

        $('body').on('submit', '#menuForm', function (e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('menus.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#menuForm').trigger("reset");
                    $('#menuModal').modal('hide');
                    table.draw();
                    $.notify({ message: 'Operación exitosa' }, { type: 'success' });
                },
                error: function (data) {
                    $.notify({ message: 'Error en la operación' }, { type: 'danger' });
                }
            });
        });

        $('body').on('click', '.deleteMenu', function () {
            var menuId = $(this).data("id");
            if (confirm("¿Estás seguro de que quieres eliminar este menú?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('menus') }}" + '/' + menuId,
                    success: function (data) {
                        table.draw();
                        $.notify({ message: 'Menú eliminado' }, { type: 'success' });
                    },
                    error: function (data) {
                        $.notify({ message: 'Error al eliminar el menú' }, { type: 'danger' });
                    }
                });
            }
        });
    });
</script>
@endsection
