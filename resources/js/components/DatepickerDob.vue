<template>
  <div>
    <v-text-field
      v-bind="$attrs"
      :label="texto"
      append-icon="event"
      :clearable="!leitura"
      clear-icon="clear"
      @click:clear="limpar()"
      outlined
      dense
      :value="data_datepicker_visual"
      readonly
      @click="leitura?datepickerModal=false:datepickerModal=true"
    ></v-text-field>
    <v-dialog ref="dialog" v-model="datepickerModal" width="290px">
      <v-date-picker
        next-icon="keyboard_arrow_right"
        prev-icon="keyboard_arrow_left"
        locale="pt-br"
        :max="moment().format('YYYY-MM-DD')"
        :active-picker.sync="activePicker"
        v-model="data_datepicker"
        scrollable
      ></v-date-picker>
    </v-dialog>
  </div>
</template>

<script>
import Moment from "moment";
export default {
  data() {
    return {
      datepickerModal: false,
      minDate: Moment().format("YYYY-MM-DD"),
      data_datepicker: null,
      data_datepicker_visual: null,
      moment: Moment,
      activePicker: null
    };
  },
  props: {
    leitura: {
      default: false
    },
    texto: {
      default: "Data Para Pagamento"
    },
    init: {
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
      this.data_datepicker_visual = "";
    },
    load: function (val) {
      if (val != null) {
        if (val.indexOf('-') >= 0) {
          this.data_datepicker = val;
        } else {
          this.data_datepicker = this.moment(val, 'DD/MM/YYYY').format('YYYY-MM-DD');
        }
      }
    }
  },
  watch: {
    data_datepicker: function(val, oldVal) {
      if (val != null) {
        this.data_datepicker_visual = this.moment(val).format('DD/MM/YYYY');
        this.$emit('input', this.data_datepicker_visual);
        this.datepickerModal = false;
      } else {
        this.$emit('input', null);
      }
    },
    init: function (val, oldVal) {
      this.load(val);
    },
    datepickerModal: function (val) {
      if (val) {
        setTimeout(() => (this.activePicker = 'YEAR'))
      }
    }
  }
};
</script>