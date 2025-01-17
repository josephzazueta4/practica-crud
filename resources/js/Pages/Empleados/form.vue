<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';
import { required, email, numeric } from '@vuelidate/validators';
import useVuelidate from '@vuelidate/core';
import { Inertia } from '@inertiajs/inertia';

// Validador personalizado
const greaterThanZero = (value) => value > 0 || 'El salario debe ser mayor que cero';

// Datos del formulario
const empleado = reactive({
  nombre: '',
  primer_apellido: '',
  segundo_apellido: '',
  email: '',
  idcargo: '',
  idnivel: '',
  salario: '', 
  fecha_contratacion: '',
});

// Validaciones
const rules = {
  nombre: { required },
  primer_apellido: { required },
  segundo_apellido: { required },
  email: { required, email },
  salario: { required, numeric, greaterThanZero },
  idcargo: { required },
  idnivel: { required },
  fecha_contratacion: { required },
};

// Instanciamos las validaciones
const v$ = useVuelidate(rules, empleado);


const props = defineProps({
  cargos: Array,
  niveles: Array,
});

// Estado reactivo para el salario del nivel seleccionado
const selectedNivel = reactive({
  salario: null,
});

// Verifica cuando se cambia el nivel y actualiza el salario
watch(() => empleado.idnivel, (newIdnivel) => {
  const nivelSeleccionado = props.niveles.find(nivel => nivel.idnivel === newIdnivel);
  if (nivelSeleccionado) {
    selectedNivel.salario = nivelSeleccionado.salario;
    empleado.salario = nivelSeleccionado.salario; // Actualizamos salario en el empleado
  } else {
    selectedNivel.salario = null;
    empleado.salario = ''; 
  }
});


const regresarAlIndex = () => {
  // Redirigir a la página principal o de índice de empleados
  Inertia.get('/empleados');  
};

// Función para enviar el formulario
const submitForm = () => {
  if (v$.$invalid) {
    alert('Por favor, completa correctamente todos los campos.');
    return;
  }
  // Aquí, usa un método para enviar los datos al servidor, por ejemplo, usando inertia
  Inertia.post('/empleados', empleado);

  
};
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Formulario de Empleado" />

    <div class="p-6 max-w-4xl mx-auto bg-white rounded-lg shadow-md">

      <h1 class="text-2xl font-bold mb-6">Formulario de Empleado</h1>
      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Nombre -->
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input
              id="nombre"
              type="text"
              v-model="empleado.nombre"
              pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?: [A-Za-zÁÉÍÓÚáéíóúÑñ]+)*"
              title="El nombre solo puede contener letras y espacios."
             :class="['mt-1 block w-full rounded-md', v$.nombre.$error && v$.nombre.$dirty ? 'border-red-500' : 'border-gray-300']"
        />
        <span v-if="v$.nombre.$error && v$.nombre.$dirty" class="text-red-500 text-sm">Este campo es obligatorio.</span>
        </div>

        <!-- Primer Apellido -->
        <div>
          <label for="primer_apellido" class="block text-sm font-medium text-gray-700">Primer Apellido:</label>
          <input
            id="primer_apellido"
            type="text"
            v-model="empleado.primer_apellido"
            :class="['mt-1 block w-full rounded-md', v$.primer_apellido.$error && v$.primer_apellido.$dirty ? 'border-red-500' : 'border-gray-300']"
          />
          <span v-if="v$.primer_apellido.$error && v$.primer_apellido.$dirty" class="text-red-500 text-sm">Este campo es obligatorio.</span>
        </div>

        <!-- Segundo Apellido -->
        <div>
          <label for="segundo_apellido" class="block text-sm font-medium text-gray-700">Segundo Apellido:</label>
          <input
            id="segundo_apellido"
            type="text"
            v-model="empleado.segundo_apellido"
            :class="['mt-1 block w-full rounded-md', v$.segundo_apellido.$error && v$.segundo_apellido.$dirty ? 'border-red-500' : 'border-gray-300']"
          />
          <span v-if="v$.segundo_apellido.$error && v$.segundo_apellido.$dirty" class="text-red-500 text-sm">Este campo es obligatorio.</span>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
          <input
            id="email"
            type="email"
            v-model="empleado.email"
            :class="['mt-1 block w-full rounded-md', v$.email.$error && v$.email.$dirty ? 'border-red-500' : 'border-gray-300']"
          />
          <span v-if="v$.email.$error && v$.email.$dirty" class="text-red-500 text-sm">Correo electrónico inválido o ya registrado.</span>
        </div>

        <!-- Cargo -->
        <div>
          <label for="idcargo" class="block text-sm font-medium text-gray-700">Cargo:</label>
          <select
            id="idcargo"
            v-model="empleado.idcargo"
            :class="['mt-1 block w-full rounded-md', v$.idcargo.$error && v$.idcargo.$dirty ? 'border-red-500' : 'border-gray-300']"
          >
            <option value="">Seleccionar cargo</option>
            <option
              v-for="cargo in cargos"
              :key="cargo.idcargo"
              :value="cargo.idcargo"
            >
              {{ cargo.nombre_cargo }}
            </option>
          </select>
          <span v-if="v$.idcargo.$error && v$.idcargo.$dirty" class="text-red-500 text-sm">Seleccionar un cargo es obligatorio.</span>
        </div>

        <!-- Nivel -->
        <div>
          <label for="idnivel" class="block text-sm font-medium text-gray-700">Nivel:</label>
          <select
            id="idnivel"
            v-model="empleado.idnivel"
            :class="['mt-1 block w-full rounded-md', v$.idnivel.$error && v$.idnivel.$dirty ? 'border-red-500' : 'border-gray-300']"
          >
            <option value="">Seleccionar nivel</option>
            <option
              v-for="nivel in niveles"
              :key="nivel.idnivel"
              :value="nivel.idnivel"
            >
              {{ nivel.salario }}
            </option>
          </select>
          <span v-if="v$.idnivel.$error && v$.idnivel.$dirty" class="text-red-500 text-sm">Seleccionar un nivel es obligatorio.</span>
        </div>

        <!-- Fecha de Contratación -->
        <div>
          <label for="fecha_contratacion" class="block text-sm font-medium text-gray-700">Fecha de Contratación:</label>
          <input
            id="fecha_contratacion"
            type="date"
            v-model="empleado.fecha_contratacion"
            :class="['mt-1 block w-full rounded-md', v$.fecha_contratacion.$error && v$.fecha_contratacion.$dirty ? 'border-red-500' : 'border-gray-300']"
          />
          <span v-if="v$.fecha_contratacion.$error && v$.fecha_contratacion.$dirty" class="text-red-500 text-sm">Este campo es obligatorio.</span>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4 mt-6">
          <button
            type="button"
            @click="regresarAlIndex"
            class="bg-gray-200 text-gray-800 py-2 px-4 rounded hover:bg-gray-300"
          >
            Regresar
          </button>

          <button
            type="submit"
            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 disabled:bg-gray-300"
            :disabled="v$.$invalid"
          >
            Guardar
          </button>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
