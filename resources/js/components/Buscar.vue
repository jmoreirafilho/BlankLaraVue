<template>
  <app>
    <template slot="content">
      <v-overlay :value="overlay" class="text-center">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-overlay :value="overlayAcesso" class="text-center">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
        <h3 class="mt-5">Validando Acesso...</h3>
      </v-overlay>
      <v-snackbar
        color="error"
        right
        top
        :timeout="3000"
        @input="recarregarPagina()"
        v-model="snackbarAcesso"
      >
        <v-icon left>error</v-icon>
        Permissão Negada
      </v-snackbar>
      <v-snackbar
        color="error"
        right
        top
        :timeout="3000"
        v-model="snackbarErro"
      >
        <v-icon left>error</v-icon>
        {{ mensagemSnackbar }}
      </v-snackbar>
      <v-snackbar
        color="success"
        right
        top
        :timeout="3000"
        v-model="snackbarSucesso"
      >
        <v-icon left>check</v-icon>
        {{ mensagemSnackbar }}
      </v-snackbar>
      <v-dialog v-model="dialogRemover" persistent width="400px">
        <v-card>
          <v-card-title class="text-center justify-center">
            <v-icon color="red" style="font-size: 60px"
              >error</v-icon
            >
          </v-card-title>
          <v-card-title class="text-center justify-center">
            Deseja remover esse item?
          </v-card-title>
          <v-divider></v-divider>
          <v-card-actions>
            <v-row dense>
              <v-col cols="6">
                <v-btn block outlined @click="dialogRemover = false">
                  <v-icon left>clear</v-icon>
                  Cancelar
                </v-btn>
              </v-col>
              <v-col cols="6">
                <v-btn block color="red" dark @click="confirmarRemover()">
                  <v-icon left>check</v-icon>
                  Confirmar
                </v-btn>
              </v-col>
            </v-row>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog width="800px" v-model="dialogFormulario" scrollable persistent :fullscreen="formFullSize">
        <v-card>
          <v-card-title
            class="py-2"
            style="background-color: #3585c4; color: #fff"
          >
            {{ util.ucWords(formulario.modo+' '+$route.name) }}
            <v-spacer></v-spacer>
            <v-btn dark icon @click="dialogFormulario = false">
              <v-icon>clear</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text class="py-3">
            <v-form v-model="validacaoForm" ref="validacaoForm">
              <slot name="formulario" v-bind:formulario="formulario"></slot>
            </v-form>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              small
              color="primary"
              dark
              outlined
              @click="
                dialogFormulario = false;
                editar(formulario.id);
              "
              v-show="formulario.modo == 'VISUALIZAR'"
            >
              <v-icon left>edit</v-icon>
              Editar
            </v-btn>
            <v-btn
              small
              color="primary"
              :disabled="!formValido"
              @click="atualizar(formulario.id)"
              :dark="formValido"
              v-show="formulario.modo == 'EDITAR'"
            >
              <v-icon left>save</v-icon>
              Salvar
            </v-btn>
            <v-btn
              small
              color="primary"
              :disabled="!formValido"
              @click="cadastrar()"
              :dark="formValido"
              v-show="formulario.modo == 'CADASTRAR'"
            >
              <v-icon left>save</v-icon>
              Salvar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog width="800px" v-model="dialogFormularioVisualizacao" scrollable persistent>
        <v-card>
          <v-card-title
            class="py-2"
            style="background-color: #3585c4; color: #fff"
          >
            {{ util.ucWords(formulario.modo+' '+$route.name) }}
            <v-spacer></v-spacer>
            <v-btn dark icon @click="dialogFormularioVisualizacao = false">
              <v-icon>clear</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text class="py-3">
            <v-form v-model="validacaoForm" ref="validacaoForm">
              <slot name="formulario" v-bind:formulario="formulario"></slot>
            </v-form>
          </v-card-text>
        </v-card>
      </v-dialog>

      <v-container>
        <v-row dense>
          <v-col cols="12">
            <v-card class="elevation-0" style="background-color: #dfdfdf">
              <v-card-title class="pt-0">
                <v-btn @click="novo()" small color="green" dark v-show="visualizarCadastro" class="mr-2">
                  <v-icon left>add</v-icon> Novo
                </v-btn>
                <v-btn small @click="exibirFiltros = !exibirFiltros" color="primary">
                  <v-icon left>{{exibirFiltros?'clear':'filter_list'}}</v-icon>
                  Filtrar
                </v-btn>
              </v-card-title>
              <v-card-text v-show="exibirFiltros" class="pt-0">
                <v-card outlined style="background-color: #f5f5f5">
                  <v-card-text>
                    <slot name="filtros"></slot>
                  </v-card-text>
                </v-card>
              </v-card-text>
              <v-card-text class="pt-0">
                <v-card outlined>
                  <v-card-text>
                    <v-row dense>
                      <v-col cols="12" class="pb-2">
                        <v-data-table
                          :headers="cabecalho"
                          :loading="loader"
                          hide-default-footer
                          :options.sync="resultados.options"
                          no-data-text="Nenhuma Informação Encontrada."
                          loading-text="Carregando Informações..."
                          :items="resultados.data"
                          style="cursor: pointer"
                          @click:row="visualizar"
                        >
                          <template v-slot:item.acoes="{ item }">
                            <v-btn icon x-small>
                              <v-icon @click.stop.prevent="remover(item)">delete</v-icon>
                            </v-btn>
                          </template>
                        </v-data-table>
                      </v-col>
                      <v-col cols="12" class="py-4">
                        <v-divider color="#eee"></v-divider>
                      </v-col>
                      <v-col cols="12" md="2">
                        <v-select
                          label="Qtd. Por Pagina"
                          dense
                          hide-details
                          outlined
                          @input="buscar()"
                          :items="listaQtdPorPagina"
                          v-model="resultados.meta.per_page"
                        ></v-select>
                      </v-col>
                      <v-col cols="12" md="4" class="py-3 text-center">
                        <p class="my-0">
                          Exibindo itens {{ resultados.meta.from }} a {{ resultados.meta.to }} de
                          {{ resultados.meta.total }} itens
                        </p>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-pagination
                          circle
                          total-visible="6"
                          v-model="resultados.meta.current_page"
                          @input="mudarPagina($event)"
                          :length="Math.ceil(resultados.meta.total / resultados.meta.per_page)"
                        ></v-pagination>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>

    </template>
  </app>
