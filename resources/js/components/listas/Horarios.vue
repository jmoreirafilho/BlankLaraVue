<template>
  <v-autocomplete
    v-bind="$attrs"
    @input="$emit('input', $event)"
    :items="items"
    :loading="loader"
    item-value="horario"
    item-text="horario"
  ></v-autocomplete>
</template>

<script>
export default {
  data() {
    return {
      items: [],
      loader: false,
      filtro: {}
    };
  },
  methods: {
    buscar: function () {
      this.loader = true;
      axios.post('/registro_ponto/buscarHorariosApontados', this.filtro).then((response) => {
        this.items = response.data;
        this.loader = false;
      });
    }
  }
};
</script>