<template>
  <v-autocomplete
    v-bind="$attrs"
    @input="$emit('input', $event)"
    :items="items"
    :loading="loader"
    item-value="id"
    item-text="nome"
  ></v-autocomplete>
</template>

<script>
export default {
  data() {
    return {
      items: [],
      loader: false,
      filtro: {
        autor: true
      }
    };
  },
  mounted () {
    this.buscar();
  },
  methods: {
    buscar: function () {
      this.loader = true;
      axios.post('/clientes/buscar', this.filtro).then((response) => {
        this.items = response.data.data;
        this.loader = false;
      });
    }
  }
};
</script>