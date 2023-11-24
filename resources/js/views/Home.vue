<template>
  <app>
    <template slot="content">
    </template>
  </app>
</template>

<script>
import App from '../components/App.vue';

export default {
  data() {
    return {
      overlay: false
    };
  },
  components: {
    app: App
  },
  methods: {
    goToHome: function() {
      this.$router.push('/home');
    }
  }
};
</script>