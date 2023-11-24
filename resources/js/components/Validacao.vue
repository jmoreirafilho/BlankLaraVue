<script>
export default {
  required: function (value) {
    if (!value) {
      return "Campo obrigatório."
    }
    return true;
  },
  requiredNumber: function (value) {
    if((value+'').length > 0 && value >= 0) {
      return true;
    }
    return "Campo obrigatório";
  },
  requiredObject: function (value) {
    if(Object.keys(value).length == 0) {
      return "Campo obrigatório";
    }
    return true;
  },
  matchPasswords: function (password, confirmationPassword) {
    if (password != confirmationPassword) {
      return "Senhas diferentes."
    }
    return true;
  },
  requiredIf: function (dependente, valor) {
    if (dependente) {
      if (valor) {
        return true;
      }
      return "Campo Obrigatório";
    }
    return true;
  },
  requiredAndNotNull: function (value) {
    if (value && (value.trim()).length > 0) {
      return true;
    }
    return "Campo Obrigatório!";
  },
  requiredList: function (list, message) {
    if (list && list.length > 0) {
      return true;
    }
    return message;
  },
  minSize: function (tamanho, valor) {
      if (valor) {
        if (valor.length < tamanho) {
          return "Quantidade mínima de caracteres: "+tamanho;
        }
        return true;
      }
      return true;
  },
  maxSize: function (tamanho, valor) {
      if (valor) {
        if (valor.length > tamanho) {
          return "Quantidade máxima de caracteres: "+tamanho;
        }
        return true;
      }
      return true;
  },
  validarData: function (valor) {
    if (valor) {
      if(valor.length < 10) {
        return "Formato esperado: DD/MM/YYYY"
      }
      
      let dia = valor.substr(0,2);
      let mes = valor.substr(3,2);
      let ano = valor.substr(-4);
      
      if (Number(dia) < 1 || Number(dia) > 31) {
        return "Dia inválido";
      }
      if (Number(mes) < 1 || Number(mes) > 12) {
        return "Mês inválido";
      }
      if (Number(ano) < 1000) {
        return "Ano inválido";
      }
    }
    return true;
  },
  validarHorario: function(valor) {
    if (valor) {
      if (valor.length < 8) {
        return "Formato esperado: HH:MM:SS"
      }
      
      let hr = valor.substr(0,2);
      let min = valor.substr(3,2);
      let seg = valor.substr(-2);

      if (Number(hr) > 23) {
        return "Hora inválida";
      }
      if (Number(min) > 59) {
        return "Minutos inválidos";
      }
      if (Number(seg) > 59) {
        return "Segundos inválidos";
      }
    }
    return true;
  },
  validarDataHora: function(valor) {
    if (valor) {
      if (valor.length < 5) {
        return "Formato esperado: HH:MM"
      }
      
      let hr = valor.substr(0,2);
      let min = valor.substr(3,2);

      if (Number(hr) > 23) {
        return "Hora inválida";
      }
      if (Number(min) > 59) {
        return "Minutos inválidos";
      }
    }
    return true;
  }
};
</script>