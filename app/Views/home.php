<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários</title>
    <link rel="stylesheet" href="/css/home.css">
    <script src="/js/home.js" defer></script>
</head>
<body>
    <h1>Lista de Funcionários</h1>
    <div class="actions">
        <a href="/cadastro-funcionario" class="btn">Adicionar Funcionário</a>
        <a href="/cadastro-empresa" class="btn">Adicionar Empresa</a>
        <input type="text" id="search" placeholder="Buscar por nome ou CPF" />
        <button id="exportPDF" class="btn">Exportar PDF</button>
    </div>

    <table id="funcionariosTable">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>RG</th>
                <th>Email</th>
                <th>Empresa</th>
                <th>Salário</th>
                <th>Bonificação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios as $funcionario): 
                $dataCadastro = new DateTime($funcionario['data_cadastro']);
                $hoje = new DateTime();
                $intervalo = $dataCadastro->diff($hoje);

                $anos = $intervalo->y;
                $linhaCor = '';
                $bonificacao = 0;

                if ($anos > 5) {
                    $linhaCor = 'background-color: #f8d7da;';
                    $bonificacao = $funcionario['salario'] * 0.2;
                } elseif ($anos > 1) {
                    $linhaCor = 'background-color: #d1ecf1;';
                    $bonificacao = $funcionario['salario'] * 0.1;
                }
            ?>
                <tr style="<?php echo $linhaCor; ?>">
                    <td><?php echo $funcionario['nome']; ?></td>
                    <td><?php echo $funcionario['cpf']; ?></td>
                    <td><?php echo $funcionario['rg']; ?></td>
                    <td><?php echo $funcionario['email']; ?></td>
                    <td><?php echo $funcionario['empresa_nome']; ?></td>
                    <td>R$ <?php echo number_format($funcionario['salario'], 2, ',', '.'); ?></td>
                    <td>R$ <?php echo number_format($bonificacao, 2, ',', '.'); ?></td>
                    <td>
                        <a href="/editar-funcionario?id=<?php echo $funcionario['id_funcionario']; ?>">Editar</a>
                        <a href="#" class="delete-btn" data-id="<?php echo $funcionario['id_funcionario']; ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>