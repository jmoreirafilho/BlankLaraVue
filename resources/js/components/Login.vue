<template>
    <v-app style="background-color: #dfdfdf">
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
  
      <v-main>
        <v-container fluid fill-height>
          <v-layout align-center justify-center>
            <v-flex xs12 md5 sm6 lg4>
              <v-card class="elevation-0" outlined>
                <v-card-text class="my-7">
                  <center>
                    <v-img src="/images/logo.png"></v-img>
                  </center>
                </v-card-text>
                <v-card-text class="text-center" style="font-size: 20px; font-weight: 100; font-family: Roman; background-color: #0E0E52; color: #FFF">
                  LOGIN 
                </v-card-text>
                <v-card-text class="pb-0">
                  <v-form v-model="form">
                    <v-row dense>
                      <v-col cols="12">
                        <v-text-field
                          prepend-inner-icon="email"
                          outlined
                          name="email"
                          dense hide-details
                          :rules="[validacao.requiredAndNotNull(formLogin.email)]"
                          label="E-mail"
                          v-model="formLogin.email"
                          type="email"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field
                          id="password"
                          outlined hide-details
                          dense
                          prepend-inner-icon="lock"
                          :rules="[validacao.requiredAndNotNull(formLogin.password)]"
                          v-model="formLogin.password"
                          name="password"
                          label="Senha"
                          type="password"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-card-text>
                <v-card-text v-show="error" class="pb-0">
                  <v-alert
                    type="error"
                    v-model="error"
                  >
                    {{ errorMessage }}
                  </v-alert>
                </v-card-text>
                <v-card-actions>
                  <v-row dense>
                    <v-col cols="12">
                      <v-btn block color="primary" outlined :disabled="!form" @click="entrar()">
                        <v-icon left>login</v-icon>
                        Entrar
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </v-main>
    </v-app>
  </template>
  
  <script>
  import ValidacaoVue from './Validacao.vue';
  export default {
    name: "Login",
    data() {
      return {
        validacao: ValidacaoVue,
        form: false,
        formLogin: {},
        overlay: false,
        errorMessage: null,
        error: false
      };
    },
    methods: {
      entrar: function () {
        this.overlay = true;
        axios.post("/login", this.formLogin).then(
          (response) => {
            window.location.href = "/";
          },
          (error) => {
            this.errorMessage = error.response.data.message;
            this.overlay = false;
            this.error = true;
          }
        );
      },
    },
  };
  </script>