document.getElementById("addEmpresaForm").addEventListener("submit", async function (e) {
    e.preventDefault();
    const formData = new FormData(e.target);

    try {
        const response = await fetch("/adicionar-empresa", {
            method: "POST",
            body: formData,
        });
        const result = await response.json();

        if (result.success) {
            document.getElementById("successMessage").textContent = result.message;
            document.getElementById("successModal").style.display = "flex";
        } else {
            document.getElementById("errorMessage").textContent = result.message;
            document.getElementById("errorModal").style.display = "flex";
        }
    } catch (error) {
        console.error("Erro ao cadastrar empresa:", error);
        document.getElementById("errorMessage").textContent = "Erro ao cadastrar empresa.";
        document.getElementById("errorModal").style.display = "flex";
    }
});
