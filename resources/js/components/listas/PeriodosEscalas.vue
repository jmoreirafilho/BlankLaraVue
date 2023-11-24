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
      loader: false
    };
  },
  mounted () {
    this.loader = true;
    axios.post('/periodos_escalas/buscar', {}).then((response) => {
      this.items = response.data.data;
      this.loader = false;
    });
  }
};
</script>