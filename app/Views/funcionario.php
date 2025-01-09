<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
    <link rel="stylesheet" href="/css/cadastro-funcionario.css">
</head>
<body>
    <a href="/home" class="back-btn">Voltar para a Tela Inicial</a>
    <h1>Cadastrar Funcionário</h1>
    <form action="/adicionar-funcionario" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>
        <label for="rg">RG:</label>
        <input type="text" id="rg" name="rg">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="id_empresa">Empresa:</label>
        <select id="id_empresa" name="id_empresa" required>
            <option value="">Selecione uma empresa</option>
            <?php foreach ($empresas as $empresa): ?>
                <option value="<?php echo $empresa['id_empresa']; ?>">
                    <?php echo $empresa['nome']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="salario">Salário:</label>
        <input type="number" id="salario" name="salario" step="0.01">
        <label for="data_cadastro">Data de Cadastro:</label>
        <input type="date" id="data_cadastro" name="data_cadastro" value="<?php echo date('Y-m-d'); ?>">
        <small>Se deixar vazio, será utilizada a data atual.</small>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
