<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?> - PoupaMais</title>
    <link rel="stylesheet" href="/assets/css/inicial.css">
    <link rel="stylesheet" href="/assets/css/acoes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .msg-sucesso, .msg-erro { padding: 10px; margin: 15px 0; border-radius: 4px; text-align: center; font-weight: bold; }
        .msg-sucesso { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .msg-erro { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <header class="header">
        <h1>PoupaMais</h1>
    </header>

    <main class="page-container">
        <section class="form-section">
            <div class="header-acao despesa-cor">
                <div>
                <h1><i class="fa-solid fa-minus-circle"></i> Adicionar Nova Despesa</h1>
                </div>
                <a href="<?php echo $caminho_base; ?>painel" class="btn-voltar"><i class="fa-solid fa-arrow-right-to-bracket "></i> Voltar</a>
            </div>

           <?php if (!empty($mensagem)): ?>
                <div class="mensagem-container">
                    <p class="msg-<?= htmlspecialchars($mensagem['tipo']) ?>">
                        <?= htmlspecialchars($mensagem['texto']) ?>
                    </p>
                </div>
            <?php endif; ?>

            <form action="<?php echo $caminho_base; ?>despesas_submit" method="POST" class="form-acao">
                <?php set_csrf();  ?>
                <div class="input-grupo">
                    <label for="categoria-despesa">Categoria</label>
                    <select id="categoria-despesa" name="categoria" required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                        <option value="aluguel">Aluguel</option>
                        <option value="alimentacao">Alimentação</option>
                        <option value="transporte">Transporte</option>
                        <option value="lazer">Lazer</option>
                        <option value="outros">Outros</option>
                    </select>
                </div>
                
                <div class="input-grupo">
                    <label for="descricao-despesa">Descrição</label>
                    <input type="text" id="descricao-despesa" name="descricao" placeholder="Ex: Conta de Luz" >
                </div>
                
                <div class="input-grupo">
                    <label for="valor-despesa">Valor (R$)</label>
                    <input type="number" id="valor-despesa" name="valor" step="0.01" placeholder="Ex: 150.50" required>
                </div>

                <div class="input-grupo">
                    <label for="data-despesa">Data</label>
                    <input type="date" id="data-despesa" name="data_transacao" required value="<?= date('Y-m-d'); ?>">
                </div>                
                <button type="submit" class="btn-submit despesa-bg">Salvar Despesa</button>
            </form>
        </section>
    </main>

    <footer></footer>
</body>
</html>