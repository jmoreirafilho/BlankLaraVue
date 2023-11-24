<template>
  <v-form v-model="form" ref="form">
    <v-row dense v-show="loader">
      <v-col cols="12" class="text-center my-9">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-col>
    </v-row>
    <v-row dense v-show="!loader">
      <v-col cols="12" md="6">
        <v-text-field
          v-model="model.nome"
          :rules="[validacao.required(model.nome)]"
          @change="model.nome = $event.toUpperCase()"
          label="Nome"
          outlined
          dense
          :readonly="formulario.modo == 'VISUALIZAR'"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="6">
        <v-text-field
          v-model="model.email"
          :rules="[validacao.required(model.email)]"
          label="E-mail"
          outlined
          dense
          :readonly="formulario.modo == 'VISUALIZAR'"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="6" v-show="formulario.modo != 'VISUALIZAR'">
        <v-text-field
          v-model="model.password"
          :rules="[validacao.requiredIf(formulario.modo == 'CADASTRAR', model.password), validacao.matchPasswords(model.password, model.password_confirmation)]"
          label="Senha"
          outlined
          dense
          type="password"
          clearable
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="6" v-show="formulario.modo != 'VISUALIZAR'">
        <v-text-field
          v-model="model.password_confirmation"
          :rules="[validacao.requiredIf(formulario.modo == 'CADASTRAR', model.password_confirmation), validacao.matchPasswords(model.password_confirmation, model.password)]"
          label="Confirmar Senha"
          outlined
          dense
          type="password"
          clearable
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="6">
        <lista-escalas v-model="model.escala_id" :rules="[validacao.required(model.escala_id)]" label="Escala de Trabalho" outlined dense :readonly="formulario.modo == 'VISUALIZAR'"></lista-escalas>
      </v-col>
      <v-col cols="12" md="5">
        <lista-grupos-acessos label="Grupo de Acesso" v-model="model.grupo_acesso_id" :rules="[validacao.required(model.grupo_acesso_id)]" outlined dense :readonly="formulario.modo == 'VISUALIZAR'"></lista-grupos-acessos>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
import Validacao from '../../components/Validacao.vue';
import EscalasTrabaho from '../../components/listas/EscalasTrabaho.vue';
import GruposAcessos from '../../components/listas/GruposAcessos.vue';

export default {
  data() {
    return {
      form: null,
      validacao: Validacao,
      loader: false,
      model: {}
    };
  },
  props: {
    formulario: {
      default: {
        modo: "VISUALIZAR",
        id: null,
      },
    },
  },
  mounted() {
    this.$refs.form.validate();
    this.model = {};
    if (this.formulario && this.formulario.modo != "CADASTRAR") {
      this.buscar(this.formulario.id);
    }
  },
  components: {
    'lista-grupos-acessos': GruposAcessos,
    'lista-escalas': EscalasTrabaho
  },
  methods: {
    buscar: function (id) {
      this.loader = true;
      axios.post("/usuarios/buscar", { id: id }).then((response) => {
        this.model = response.data.data;
        this.loader = false;
      });
    },
  },
  watch: {
    form: function(val, oldVal) {
      this.$emit('validacao', val);
    },
    model: {
      deep: true,
      handler(val, oldVal) {
        this.$emit("change", val);
      },
    },
    formulario: {
      deep: true,
      handler(val, oldVal) {
        if (val && val.modo != "CADASTRAR") {
          this.buscar(val.id);
        } else {
          this.model = {};
        }
      },
    }
  },
};
</script>