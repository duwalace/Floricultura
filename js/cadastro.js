document.addEventListener("DOMContentLoaded", function () {
    const cadastroForm = document.getElementById("cadastroForm");
    const cadastroMessage = document.getElementById("cadastroMessage");

    if (cadastroForm && cadastroMessage) {
        cadastroForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(cadastroForm);

            fetch("../php/cadastro_php.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("Resposta do cadastro:", data); // Verifique a resposta no console
                if (data.sucesso) {
                    cadastroMessage.style.color = "green";
                    cadastroMessage.textContent = "Cadastro bem-sucedido!";
                    setTimeout(() => {
                        window.location.href = "../html/principal.php";
                    }, 1500);
                } else {
                    cadastroMessage.style.color = "red";
                    cadastroMessage.textContent = data.erro || "Erro ao cadastrar.";
                }
            })
            .catch(error => {
                console.error("Erro no cadastro:", error);
                cadastroMessage.style.color = "red";
                cadastroMessage.textContent = "Erro ao tentar cadastrar.";
            });
        });
    } else {
        console.error("Elemento cadastroForm ou cadastroMessage não encontrado.");
    }
});