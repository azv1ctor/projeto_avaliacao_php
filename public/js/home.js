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

        const colunas = [
            { header: "Nome", dataKey: "nome" },
            { header: "CPF", dataKey: "cpf" },
            { header: "RG", dataKey: "rg" },
            { header: "Email", dataKey: "email" },
            { header: "Empresa", dataKey: "empresa_nome" },
            { header: "Salário", dataKey: "salario_formatado" },
            { header: "Bonificação", dataKey: "bonificacao_formatada" },
            { header: "Data Cadastro", dataKey: "data_cadastro_formatada" },
        ];

        const data = funcionarios.map((funcionario) => {
            const salarioFormatado = `R$ ${parseFloat(funcionario.salario).toLocaleString("pt-BR", {
                minimumFractionDigits: 2,
            })}`;
            const bonificacao = calcularBonificacao(funcionario.salario, funcionario.data_cadastro);
            const bonificacaoFormatada = `R$ ${bonificacao.toLocaleString("pt-BR", {
                minimumFractionDigits: 2,
            })}`;
            const dataFormatada = formatarData(funcionario.data_cadastro);

            return {
                nome: funcionario.nome,
                cpf: funcionario.cpf,
                rg: funcionario.rg,
                email: funcionario.email,
                empresa_nome: funcionario.empresa_nome,
                salario_formatado: salarioFormatado,
                bonificacao_formatada: bonificacaoFormatada,
                data_cadastro_formatada: dataFormatada,
            };
        });

        pdf.autoTable({
            columns: colunas,
            body: data,
            startY: 20,
            theme: "grid",
            headStyles: {
                fillColor: [1, 81, 140],
                textColor: [255, 255, 255],
                fontSize: 10,
            },
            bodyStyles: {
                fontSize: 9,
            },
        });

        pdf.save("lista_funcionarios.pdf");
    } catch (error) {
        console.error("Erro ao exportar PDF:", error);
        alert("Ocorreu um erro ao tentar exportar o PDF.");
    }
});

function calcularBonificacao(salario, dataCadastro) {
    const dataInicio = new Date(dataCadastro);
    const hoje = new Date();
    const anos = hoje.getFullYear() - dataInicio.getFullYear();

    if (anos > 5) {
        return salario * 0.2;
    } else if (anos > 1) {
        return salario * 0.1;
    }
    return 0;
}

function formatarData(data) {
    const dataObj = new Date(data);
    const dia = String(dataObj.getDate()).padStart(2, "0");
    const mes = String(dataObj.getMonth() + 1).padStart(2, "0");
    const ano = dataObj.getFullYear();
    return `${dia}/${mes}/${ano}`;
}