</template>

<script>
import App from "./App.vue";
import UtilVue from "./Util.vue";
import Moment from 'moment';

export default {
  name: "LayoutBuscar",
  data() {
    return {
      exibirFiltros: false,
      dialogFormulario: false,
      dialogFormularioVisualizacao: false,
      validacaoForm: false,
      moment: Moment,
      options: null,
      listaQtdPorPagina: [6, 12, 21, 30],
      resultados: {
        data: [],
        meta: {
          current_page: 1,
          per_page: 6,
          from: 1,
          to: 6,
          total: 6,
          links: {}
        },
        filtros: {},
      },
      loader: false,
      util: UtilVue,
      formulario: {
        id: null,
        modo: "VISUALIZAR",
      },
      removerItem: {},
      dialogRemover: false,
      overlay: false,
      overlayAcesso: false,
      snackbarAcesso: false,
      snackbarSucesso: false,
      snackbarErro: false,
      mensagemSnackbar: false,
      timeout: null
    };
  },
  components: {
    app: App,
  },
  props: {
    entidade: {
      default: null,
    },
    icone: {
      default: null
    },
    tituloCabecalho: {
      default: null,
    },
    cabecalho: {
      default: null,
    },
    columnSize: {
      default: 4,
    },
    payload: {
      default: null,
    },
    busca: {
      default: null,
    },
    formValido: {
      default: false
    },
    visualizarCadastro: {
      default: true
    },
    visualizarEdicao: {
      default: true
    },
    formFullSize: {
      default: false
    }
  },
  mounted () {
    this.buscar();
  },
  watch: {
    busca: {
      deep: true,
      handler(val, oldVal) {
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => {
          this.buscar();
        }, 2000);
      }
    }
  },
  methods: {
    mudarPagina: function (pagina) {
      this.resultados.data = [];
      this.loader = true;
      axios
        .post("/" + this.entidade + "/buscar?page=" + pagina, this.resultados)
        .then((response) => {
          this.resultados = response.data;
          this.loader = false;
        }, (error) => {
          if (error.response.status == 401) {
            window.location = '/';
          }
        });
    },
    carregarMais: function (nextPageUrl) {
      if (nextPageUrl) {
        this.loader = true;
        axios
          .post(nextPageUrl, this.resultados)
          .then((response) => {
            this.resultados.data.push(...response.data.data);
            this.resultados.meta = response.data.meta;
            this.loader = false;
          }, (error) => {
            if (error.response.status == 401) {
              window.location = '/';
            }
          });
      }
    },
    buscar: function () {
      this.resultados.data = [];
      this.resultados.filtros = this.busca;
      this.loader = true;
      axios
        .post("/" + this.entidade + "/buscar", this.resultados)
        .then((response) => {
          this.resultados = response.data;
          this.loader = false;
        }, (error) => {
          if (error.response.status == 401) {
            window.location = '/';
          }
        });
    },
    novo: function () {
      this.overlayAcesso = true;
      axios
        .post("/verificar-acesso", {
          entidade: this.entidade,
          acao: "CADASTRAR",
        })
        .then(
          (response) => {
            this.formulario = {
              id: null,
              modo: "CADASTRAR",
            };
            this.dialogFormulario = true;
            this.overlayAcesso = false;
          },
          (error) => {
            if (error.response.status == 401) {
              window.location = '/';
            }
            this.snackbarAcesso = true;
          }
        );
    },
    editar: function (idSelecionado) {
      this.overlayAcesso = true;
      axios
        .post("/verificar-acesso", {
          entidade: this.entidade,
          acao: "EDITAR",
        })
        .then(
          (response) => {
            this.formulario = {
              id: idSelecionado,
              modo: "EDITAR",
            };
            this.dialogFormulario = true;
            this.overlayAcesso = false;
          },
          (error) => {
            if (error.response.status == 401) {
              window.location = '/';
            }
            this.snackbarAcesso = true;
          }
        );
    },
    visualizar: function (item) {
      if (this.visualizarEdicao) {
        this.formulario = {
          modo: "VISUALIZAR",
          id: item.id,
        };

        if (this.visualizarCadastro) {
          // Pode editar e cadastrar: exibe formulario normalmente
          this.dialogFormulario = true;
        } else {
          // Pode editar, mas nao cadastrar: exibe formulario vazio
          this.dialogFormularioVisualizacao = true;
        }
      }
    },
    remover: function (item) {
      this.overlayAcesso = true;
      axios
        .post("/verificar-acesso", {
          entidade: this.entidade,
          acao: "REMOVER",
        })
        .then(
          (response) => {
            this.removerItem = item;
            this.dialogRemover = true;
            this.overlayAcesso = false;
          },
          (error) => {
            if (error.response.status == 401) {
              window.location = '/';
            }
            this.snackbarAcesso = true;
          }
        );
    },
    confirmarRemover: function () {
      this.overlay = true;
      this.dialogRemover = false;
      axios.delete("/" + this.entidade + "/" + this.removerItem.id).then(
        (response) => {
          let ind = this.resultados.data.indexOf(this.removerItem);
          this.resultados.data.splice(ind, 1);

          this.removerItem = null;
          this.mensagemSnackbar = "Removido com sucesso!";
          this.snackbarSucesso = true;
          this.buscar();
          this.overlay = false;
        },
        (error) => {
          this.mensagemSnackbar = error.response.data.message;
          this.snackbarErro = true;
          this.overlay = false;
        }
      );
    },
    atualizar: function (id) {
      this.overlay = true;
      this.dialogFormulario = false;
      axios.put("/" + this.entidade, this.payload).then(
        (response) => {
          this.mensagemSnackbar = "Atualizado com sucesso!";
          this.snackbarSucesso = true;
          this.overlay = false;
          this.buscar();
        },
        (error) => {
          if (error.response.status == 401) {
            window.location = '/';
          }
          this.dialogFormulario = true;
          this.mensagemSnackbar = error.response.data.message;
          this.snackbarErro = true;
        }
      );
    },
    cadastrar: function (id) {
      this.overlay = true;
      this.dialogFormulario = false;
      axios.post("/" + this.entidade, this.payload).then(
        (response) => {
          this.mensagemSnackbar = "Salvo com sucesso!";
          this.snackbarSucesso = true;
          this.overlay = false;
          this.$parent.payload = null;
          this.buscar();
        },
        (error) => {
          if (error.response.status == 401) {
            window.location = '/';
          }
          this.dialogFormulario = true;
          this.mensagemSnackbar = error.response.data.message;
          this.snackbarErro = true;
        }
      );
    },
    recarregarPagina: function () {
      if (!this.snackbarAcesso) {
        this.$router.go();
      }
    },
  },
};
</script>