<template>
    <div>
      <h1>Lista de Empleados</h1>
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Email</th>
            <th>Cargo</th>
            <th>Salario</th>
            <th>Fecha de Contratación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="empleado in empleados" :key="empleado.idempleado">
            <td>{{ empleado.nombre }}</td>
            <td>{{ empleado.primer_apellido }}</td>
            <td>{{ empleado.segundo_apellido }}</td>
            <td>{{ empleado.email }}</td>
            <td>{{ empleado.cargo.nombre_cargo }}</td>
            <td>{{ empleado.nivel.salario }}</td>
            <td>{{ empleado.fecha_contratacion }}</td>
            <td>
              <button @click="editarEmpleado(empleado.idempleado)">Editar</button>
              <button @click="eliminarEmpleado(empleado.idempleado)">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      empleados: Array,
    },
    methods: {
      editarEmpleado(id) {
        console.log(`Redirigiendo a /empleados/${id}/edit`);
        this.$inertia.get(`/empleados/${id}/edit`);
      },
      eliminarEmpleado(id) {
        console.log(`Eliminando empleado con id ${id}`);
        this.$inertia.delete(`/empleados/${id}`);
      },
    },
  };
  </script>
  