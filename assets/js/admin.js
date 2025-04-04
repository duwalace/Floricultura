import $ from "jquery"

$(document).ready(() => {
  // Fechar alertas automaticamente após 5 segundos
  setTimeout(() => {
    $(".alert").fadeOut("slow")
  }, 5000)

  // Confirmação para exclusão
  $(".btn-excluir").click((e) => {
    if (!confirm("Tem certeza que deseja excluir este item?")) {
      e.preventDefault()
    }
  })

  // Preview de imagem ao selecionar arquivo
  $('input[type="file"]').change(function () {
    const file = this.files[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (e) => {
        $("#preview-imagem").attr("src", e.target.result).show()
      }
      reader.readAsDataURL(file)
    }
  })
})

