document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const tableRows = document.querySelectorAll("#funcionariosTable tbody tr");

    searchInput.addEventListener("input", function () {
        const searchValue = searchInput.value.toLowerCase();
        tableRows.forEach((row) => {
            const name = row.children[0].textContent.toLowerCase();
            const cpf = row.children[1].textContent.toLowerCase();
            if (name.includes(searchValue) || cpf.includes(searchValue)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    const deleteButtons = document.querySelectorAll(".delete-btn");
    const deleteModal = document.getElementById("deleteConfirmModal");
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

    let selectedId = null;

    deleteButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            selectedId = button.getAttribute("data-id");
            deleteModal.style.display = "block";
        });
    });

    confirmDeleteBtn.addEventListener("click", function () {
        fetch(`/excluir-funcionario?id=${selectedId}`, { method: "GET" })
            .then(() => {
                deleteModal.style.display = "none";
                window.location.reload();
            })
            .catch((error) => {
                console.error("Erro ao excluir funcionário:", error);
                alert("Erro ao excluir funcionário. Por favor, tente novamente.");
            });
    });

    cancelDeleteBtn.addEventListener("click", function () {
        deleteModal.style.display = "none";
    });

    window.addEventListener("click", function (e) {
        if (e.target === deleteModal) {
            deleteModal.style.display = "none";
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const editModal = document.getElementById("editModal");
    const editButtons = document.querySelectorAll(".edit-btn");
    const closeEditModal = document.getElementById("closeEditModal");

    let selectedId = null;

    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const id = button.getAttribute("data-id");
            selectedId = id;

            fetch(`/buscar-funcionario?id=${id}`)
                .then((response) => response.json())
                .then((data) => {
                    document.getElementById("editId").value = data.id_funcionario;
                    document.getElementById("editNome").value = data.nome;
                    document.getElementById("editCpf").value = data.cpf;
                    document.getElementById("editRg").value = data.rg;
                    document.getElementById("editEmail").value = data.email;
                    document.getElementById("editEmpresa").value = data.id_empresa;
                    document.getElementById("editSalario").value = data.salario;
                    document.getElementById("editDataCadastro").value = data.data_cadastro;
                    editModal.style.display = "block";
                })
                .catch((error) => {
                    console.error("Erro ao buscar funcionário:", error);
                });
        });
    });

    closeEditModal.addEventListener("click", () => {
        editModal.style.display = "none";
    });
});

document.getElementById("editFuncionarioForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(e.target);

    fetch(`/editar-funcionario`, {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                showSuccessModal("Funcionário atualizado com sucesso!");
            } else {
                alert("Erro ao atualizar funcionário: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Erro ao atualizar funcionário:", error);
            alert("Erro ao atualizar funcionário. Por favor, tente novamente.");
        });
});

function showSuccessModal(message) {
    const successModal = document.getElementById("successModal");
    const successMessage = document.getElementById("successMessage");
    const closeSuccessModal = document.getElementById("closeSuccessModal");

    successMessage.textContent = message;
    successModal.style.display = "block";

    closeSuccessModal.addEventListener("click", function () {
        successModal.style.display = "none";
        window.location.reload();
    });

    setTimeout(() => {
        successModal.style.display = "none";
        window.location.reload();
    }, 3000);
}

document.getElementById("exportPDF").addEventListener("click", async function () {
    try {
        const response = await fetch("/api/funcionarios");
        const funcionarios = await response.json();

        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();

        pdf.setFont("Arial", "bold");
        pdf.setFontSize(16);
        pdf.text("Lista de Funcionários", 105, 10, null, null, "center");

        pdf.setFontSize(12);
        pdf.text("Nome", 10, 30);
        pdf.text("CPF", 50, 30);
        pdf.text("RG", 90, 30);
        pdf.text("Email", 130, 30);
        pdf.text("Empresa", 170, 30);

        let y = 40;
        funcionarios.forEach((funcionario) => {
            pdf.text(funcionario.nome, 10, y);
            pdf.text(funcionario.cpf, 50, y);
            pdf.text(funcionario.rg, 90, y);
            pdf.text(funcionario.email, 130, y);
            pdf.text(funcionario.empresa_nome, 170, y);
            y += 10;
        });

        pdf.save("lista_funcionarios.pdf");
    } catch (error) {
        console.error("Erro ao exportar PDF:", error);
        alert("Ocorreu um erro ao tentar exportar o PDF.");
    }
});


