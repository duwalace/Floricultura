$(document).ready(() => {
  // Mostrar/ocultar senha
  $(".mostrar-senha").click(function () {
    const input = $(this).closest(".input-group").find("input")
    const icon = $(this).find("i")

    if (input.attr("type") === "password") {
      input.attr("type", "text")
      icon.removeClass("fa-eye").addClass("fa-eye-slash")
    } else {
      input.attr("type", "password")
      icon.removeClass("fa-eye-slash").addClass("fa-eye")
    }
  })

  // Atualizar contador do carrinho
  function atualizarContadorCarrinho() {
    $.ajax({
      url: "ajax/contar-itens-carrinho.php",
      type: "GET",
      dataType: "json",
      success: (response) => {
        $(".carrinho-contador").text(response.quantidade)
      },
    })
  }

  // Adicionar produto ao carrinho
  $(".adicionar-carrinho").click(function () {
    const produtoId = $(this).data("id")

    $.ajax({
      url: "ajax/adicionar-ao-carrinho.php",
      type: "POST",
      data: { produto_id: produtoId, quantidade: 1 },
      dataType: "json",
      success: (response) => {
        if (response.status === "success") {
          alert("Produto adicionado ao carrinho!")
          atualizarContadorCarrinho()
        } else {
          alert("Erro ao adicionar produto ao carrinho.")
        }
      },
    })
  })

  // Adicionar produto ao carrinho com quantidade específica
  $(".adicionar-carrinho-qtd").click(function () {
    const produtoId = $(this).data("id")
    const quantidade = Number.parseInt($(".quantidade-produto").val())

    $.ajax({
      url: "ajax/adicionar-ao-carrinho.php",
      type: "POST",
      data: { produto_id: produtoId, quantidade: quantidade },
      dataType: "json",
      success: (response) => {
        if (response.status === "success") {
          alert("Produto adicionado ao carrinho!")
          atualizarContadorCarrinho()
        } else {
          alert("Erro ao adicionar produto ao carrinho.")
        }
      },
    })
  })

  // Aumentar/diminuir quantidade no detalhe do produto
  $(".aumentar-quantidade").click(() => {
    const input = $(".quantidade-produto")
    const valor = Number.parseInt(input.val())
    input.val(valor + 1)
  })

  $(".diminuir-quantidade").click(() => {
    const input = $(".quantidade-produto")
    const valor = Number.parseInt(input.val())
    if (valor > 1) {
      input.val(valor - 1)
    }
  })

  // Atualizar quantidade no carrinho
  $(".atualizar-quantidade").click(function () {
    const produtoId = $(this).data("id")
    const acao = $(this).data("acao")
    const input = $(this).closest(".input-group").find(".quantidade-carrinho")
    let quantidade = Number.parseInt(input.val())

    if (acao === "aumentar") {
      quantidade += 1
    } else if (acao === "diminuir" && quantidade > 1) {
      quantidade -= 1
    }

    input.val(quantidade)

    $.ajax({
      url: "ajax/atualizar-carrinho.php",
      type: "POST",
      data: { produto_id: produtoId, quantidade: quantidade },
      dataType: "json",
      success: (response) => {
        if (response.status === "success") {
          location.reload()
        } else {
          alert("Erro ao atualizar carrinho.")
        }
      },
    })
  })

  // Atualizar quantidade ao mudar o valor do input
  $(".quantidade-carrinho").change(function () {
    const produtoId = $(this).data("id")
    const quantidade = Number.parseInt($(this).val())

    if (quantidade < 1) {
      $(this).val(1)
      return
    }

    $.ajax({
      url: "ajax/atualizar-carrinho.php",
      type: "POST",
      data: { produto_id: produtoId, quantidade: quantidade },
      dataType: "json",
      success: (response) => {
        if (response.status === "success") {
          location.reload()
        } else {
          alert("Erro ao atualizar carrinho.")
        }
      },
    })
  })

  // Remover item do carrinho
  $(".remover-item").click(function () {
    if (confirm("Tem certeza que deseja remover este item do carrinho?")) {
      const produtoId = $(this).data("id")

      $.ajax({
        url: "ajax/remover-do-carrinho.php",
        type: "POST",
        data: { produto_id: produtoId },
        dataType: "json",
        success: (response) => {
          if (response.status === "success") {
            location.reload()
          } else {
            alert("Erro ao remover item do carrinho.")
          }
        },
      })
    }
  })

  // Limpar carrinho
  $(".limpar-carrinho").click(() => {
    if (confirm("Tem certeza que deseja limpar o carrinho?")) {
      $.ajax({
        url: "ajax/limpar-carrinho.php",
        type: "POST",
        dataType: "json",
        success: (response) => {
          if (response.status === "success") {
            location.reload()
          } else {
            alert("Erro ao limpar carrinho.")
          }
        },
      })
    }
  })

  // Inicializa o contador do carrinho
  atualizarContadorCarrinho()
})

