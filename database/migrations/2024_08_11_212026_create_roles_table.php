<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_type_id')->constrained('business_types')->onDelete('cascade');
            $table->string('name'); // Nombre del rol, por ejemplo: Admin, Moderator, User, etc.
            $table->text('description')->nullable(); // Descripción opcional del rol
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['id' => 1, 'business_type_id' => 1, 'name' => 'ADMIN', 'description' => 'ADMIN SISTEMA.'],
            ['id' => 2, 'business_type_id' => 2, 'name' => 'ADMIN BUSSINESS', 'description' => 'ADMIN Tiendas/Negocios.'],
            ['id' => 3, 'business_type_id' => 3, 'name' => 'Cajero', 'description' => 'Maneja las ventas y el dinero en efectivo en la tienda.'],
            ['id' => 4, 'business_type_id' => 3, 'name' => 'Inventarios', 'description' => 'Gestiona el inventario y pedidos de productos en la tienda.'],
            ['id' => 5, 'business_type_id' => 3, 'name' => 'Supervisor de Tienda', 'description' => 'Supervisa las operaciones diarias en la tienda.'],
            ['id' => 6, 'business_type_id' => 4, 'name' => 'Mesero', 'description' => 'Atiende a los clientes en el restaurante y toma órdenes.'],
            ['id' => 7, 'business_type_id' => 4, 'name' => 'Cocinero', 'description' => 'Prepara la comida según las órdenes en el restaurante.'],
            ['id' => 8, 'business_type_id' => 4, 'name' => 'Encargado de Cocina', 'description' => 'Supervisa las operaciones en la cocina del restaurante.'],
            ['id' => 9, 'business_type_id' => 4, 'name' => 'Supervisor de Restaurante', 'description' => 'Administra las operaciones del restaurante.'],
            ['id' => 10, 'business_type_id' => 5, 'name' => 'Proveedor de Servicio', 'description' => 'Realiza los servicios contratados (peluquero, técnico, etc.).'],
            ['id' => 11, 'business_type_id' => 5, 'name' => 'Recepcionista', 'description' => 'Maneja la atención al cliente y las citas en un negocio de servicios.'],
            ['id' => 12, 'business_type_id' => 5, 'name' => 'Gerente de Servicios', 'description' => 'Supervisa la prestación de servicios y maneja al equipo.'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}