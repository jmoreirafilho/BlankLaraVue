<template>
  <v-select
    v-bind="$attrs"
    @input="$emit('input', $event)"
    :items="items"
    item-value="chave"
    item-text="valor"
  ></v-select>
</template>

<script>
export default {
  data() {
    return {
      items: []
    };
  },
  mounted () {
    this.items = [
      {chave: 'S', valor: 'Sim'},
      {chave: 'N', valor: 'Não'}
    ];
  }
};
</script>