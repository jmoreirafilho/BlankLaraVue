<template>
  <div>
    <v-text-field
      v-bind="$attrs"
      append-icon="alarm"
      :clearable="!leitura"
      clear-icon="clear"
      @click:clear="limpar()"
      :outlined="outlined"
      dense
      v-model="data_datepicker"
      readonly
      @click="leitura?timePickerModel=false:timePickerModel=true"
    ></v-text-field>
    <v-dialog ref="dialog" v-model="timePickerModel" width="290px">
      <v-time-picker :min="minDate" :max="maxDate" format="24hr" v-model="data_datepicker" full-width></v-time-picker>
    </v-dialog>
  </div>
</template>

<script>
import Moment from "moment";
export default {
  data() {
    return {
      timePickerModel: false,
      data_datepicker: null,
      moment: Moment
    };
  },
  props: {
    leitura: {
      default: false
    },
    init: {
      default: null
    },
    outlined: {
      default: true,
      type: Boolean
    },
    minDate: {
      default: null
    },
    maxDate: {
      default: null
    }
  },
  mounted () {
    if (this.init != null) {
      this.load(this.init);
    }
  },
  methods: {
    limpar: function () {
      this.data_datepicker = null;
    },
    load: function (val) {
      if (val != null) {
        this.data_datepicker = val;
      }
    }
  },
  watch: {
    data_datepicker: function(val, oldVal) {
      this.$emit('input', val);
    },
    init: function (val, oldVal) {
      this.load(val);
    }
  }
};
</script>