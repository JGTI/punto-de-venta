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
                            <h5 class="card-title fw-semibold">Gestión de Sucursales</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="branchesTable" class="table table-bordered data-table table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo de Negocio</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
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

    <!-- Modal for Create/Edit Branch -->
    <div class="modal fade" id="branchModal" tabindex="-1" aria-labelledby="branchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="branchModalLabel">Crear/Editar Sucursal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="branchForm">
                        <input type="hidden" name="id" id="branch_id">
                        <div class="mb-3 business_type_id">
                            <label for="business_type_id" class="form-label">Tipo de Negocio</label>
                            <select class="form-control" id="business_type_id" name="business_type_id" required>
                                <option value="" disabled selected>Selecciona el tipo de negocio</option>
                                @foreach($business_types as $business_type)
                                    <option value="{{ $business_type->id }}">{{ $business_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="active" class="form-label">Estatus</label>
                            <select class="form-control" id="active" name="active" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-dark form-control" id="saveBranch">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para administrar empleados -->
    <div class="modal fade" id="employeesModal" tabindex="-1" aria-labelledby="employeesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Administrar Empleados <span id='employeesModalLabel'></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Aquí irá la DataTable de empleados -->
                    <table id="employeesTable" class="table table-bordered data-table table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
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

    <!-- Modal para crear/editar empleados -->
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">Crear/Editar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="employeeForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="employee_id">


                        <div class="form-group">
                            <label for="branch_id" class="form-label">Sucursal</label>
                            <select class="form-control" id="employee_branch_id" onchange="get_roles(this.value)" name="branch_id" required>
                                <!-- Opciones de sucursales -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="role_id" class="form-label">Rol</label>
                            <select class="form-control" id="employee_role_id" name="role_id" required>
                                <!-- Opciones de roles -->
                            </select>
                        </div>
                        

                        <div class="form-group">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="employee_name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="employee_email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="employee_phone" name="phone">
                        </div>

                        <div class="form-group">
                            <label for="active" class="form-label">Activo</label>
                            <select class="form-control" id="active" name="employee_active" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark form-control" id="saveEmployee">Guardar</button>
                    </div>
                </form>
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

    function clearRoles(){
        var $roleSelect = $('#employee_role_id');
        $roleSelect.empty(); // Limpiar el select antes de agregar nuevas opciones
        $roleSelect.append('<option value="">Selecciona un Rol</option>');
    }
    function get_roles(branchId){
        clearRoles();
        $.get("{{ url('/getRoles') }}"+ '/' + branchId , function (data) {
                var $roleSelect = $('#employee_role_id');
                $.each(data, function(index, role) {
                    var selected='';
                    /*if(branchId==branch.id){
                        var selected='selected';
                        $('#employeesModalLabel').html(' - '+ branch.name + ' (' + branch.business_type.name + ')');
                    }*/
                    $roleSelect.append('<option value="' + role.id + '" '+selected+'>' + role.name + '</option>');
                });
            });
    }

    $(function () {
        var table = $('#branchesTable').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip', 
            buttons: [
                {
                    text: 'Crear Nueva Sucursal',
                    className: 'btn btn-dark mb-2',
                    action: function (e, dt, node, config) {
                        $('#branch_id').val('');
                        $('#branchForm').trigger("reset");
                        $('#branchModalLabel').text("Crear Nueva Sucursal");
                        $('.business_type_id').show();
                        $('#branchModal').modal('show');
                    }
                }
            ],
            ajax: "{{ route('branches.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'business_type.name', name: 'business_type.name'},
                {data: 'name', name: 'name'},
                {data: 'address', name: 'address'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        
        $('body').on('click', '.manage-employees', function () {
            var branchId = $(this).data('id');

            // Inicializar o destruir la DataTable si ya existe
            if ($.fn.DataTable.isDataTable('#employeesTable')) {
                $('#employeesTable').DataTable().destroy();
            }
            

            // Inicializar la DataTable de empleados
            var table = $('#employeesTable').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrtip', 
                buttons: [
                    {
                        text: 'Crear Nuevo Empleado',
                        className: 'btn btn-dark mb-2',
                        action: function (e, dt, node, config) {
                            $('#employee_id').val('');
                            $('#employeeForm').trigger("reset");
                            $('#employeeModalLabel').text("Crear Nuevo Empleado");
                            $('#employeeModal').modal('show');
                        }
                    }
                ],
                ajax: {
                    url: '{{ route("branches.employees", ":id") }}'.replace(':id', branchId),
                    type: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'role.name', name: 'role_id'}, // Asumiendo que hay una relación entre empleados y roles
                    {
                        data: 'active', 
                        name: 'active',
                        render: function(data, type, full, meta) {
                            return data ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                        }
                    },
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false
                    }
                ]
            });

            
            get_branches(branchId);
            // Abrir el modal
            $('#employeesModal').modal('show');
        });

        

        function get_branches(branchId){
            
            clearRoles();

            $.get("{{ url('/getBranches') }}", function (data) {
                // Rellenar el select de sucursales (branch_id)
                var $branchSelect = $('#employee_branch_id');
                $branchSelect.empty(); // Limpiar el select antes de agregar nuevas opciones
                $branchSelect.append('<option value="">Selecciona una Sucursal</option>');

                $.each(data, function(index, branch) {
                    var selected='';
                    if(branchId==branch.id){
                        var selected='selected';
                        $('#employeesModalLabel').html(' - '+ branch.name + ' (' + branch.business_type.name + ')');
                    }
                    $branchSelect.append('<option value="' + branch.id + '" '+selected+'>' + branch.name + ' (' + branch.business_type.name + ')</option>');
                });
                get_roles(branchId);
            });
        }



        $('body').on('click', '.editEmploye', function () {
            var id = $(this).data('id');
            $.get("{{ url('/employees') }}" + '/' + id + '/edit', function (data) {
                $('#employeeModal').modal('show');
                $('#branchModalLabel').html("Editar Empleado");
                $('#employee_id').val(data.employee.id);
                $('#employee_role_id').val(data.employee.role_id);
                $('#employee_branch_id').val(data.employee.branch_id);
                $('#employee_name').val(data.employee.name);
                $('#employee_email').val(data.employee.email);
                $('#employee_phone').val(data.employee.phone);
                $('#employee_active').val(data.employee.active);
            });
        });

                


        $('body').on('click', '.edit', function () {
            var id = $(this).data('id');
            $.get("{{ route('branches.index') }}" + '/' + id + '/edit', function (data) {
                $('#branchModalLabel').html("Editar Sucursal");
                $('.business_type_id').hide();
                $('#branchModal').modal('show');
                $('#branch_id').val(data.id);
                $('#business_type_id').val(data.business_type_id);
                $('#name').val(data.name);
                $('#address').val(data.address);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#active').val(data.active);
            })
        });

        $('#saveBranch').click(function (e) {
            e.preventDefault();
            $.ajax({
                data: $('#branchForm').serialize(),
                url: "{{ route('branches.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    $('#branchForm').trigger("reset");
                    $('#branchModal').modal('hide');
                    table.draw();

                    $.notify({
                        // Mensaje de éxito desde la respuesta del servidor
                        message: response.message
                    }, {
                        type: 'success',
                        delay: 2000,
                    });
                },
                error: function (response) {
                    $.notify({
                        // Mensaje de error desde la respuesta del servidor
                        message: response.responseJSON.message
                    }, {
                        type: 'danger',
                        delay: 2000,
                    });
                }
            });
        });

        $('body').on('click', '.delete', function () {
            var id = $(this).data("id");
            if (confirm("¿Estás seguro de que deseas eliminar esta sucursal?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('branches.destroy', '') }}" + '/' + id,
                    success: function (response) {
                        table.draw();

                        $.notify({
                            // Mensaje de éxito desde la respuesta del servidor
                            message: response.message
                        }, {
                            type: 'success',
                            delay: 2000,
                        });
                    },
                    error: function (response) {
                        $.notify({
                            // Mensaje de error desde la respuesta del servidor
                            message: response.responseJSON.message
                        }, {
                            type: 'danger',
                            delay: 2000,
                        });
                    }
                });
            }
        });

    });
</script>
@endsection
