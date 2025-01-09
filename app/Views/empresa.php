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
    <form action="/adicionar-empresa" method="POST">
        <label for="nome">Nome da Empresa:</label>
        <input type="text" id="nome" name="nome" required>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
