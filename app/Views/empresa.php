<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Empresa</title>
    <link rel="stylesheet" href="/css/cadastro-empresa.css">
</head>
<body>
    <a href="/home" class="back-btn">Voltar para a Tela Inicial</a>
    <h1>Cadastrar Empresa</h1>
    <form id="addEmpresaForm">
        <label for="nome">Nome da Empresa:</label>
        <input type="text" id="nome" name="nome" required>
        <button type="submit">Salvar</button>
    </form>
    <!-- Modal de Sucesso -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h2>Sucesso!</h2>
            <p id="successMessage">Empresa cadastrada com sucesso!</p>
            <button onclick="document.getElementById('successModal').style.display='none'" class="btn">OK</button>
        </div>
    </div>

    <!-- Modal de Erro -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <h2>Erro</h2>
            <p id="errorMessage">Erro ao cadastrar empresa.</p>
            <button onclick="document.getElementById('errorModal').style.display='none'" class="btn">OK</button>
        </div>
    </div>

    <script src="/js/cadastro-empresa.js" defer></script>
</body>
</html>
