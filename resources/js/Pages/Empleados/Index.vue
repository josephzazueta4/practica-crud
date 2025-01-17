<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

// Props recibidas desde el backend
defineProps({
  empleados: Object,  // Cambiar de Array a Object para recibir los datos paginados
});

// Propiedad reactive para la búsqueda
const search = ref('');

// Método para filtrar empleados
const filtrarEmpleados = () => {
  Inertia.get('/empleados', { search: search.value }, { replace: true });
};

// Métodos
const editarEmpleado = (id) => {
  console.log(`Redirigiendo a /empleados/${id}/edit`);
  Inertia.get(`/empleados/${id}/edit`);  // Usar Inertia.get
};

const eliminarEmpleado = (id) => {
  if (confirm('¿Estás seguro de que deseas eliminar este empleado?')) {
    console.log(`Eliminando empleado con id ${id}`);
    Inertia.delete(`/empleados/${id}`);
  }
};

const agregarEmpleado = () => {
  console.log('Redirigiendo a /empleados/form');
  Inertia.get('/empleados/form');
};

const irAPagina = (url) => {
  Inertia.get(url);
};
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Lista de Empleados" />

    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Lista de Empleados</h1>

        <!-- Campo de búsqueda y botón de filtro -->
        <div class="flex items-center">
          <input
            v-model="search"
            type="text"
            placeholder="Buscar por nombre o cargo"
            class="border border-gray-300 rounded-lg px-4 py-2"
          />
          <button
            @click="filtrarEmpleados"
            class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
          >
            Aplicar Filtro
          </button>
        </div>

        <button
          @click="agregarEmpleado"
          class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
        >
          Agregar Empleado
        </button>
      </div>

      <!-- Tabla de empleados -->
      <table class="table-auto w-full border border-gray-300 rounded-lg">
        <thead>
          <tr class="bg-gray-200 text-left">
            <th class="px-4 py-2">Id</th>
            <th class="px-4 py-2">Nombre</th>
            <th class="px-4 py-2">Primer Apellido</th>
            <th class="px-4 py-2">Segundo Apellido</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Cargo</th>
            <th class="px-4 py-2">Salario</th>
            <th class="px-4 py-2">Fecha de Contratación</th>
            <th class="px-4 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="empleado in empleados.data"
            :key="empleado.idempleado"
            class="hover:bg-gray-100"
          >
            <td class="border px-4 py-2">{{ empleado.idempleado }}</td>
            <td class="border px-4 py-2">{{ empleado.nombre }}</td>
            <td class="border px-4 py-2">{{ empleado.primer_apellido }}</td>
            <td class="border px-4 py-2">{{ empleado.segundo_apellido }}</td>
            <td class="border px-4 py-2">{{ empleado.email }}</td>
            <td class="border px-4 py-2">{{ empleado.cargo.nombre_cargo }}</td>
            <td class="border px-4 py-2">{{ empleado.nivel.salario }}</td>
            <td class="border px-4 py-2">{{ empleado.fecha_contratacion }}</td>
            <td class="border px-4 py-2">
              <button
                @click="editarEmpleado(empleado.idempleado)"
                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
              >
                Editar
              </button>
              <button
                @click="eliminarEmpleado(empleado.idempleado)"
                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 ml-2"
              >
                Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Rango de empleados y paginación -->
      <div class="mt-4 flex justify-between items-center">
        <div>
          <p class="text-sm">
            Mostrando {{ empleados.from }} a {{ empleados.to }} de {{ empleados.total }} empleados
          </p>
        </div>

        <!-- Paginación -->
        <div class="flex">
          <button
            v-if="empleados.prev_page_url"
            @click="irAPagina(empleados.prev_page_url)"
            class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400"
          >
            Anterior
          </button>

          <button
            v-if="empleados.next_page_url"
            @click="irAPagina(empleados.next_page_url)"
            class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 ml-2"
          >
            Siguiente
          </button>

          <div v-if="empleados.last_page > 1" class="ml-4 flex items-center">
            <span class="text-sm">
              Página {{ empleados.current_page }} de {{ empleados.last_page }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
