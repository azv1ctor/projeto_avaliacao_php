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
                        <button class="btn edit-btn" data-id="<?php echo $funcionario['id_funcionario']; ?>">Editar</button>
                        <button class="btn delete-btn" data-id="<?php echo $funcionario['id_funcionario']; ?>">Excluir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <div id="deleteConfirmModal" class="modal">
                <div class="modal-content">
                    <h2>Confirmação de Exclusão</h2>
                    <p>Tem certeza de que deseja excluir este funcionário?</p>
                    <div class="modal-buttons">
                        <button id="confirmDeleteBtn" class="btn delete-confirm">Sim, excluir</button>
                        <button id="cancelDeleteBtn" class="btn delete-cancel">Cancelar</button>
                    </div>
                </div>
            </div>
        </tbody>
    </table>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeEditModal">&times;</span>
            <h2>Editar Funcionário</h2>
            <form id="editFuncionarioForm">
                <input type="hidden" id="editId" name="id_funcionario">
                <label for="editNome">Nome:</label>
                <input type="text" id="editNome" name="nome" required>

                <label for="editCpf">CPF:</label>
                <input type="text" id="editCpf" name="cpf" required>

                <label for="editRg">RG:</label>
                <input type="text" id="editRg" name="rg">

                <label for="editEmail">Email:</label>
                <input type="email" id="editEmail" name="email" required>

                <label for="editEmpresa">Empresa:</label>
                <select id="editEmpresa" name="id_empresa" required>
                    <option value="">Selecione uma empresa</option>
                    <?php foreach ($empresas as $empresa): ?>
                        <option value="<?php echo $empresa['id_empresa']; ?>">
                            <?php echo $empresa['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="editSalario">Salário:</label>
                <input type="number" id="editSalario" name="salario" step="0.01">

                <label for="editDataCadastro">Data de Cadastro:</label>
                <input type="date" id="editDataCadastro" name="data_cadastro" required>

                <button type="submit">Salvar</button>
            </form>
        </div>
        <div id="successModal" class="modal">
            <div class="modal-content">
                <h2>Sucesso!</h2>
                <p id="successMessage">Funcionário atualizado com sucesso!</p>
                <button id="closeSuccessModal" class="btn">OK</button>
            </div>
        </div>
    </div>
</body>
</html>
