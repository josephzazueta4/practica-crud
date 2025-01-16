<template>
    <div>
      <form @submit.prevent="submitForm">
        <div>
          <label for="nombre">Nombre:</label>
          <input type="text" v-model="empleado.nombre" :class="{'border-red-500': v$.nombre.$error}" />
          <span v-if="v$.nombre.$error" class="text-red-500">Este campo es obligatorio.</span>
        </div>
  
        <div>
          <label for="primer_apellido">Primer Apellido:</label>
          <input type="text" v-model="empleado.primer_apellido" :class="{'border-red-500': v$.primer_apellido.$error}" />
          <span v-if="v$.primer_apellido.$error" class="text-red-500">Este campo es obligatorio.</span>
        </div>
  
        <div>
          <label for="email">Correo Electrónico:</label>
          <input type="email" v-model="empleado.email" :class="{'border-red-500': v$.email.$error}" />
          <span v-if="v$.email.$error" class="text-red-500">Correo electrónico inválido o ya registrado.</span>
        </div>
  
        <div>
          <label for="salario">Salario:</label>
          <input type="number" v-model="empleado.salario" :class="{'border-red-500': v$.salario.$error}" />
          <span v-if="v$.salario.$error" class="text-red-500">El salario debe ser un valor positivo.</span>
        </div>
  
        <div>
          <label for="idcargo">Cargo:</label>
          <select v-model="empleado.idcargo" :class="{'border-red-500': v$.idcargo.$error}">
            <option value="">Seleccionar cargo</option>
        
          </select>
          <span v-if="v$.idcargo.$error" class="text-red-500">Seleccionar un cargo es obligatorio.</span>
        </div>
  
        <div>
          <label for="idnivel">Nivel:</label>
          <select v-model="empleado.idnivel" :class="{'border-red-500': v$.idnivel.$error}">
            <option value="">Seleccionar nivel</option>
            
          </select>
          <span v-if="v$.idnivel.$error" class="text-red-500">Seleccionar un nivel es obligatorio.</span>
        </div>
  
        <div>
          <label for="fecha_contratacion">Fecha de Contratación:</label>
          <input type="date" v-model="empleado.fecha_contratacion" :class="{'border-red-500': v$.fecha_contratacion.$error}" />
          <span v-if="v$.fecha_contratacion.$error" class="text-red-500">Este campo es obligatorio.</span>
        </div>
  
        <button type="submit" :disabled="v$.$invalid">Guardar</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { reactive } from 'vue';
  import useVuelidate from '@vuelidate/core';
  import { required, email, numeric, greaterThan } from '@vuelidate/validators';
  
  // Datos del formulario
  const empleado = reactive({
    nombre: '',
    primer_apellido: '',
    segundo_apellido: '',
    email: '',
    idcargo: '',
    idnivel: '',
    salario: '',
    fecha_contratacion: ''
  });
  
  // Validaciones
  const rules = {
    nombre: { required },
    primer_apellido: { required },
    email: { required, email },
    salario: { required, numeric, greaterThan: greaterThan(0) },
    idcargo: { required },
    idnivel: { required },
    fecha_contratacion: { required }
  };
  
  // Instanciamos las validaciones
  const v$ = useVuelidate(rules, empleado);
  
  // Función de submit
  const submitForm = () => {
    if (v$.$invalid) {
      alert('Por favor, completa correctamente todos los campos.');
      return;
    }
  
    console.log('Formulario enviado:', empleado);
  };
  </script>
  