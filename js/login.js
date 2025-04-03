document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
    const loginMessage = document.getElementById("loginMessage");

    if (loginForm && loginMessage) {
        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(loginForm);

            fetch("../php/login_php.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("Resposta do login:", data); // Verifique a resposta no console
                if (data.sucesso) {
                    loginMessage.style.color = "green";
                    loginMessage.textContent = "Login bem-sucedido!";
                    setTimeout(() => {
                        window.location.href = "../html/principal.php";
                    }, 1500);
                } else {
                    loginMessage.style.color = "red";
                    loginMessage.textContent = data.erro || "Erro ao fazer login.";
                }
            })
            .catch(error => {
                console.error("Erro no login:", error);
                loginMessage.style.color = "red";
                loginMessage.textContent = "Erro ao tentar fazer login.";
            });
        });
    } else {
        console.error("Elemento loginForm ou loginMessage não encontrado.");
    }
});