<template>
  <buscar entidade="clientes" :form-valido="formValido" :cabecalho="cabecalho" :busca="busca" :payload="payload">
    <template v-slot:filtros>
      <v-row dense>
        <v-col cols="12" md="4">
          <v-text-field label="Nome" outlined v-model="busca.nome" dense clearable hide-details @change="busca.nome = $event.toUpperCase()"></v-text-field>
        </v-col>
      </v-row>
    </template>

    <template v-slot:formulario="{formulario}">
      <formulario :formulario="formulario" @validacao="formValido = $event" @change="payload = $event"></formulario>
    </template>
    
  </buscar>
</template>

<script>
import LayoutBuscar from '../../components/Buscar.vue';
import Util from '../../components/Util.vue';
import FormVue from './Form.vue';

export default {
  data() {
    return {
      util: Util,
      formValido: false,
      payload: null,
      busca: {},
      cabecalho: [
        { text: "Nome", value: "nome" },
        {
          text: 'Ações',
          value: "acoes",
          align: "center",
          sortable: false,
          class: "action-column",
        }
      ]
    };
  },
  components: {
    buscar: LayoutBuscar,
    formulario: FormVue
  }
};
</script>