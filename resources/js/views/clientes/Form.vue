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
          v-model="model.nome" :rules="[validacao.required(model.nome)]" @change="model.nome = $event.toUpperCase()" label="Nome" outlined dense :readonly="formulario.modo == 'VISUALIZAR'"></v-text-field>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
import Validacao from '../../components/Validacao.vue';

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
  methods: {
    buscar: function (id) {
      this.loader = true;
      axios.post("/clientes/buscar", { id: id }).then((response) => {
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