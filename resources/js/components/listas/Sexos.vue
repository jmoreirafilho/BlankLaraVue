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
      {chave: 'F', valor: 'Feminino'},
      {chave: 'M', valor: 'Masculino'}
    ];
  }
};
</script>