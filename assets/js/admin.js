import $ from "jquery"

$(document).ready(() => {

  setTimeout(() => {
    $(".alert").fadeOut("slow")
  }, 5000)

  $(".btn-excluir").click((e) => {
    if (!confirm("Tem certeza que deseja excluir este item?")) {
      e.preventDefault()
    }
  })

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

