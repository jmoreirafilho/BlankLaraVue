<template>
  <div>
    <v-text-field
      v-bind="$attrs"
      @click="datepickerModal = true"
      append-icon="event"
      readonly
      :value="data"
      @click:clear="limpar()"
    ></v-text-field>
    <v-dialog ref="dialog" v-model="datepickerModal" width="290px">
      <v-date-picker
        next-icon="keyboard_arrow_right"
        prev-icon="keyboard_arrow_left"
        locale="pt-br"
        range
        v-model="dates"
        @change="datasFormatadas()"
        scrollable
      ></v-date-picker>
    </v-dialog>
  </div>
</template>

<script>
import Moment from 'moment';
export default {
  data() {
    return {
      moment: Moment,
      dates: [],
      data: '',
      datepickerModal: false
    };
  },
  methods: {
    datasFormatadas: function() {
      this.data = this.moment(this.dates[0]).format('DD/MM/YYYY')+' ~ '+this.moment(this.dates[1]).format('DD/MM/YYYY');
      this.$emit('input', this.data);
    },
    limpar: function () {
      this.dates = [];
      this.$emit('input', this.dates);
    }
  },
  watch: {
    dates: function (val, oldVal) {
      if (val && val != oldVal) {
        this.datasFormatadas();
      }
    }
  }
};
</script>