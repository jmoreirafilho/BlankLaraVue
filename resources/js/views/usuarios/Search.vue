<template>
  <buscar entidade="usuarios" :form-valido="formValido" :cabecalho="cabecalho" :busca="busca" :payload="payload">
    <template v-slot:filtros>
      <v-row dense>
        <v-col cols="12" md="4">
          <v-text-field label="Nome" outlined @change="busca.nome = $event.toUpperCase()" v-model="busca.nome" dense clearable hide-details></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field label="E-mail" outlined v-model="busca.email" dense clearable hide-details></v-text-field>
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
        { text: "E-mail", value: "email" },
        { text: "Perfil", value: "nome_perfil" },
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