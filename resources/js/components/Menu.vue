<template>
    <v-navigation-drawer v-bind="$attrs" @input="$emit('input', $event)" app width="350px" permanent expand-on-hover>
      <v-overlay :value="loader">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      
      <v-list nav dense>
        <center>
          <v-img width="100%" class="my-7" @click="goToHome()" src="/images/logo_vertical.png"></v-img>
        </center>
        
        <v-divider class="my-5"></v-divider>

        <v-list-group v-for="(menu, iMenu) in menus" :key="iMenu" color="primary">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon>{{menu.icone}}</v-icon>
            </v-list-item-icon>
            <v-list-item-title>{{menu.titulo}}</v-list-item-title>
          </template>
          <v-list-item style="text-decoration: none" link v-for="(itemMenu, iItemMenu) in menu.items" :key="iItemMenu" :to="itemMenu.link">
            <v-list-item-title class="pl-4">{{itemMenu.titulo}}</v-list-item-title>
            <v-list-item-icon>
              <v-icon>{{itemMenu.icone}}</v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>
  </template>
  
  <script>
  export default {
    data() {
      return {
        loader: false,
        menus: []
      };
    },
    methods: {
      goToHome: function() {
        this.$router.push('/home');
      }
    }
  };
  </script>