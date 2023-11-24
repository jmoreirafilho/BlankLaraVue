<template>
  <div style="position: relative">
    <center>
      <v-img
        rounded
        :src="image"
        @click="$attrs.readonly?'':$refs.FileInput.click()"
        width="180px"
        height="180px"
        style="cursor: pointer; background-color: #666"
      ></v-img>
      <v-btn small style="position: absolute; top: 8px; right: 8px" color="red" fab dark @click="removerImagem()" v-show="$attrs.readonly != true">
        <v-icon>delete</v-icon>
      </v-btn>
      <input ref="FileInput" type="file" style="display: none;" @change="onFileSelect" />
      <v-progress-circular v-show="loader" style="position: absolute; top: 20px; left: 20px; height: 140px; width: 140px" indeterminate size="64"></v-progress-circular>
    </center>
    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-card-text>
          <VueCropper v-show="selectedFile" ref="cropper" :src="selectedFile" alt="Source Image"></VueCropper>
        </v-card-text>
        <v-card-actions>
          <v-btn class="primary" @click="saveImage(), (dialog = false)">Cortar Imagem</v-btn>
          <v-btn color="primary" text @click="dialog = false">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import VueCropper from 'vue-cropperjs'
import 'cropperjs/dist/cropper.css'

export default {
  components: { VueCropper },
  data() {
    return {
      mime_type: '',
      cropedImage: '',
      autoCrop: false,
      selectedFile: '',
      image: '',
      dialog: false,
      files: '',
      loader: false
    }
  },
  mounted () {
    if (this.$attrs.value) {
      this.loader = true;
      axios.get('/get_url/'+this.$attrs.value).then((response) => {
        this.image = response.data;
        this.loader = false;
      });
    }
  },
  methods: {
    removerImagem: function () {
      this.image = null;
      this.$emit('input', null);
      this.$emit('remover');
    },
    saveImage() {
      this.loader = true;
      this.image = this.$refs.cropper.getCroppedCanvas().toDataURL();
      this.$refs.cropper.getCroppedCanvas().toBlob((blob) => {
        this.uploadImagem(blob);
      });
    },
    uploadImagem: function (blob) {
      let formData = new FormData();
      formData.append("file", blob);

      axios
        .post("/upload_imagem", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(
          (response) => {
            this.salvoComSucesso = true;
            this.$emit('input', response.data);
            this.loader = false;
          },
          (error) => {
            this.salvoComSucesso = error.response.data.message;
          }
        );
    },
    onFileSelect(e) {
      const file = e.target.files[0];
      this.mime_type = file.type
      if (typeof FileReader === 'function') {
        this.dialog = true;
        const reader = new FileReader();
        reader.onload = (event) => {
          this.selectedFile = event.target.result
          this.$refs.cropper.replace(this.selectedFile)
        }
        reader.readAsDataURL(file);
      } else {
        alert('Sorry, FileReader API not supported')
      }
    },
  },
}
</script>
<style scoped>
.profile-img {
  height: 100%;
  width: 100%;
  border-radius: 50%;
}
.icon {
  position: absolute;
  top: 10px;
  right: 0;
  background: #e2e2e2;
  border-radius: 100%;
  width: 30px;
  height: 30px;
  line-height: 30px;
  vertical-align: middle;
  text-align: center;
  color: #0000ff;
  font-size: 14px;
  cursor: pointer;
}
</style>