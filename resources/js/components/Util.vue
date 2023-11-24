<script>
import Moment from "moment";
export default {
  moment: Moment,
  formatarInteiroDecimal: function (numero) {
    if ((numero+'').indexOf('.') >= 0) {
      return parseFloat(Number(numero)).toFixed(2).replaceAll('.', ',').replace(/\d(?=(\d{3})+\,)/g, '$&.');
    }
    return (Number(numero)+'').replaceAll('.', ',');
  },
  formatarDecimal: function (numero) {
    return parseFloat(Number(numero)).toFixed(2).replaceAll('.', ',').replace(/\d(?=(\d{3})+\,)/g, '$&.');
  },
  dinheiroParaNumero: function (valor) {
    return Number(valor.substr(3).replace(".", "").replaceAll(",", "."));
  },
  numeroParaDinheiro: function (valor) {
    let val = parseFloat(Number(valor)).toFixed(2).replaceAll(".", ",");
    return val;
  },
  formatarData: function (valor) {
    if (valor) {
      if (valor.indexOf("-") >= 0) {
        // Formato atual: YYYY-MM-DD
        return this.moment(valor, "YYYY-MM-DD").format("DD/MM/YYYY");
      }
      return valor;
    }
    return "";
  },
  ucWords: function (frase) {
    if (frase) {
      let novaFrase = "";
      for (const palavra of frase.split(" ")) {
        novaFrase += (palavra[0]?palavra[0].toUpperCase():'') + palavra.substr(1).toLowerCase() + "##";
      }

      return novaFrase.replaceAll("##", " ");
    }
  },
  formatarTamanhoArquivo: function (tamanho) {
    if (tamanho > 999999) {
      return parseFloat(tamanho/1000/1000).toFixed(2)+' MB';
    } else {
      return parseFloat(tamanho/1000).toFixed(2)+' kB';
    }
  },
  formatarDinheiro: function (numero) {
    if (!numero) {return 'R$ 0,00';}
    return Number(numero).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL', minimumFractionDigits: 2, maximumFractionDigits: 2});
  },
  formatarDinheiroFull: function (numero) {
    if (!numero) {return 'R$ 0,0000';}
    return Number(numero).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL', minimumFractionDigits: 4, maximumFractionDigits: 4});
  },
  horarioParaMinutos: function (horario) {
    let h = Number(horario.split(":")[0]);
    let m = Number(horario.split(":")[1]);

    return Number((h * 60) + m);
  },
  minutosParaHorario: function (minutos) {
    let h = parseInt(minutos / 60);
    let m = (minutos - (h * 60));

    let horario = h+':'+m;

    return horario;
  }
};
</script>