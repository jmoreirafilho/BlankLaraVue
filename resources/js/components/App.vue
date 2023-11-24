<template>
  <v-app style="background-color: #dfdfdf">
    <v-overlay :value="loader" style="z-index: 20">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>

    <v-app-bar
        app
        color="#0E0E52"
        class="elevation-1"
      >
      <v-toolbar-title style="color: #FFF">
        {{ $route.name }}
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-menu bottom left offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on">
            <v-icon style="color: #FFF">mdi-dots-vertical</v-icon>
          </v-btn>
        </template>
        <v-list dense width="200px">
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                {{usuarioLogado.usuario.nome}}
              </v-list-item-title>
              <v-list-item-subtitle>
                {{usuarioLogado.usuario.email}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
    
          <v-divider class="my-2"></v-divider>

          <v-list-item style="cursor: pointer" @click="logout()">
            <v-list-item-icon>
              <v-icon>logout</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Sair</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <menu-drawer ref="menu"></menu-drawer>
    
    <v-content>
      <v-container fluid>
          <slot name="content"></slot>
      </v-container>
    </v-content>

    <v-footer
      color="#3585c4"
      style="color: #fff"
      app
    >
      <span>&copy; 2023 | v1.0.0_00</span>
      <v-spacer></v-spacer>
      <span>Criado Por <a style="color: #FFF" href="https://inovacertosolutions.com.br">InovaCertoSolutions</a></span>
    </v-footer>
  </v-app>
  </template>
  
  <script>
import Menu from './Menu.vue';

  
  export default {
    data() {
      return {
        loader: false,
        usuarioLogado: {
          usuario: {},
          menu: []
        }
      };
    },
    components: {
      'menu-drawer': Menu
    },
    mounted () {
      this.buscarUsuario();
    },
    methods: {
      logout: function () {
        this.loader = true;
        axios.post('/logout', {}).then((response) => {
          window.location = '/';
        });
      },
      buscarUsuario: function () {
        this.loader = true;
        axios.post('/usuario-logado', {}).then((response) => {
          this.usuarioLogado = response.data;
          this.$refs.menu.menus = this.usuarioLogado.menus;
          this.loader = false;
        }, (error) => {
          this.logout();
        });
      }
    }
  };
  </script>