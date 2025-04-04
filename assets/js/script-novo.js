document.addEventListener("DOMContentLoaded", () => {
    // Verificar se jQuery está carregado
    if (typeof jQuery === "undefined") {
      console.error("jQuery não está carregado! O script não funcionará corretamente.")
      return
    }
  
    // Mostrar/ocultar senha
    $(".toggle-password").click(function () {
      const input = $(this).closest(".form-control").find("input")
  
      if (input.attr("type") === "password") {
        input.attr("type", "text")
        $(this).removeClass("fa-eye").addClass("fa-eye-slash")
      } else {
        input.attr("type", "password")
        $(this).removeClass("fa-eye-slash").addClass("fa-eye")
      }
    })
  
    // Abrir modal de login
    $("#btnLogin, #btnLoginComprar").click((e) => {
      e.preventDefault()
      $("#modalLogin").addClass("active")
    })
  
    // Fechar modal de login
    $("#closeLogin").click(() => {
      $("#modalLogin").removeClass("active")
    })
  
    // Abrir modal de cadastro
    $("#btnShowCadastro").click((e) => {
      e.preventDefault()
      $("#modalLogin").removeClass("active")
      $("#modalCadastro").addClass("active")
    })
  
    // Fechar modal de cadastro
    $("#closeCadastro").click(() => {
      $("#modalCadastro").removeClass("active")
    })
  
    // Voltar para o login
    $("#btnShowLogin").click((e) => {
      e.preventDefault()
      $("#modalCadastro").removeClass("active")
      $("#modalLogin").addClass("active")
    })
  
    // Fechar modais ao clicar fora
    $(window).click((e) => {
      if ($(e.target).hasClass("modal-login")) {
        $("#modalLogin").removeClass("active")
      }
      if ($(e.target).hasClass("modal-cadastro")) {
        $("#modalCadastro").removeClass("active")
      }
    })
  
    // Processar formulário de login via AJAX
    $("#loginForm").on("submit", function (e) {
      e.preventDefault()
      console.log("Formulário de login enviado")
  
      // Obter o caminho base do site
      const baseUrl = window.location.pathname.includes("/admin/") ? "../" : ""
  
      $.ajax({
        url: baseUrl + "ajax/processar-login.php",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: (response) => {
          console.log("Resposta do login:", response)
          if (response.status === "success") {
            window.location.reload()
          } else {
            alert(response.message || "Erro ao fazer login. Tente novamente.")
          }
        },
        error: (xhr, status, error) => {
          console.error("Erro na requisição AJAX:", error)
          console.error("Resposta do servidor:", xhr.responseText)
          alert("Erro ao processar o login. Por favor, tente novamente.")
        },
      })
    })
  
    // Processar formulário de cadastro via AJAX
    $("#cadastroForm").on("submit", function (e) {
      e.preventDefault()
      console.log("Formulário de cadastro enviado")
  
      // Obter o caminho base do site
      const baseUrl = window.location.pathname.includes("/admin/") ? "../" : ""
  
      $.ajax({
        url: baseUrl + "ajax/processar-cadastro.php",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: (response) => {
          console.log("Resposta do cadastro:", response)
          if (response.status === "success") {
            alert("Cadastro realizado com sucesso! Faça login para continuar.")
            $("#modalCadastro").removeClass("active")
            $("#modalLogin").addClass("active")
          } else {
            alert(response.message || "Erro ao realizar cadastro. Tente novamente.")
          }
        },
        error: (xhr, status, error) => {
          console.error("Erro na requisição AJAX:", error)
          console.error("Resposta do servidor:", xhr.responseText)
          alert("Erro ao processar o cadastro. Por favor, tente novamente.")
        },
      })
    })
  
    // Atualizar contador do carrinho
    function atualizarContadorCarrinho() {
      // Obter o caminho base do site
      const baseUrl = window.location.pathname.includes("/admin/") ? "../" : ""
  
      $.ajax({
        url: baseUrl + "ajax/contar-itens-carrinho.php",
        type: "GET",
        dataType: "json",
        success: (response) => {
          $(".carrinho-contador").text(response.quantidade)
        },
        error: (xhr, status, error) => {
          console.error("Erro ao atualizar contador do carrinho:", error)
        },
      })
    }
  
    // Adicionar produto ao carrinho
    $(".adicionar-carrinho").click(function () {
      const produtoId = $(this).data("id")
      const baseUrl = window.location.pathname.includes("/admin/") ? "../" : ""
  
      $.ajax({
        url: baseUrl + "ajax/adicionar-ao-carrinho.php",
        type: "POST",
        data: { produto_id: produtoId, quantidade: 1 },
        dataType: "json",
        success: (response) => {
          if (response.status === "success") {
            alert("Produto adicionado ao carrinho!")
            atualizarContadorCarrinho()
          } else {
            alert(response.message || "Erro ao adicionar produto ao carrinho.")
          }
        },
        error: (xhr, status, error) => {
          console.error("Erro na requisição AJAX:", error)
          alert("Erro ao adicionar produto ao carrinho. Por favor, tente novamente.")
        },
      })
    })
  
    // Adicionar produto ao carrinho com quantidade específica
    $(".adicionar-carrinho-qtd").click(function () {
      const produtoId = $(this).data("id")
      const quantidade = Number.parseInt($(".quantidade-produto").val())
      const baseUrl = window.location.pathname.includes("/admin/") ? "../" : ""
  
      $.ajax({
        url: baseUrl + "ajax/adicionar-ao-carrinho.php",
        type: "POST",
        data: { produto_id: produtoId, quantidade: quantidade },
        dataType: "json",
        success: (response) => {
          if (response.status === "success") {
            alert("Produto adicionado ao carrinho!")
            atualizarContadorCarrinho()
          } else {
            alert(response.message || "Erro ao adicionar produto ao carrinho.")
          }
        },
        error: (xhr, status, error) => {
          console.error("Erro na requisição AJAX:", error)
          alert("Erro ao adicionar produto ao carrinho. Por favor, tente novamente.")
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
      const baseUrl = window.location.pathname.includes("/admin/") ? "../" : ""
  
      if (acao === "aumentar") {
        quantidade += 1
      } else if (acao === "diminuir" && quantidade > 1) {
        quantidade -= 1
      }
  
      input.val(quantidade)
  
      $.ajax({
        url: baseUrl + "ajax/atualizar-carrinho.php",
        type: "POST",
        data: { produto_id: produtoId, quantidade: quantidade },
        dataType: "json",
        success: (response) => {
          if (response.status === "success") {
            location.reload()
          } else {
            alert(response.message || "Erro ao atualizar carrinho.")
          }
        },
        error: (xhr, status, error) => {
          console.error("Erro na requisição AJAX:", error)
          alert("Erro ao atualizar carrinho. Por favor, tente novamente.")
        },
      })
    })
  
    // Atualizar quantidade ao mudar o valor do input
    $(".quantidade-carrinho").change(function () {
      const produtoId = $(this).data("id")
      const quantidade = Number.parseInt($(this).val())
      const baseUrl = window.location.pathname.includes("/admin/") ? "../" : ""
  
      if (quantidade < 1) {
        $(this).val(1)
        return
      }
  
      $.ajax({
        url: baseUrl + "ajax/atualizar-carrinho.php",
        type: "POST",
        data: { produto_id: produtoId, quantidade: quantidade },
        dataType: "json",
        success: (response) => {
          if (response.status === "success") {
            location.reload()
          } else {
            alert(response.message || "Erro ao atualizar carrinho.")
          }
        },
        error: (xhr, status, error) => {
          console.error("Erro na requisição AJAX:", error)
          alert("Erro ao atualizar carrinho. Por favor, tente novamente.")
        },
      })
    })
  
    // Remover item do carrinho
    $(".remover-item").click(function () {
      if (confirm("Tem certeza que deseja remover este item do carrinho?")) {
        const produtoId = $(this).data("id")
        const baseUrl = window.location.pathname.includes("/admin/") ? "../" : ""
  
        $.ajax({
          url: baseUrl + "ajax/remover-do-carrinho.php",
          type: "POST",
          data: { produto_id: produtoId },
          dataType: "json",
          success: (response) => {
            if (response.status === "success") {
              location.reload()
            } else {
              alert(response.message || "Erro ao remover item do carrinho.")
            }
          },
          error: (xhr, status, error) => {
            console.error("Erro na requisição AJAX:", error)
            alert("Erro ao remover item do carrinho. Por favor, tente novamente.")
          },
        })
      }
    })
  
    // Limpar carrinho
    $(".limpar-carrinho").click(() => {
      if (confirm("Tem certeza que deseja limpar o carrinho?")) {
        const baseUrl = window.location.pathname.includes("/admin/") ? "../" : ""
  
        $.ajax({
          url: baseUrl + "ajax/limpar-carrinho.php",
          type: "POST",
          dataType: "json",
          success: (response) => {
            if (response.status === "success") {
              location.reload()
            } else {
              alert(response.message || "Erro ao limpar carrinho.")
            }
          },
          error: (xhr, status, error) => {
            console.error("Erro na requisição AJAX:", error)
            alert("Erro ao limpar carrinho. Por favor, tente novamente.")
          },
        })
      }
    })
  
    // Inicializa o contador do carrinho
    try {
      if ($(".carrinho-contador").length > 0) {
        atualizarContadorCarrinho()
      }
    } catch (e) {
      console.error("Erro ao inicializar contador do carrinho:", e)
    }
  
    console.log("Script inicializado com sucesso!")
  })
  
  