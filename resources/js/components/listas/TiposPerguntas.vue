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
      {chave: 'ARQUIVO', valor: 'Upload de Arquivos'},
      {chave: 'OPCOES', valor: 'Seleção de Oções'},
      {chave: 'TEXTO', valor: 'Informar Texto'}
    ];
  }
};
</script>