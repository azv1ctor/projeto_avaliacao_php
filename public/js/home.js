document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-btn");
    const searchInput = document.getElementById("search");
    const tableRows = document.querySelectorAll("#funcionariosTable tbody tr");
    const exportPDFButton = document.getElementById("exportPDF");

    deleteButtons.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const id = btn.getAttribute("data-id");
            const confirmed = confirm("Você tem certeza que deseja excluir este funcionário?");
            if (confirmed) {
                window.location.href = `/excluir-funcionario?id=${id}`;
            }
        });
    });

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

    exportPDFButton.addEventListener("click", function () {
        window.location.href = "/exportar-funcionarios";
    });
});
