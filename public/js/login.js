document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm");
    const errorMessage = document.getElementById("errorMessage");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const email = form.email.value.trim();
        const password = form.password.value.trim();

        if (!email || !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            errorMessage.textContent = "Por favor, insira um email válido.";
            return;
        }

        if (!password) {
            errorMessage.textContent = "A senha é obrigatória.";
            return;
        }

        errorMessage.textContent = "";

        try {
            const response = await fetch("/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ email, password }),
            });

            const result = await response.json();

            if (result.success) {
                window.location.href = "/home";
            } else {
                errorMessage.textContent = result.message;
            }
        } catch (error) {
            errorMessage.textContent = "Ocorreu um erro ao processar o login.";
        }
    });
});
