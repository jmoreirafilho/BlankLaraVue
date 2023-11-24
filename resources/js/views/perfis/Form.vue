<template>
  <v-form v-model="form" ref="form">
    <v-row dense v-show="loader">
      <v-col cols="12" class="text-center my-9">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-col>
    </v-row>
    <v-row dense v-show="!loader">
      <v-col cols="12">
        <v-text-field
          v-model="model.nome" :rules="[validacao.required(model.nome)]" @change="model.nome = $event.toUpperCase()" label="Nome" outlined dense :readonly="formulario.modo == 'VISUALIZAR'"></v-text-field>
      </v-col>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="py-2" style="color: #FFF; background-color: #64B5F6">
            Viagens
          </v-card-title>
          <v-card-text class="py-2">
            <v-row dense>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_viagens" label="Viagens" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_abastecimentos" label="Abastecimentos" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_passageiros" label="Passageiros" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_rel_viagens" label="Relatório de Viagens" outlined dense hide-details></v-checkbox>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="py-2" style="color: #FFF; background-color: #64B5F6">
            Veículos
          </v-card-title>
          <v-card-text class="py-2">
            <v-row dense>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_veiculos" label="Veículos" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_manutencoes" label="Manutenções" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_rel_veiculos" label="Relatório de Veículos" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_rel_motoristas" label="Relatório de Motoristas" outlined dense hide-details></v-checkbox>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="py-2" style="color: #FFF; background-color: #64B5F6">
            Financeiro
          </v-card-title>
          <v-card-text class="py-2">
            <v-row dense>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_contas_receber" label="Contas a Receber" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_contas_pagar" label="Contas a Pagar" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_fluxo_caixa" label="Fluxo de Caixa" outlined dense hide-details></v-checkbox>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="py-2" style="color: #FFF; background-color: #64B5F6">
            Cadastros
          </v-card-title>
          <v-card-text class="py-2">
            <v-row dense>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_perfis" label="Perfis" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_usuarios" label="Usuários" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_clientes" label="Clientes" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_postos" label="Postos" outlined dense hide-details></v-checkbox>
              </v-col>
              <v-col cols="12">
                <v-checkbox :readonly="formulario.modo == 'VISUALIZAR'" true-value="S" false-value="N" v-model="model.flag_checklists" label="CheckLists" outlined dense hide-details></v-checkbox>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
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
      axios.post("/perfis/buscar", { id: id }).then((response) => {
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