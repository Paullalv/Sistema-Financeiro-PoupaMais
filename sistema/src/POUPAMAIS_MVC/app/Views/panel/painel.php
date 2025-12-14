<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <link rel="stylesheet" href="/assets/css/principal.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .transaction-item .details .date {
            font-size: 0.85em;
            color: #777;
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo">PoupaMais</div>
        <nav class="navbar">
            <ul>
                <li><a href="<?php echo $caminho_base; ?>painel" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Relatórios</a></li> 
                <li><a href="#"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </nav>
        <div class="profile-dropdown-container">
            <div class="user-profile">
                <span>Olá, <?php echo htmlspecialchars($nome_usuario); ?></span>
                <img src="<?php echo $caminho_base; ?>/assets/imag/imagemusuario.webp" alt="Foto de Perfil">
            </div>

            <div class="dropdown-menu" id="userDropdown">
                <a href="<?php echo $caminho_base; ?>logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </div>
    </header>

    <main class="dashboard-content">
        
        <section class="summary-cards">
            <div class="card total-card">
                <div class="card-header">
                    <h3>Saldo Total</h3>
                    <i class="fas far fa-wallet"></i>
                </div>
                <p class="value" style="color: <?php echo $saldo_total >= 0 ? '#28a745' : '#f33f3f'; ?>;">
                    <?php echo formatar_moeda($saldo_total); ?>
                </p>
                <p class="growth positive">
                    <span>+0.00% neste mês</span>
                </p>
            </div>

            <div class="card revenue-card">
                <div class="card-header">
                    <h3>Receitas</h3>
                    <i class="fas fa-arrow-up icon-bg-green"></i>
                </div>
                <p class="value"><?php echo formatar_moeda($receitas_totais); ?></p>
                <p class="comparison negative">
                    <span>Total acumulado</span>
                </p>
            </div>

            <div class="card expenses-card">
                <div class="card-header">
                    <h3>Despesas</h3>
                    <i class="fas fa-arrow-down icon-bg-red"></i>
                </div>
                <p class="value"><?php echo formatar_moeda($despesas_totais); ?></p>
                <p class="comparison positive">
                    <span>Total acumulado</span>
                </p>
            </div>
        </section>

        <div class="main-grid">
            
            <div class="left-column">
                <section class="financial-summary card">
                    <div class="card-header">
                        <h2>Resumo Financeiro (Mês)</h2>
                        <div class="time-filters">
                            <span class="active">Mês</span>
                            <span>Trimestre</span>
                            <span>Ano</span>
                        </div>
                    </div>
                    <div id="pie-chart-container" class="chart-container">
                        <div class="chart-container" id="pie-chart-container" style="width:100%;max-width:1400px;">
                            <?php if (empty($dados_grafico)): ?>
                                <p style="text-align:center; padding: 50px;">Nenhuma despesa registrada neste mês para o gráfico.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                
                <section class="recent-transactions card">
                    <div class="card-header">
                        <h2>Histórico</h2>
                        <a href="#">Ver todas <i class="fas fa-chevron-right"></i></a> 
                    </div>
                    
                    <div class="transaction-list">
                        <?php if (empty($transacoes_recentes)): ?>
                            <p style="padding: 20px; text-align: center;">Nenhuma transação registrada ainda.</p>
                        <?php else: ?>
                            <?php foreach ($transacoes_recentes as $transacao): 
                                $is_income = $transacao['tipo'] == 'receita';
                                $class_type = $is_income ? 'income' : 'expense';
                                $amount_sign = $is_income ? '+' : '-';
                                $icon = get_category_icon($transacao['categoria'], $transacao['tipo']);
                                $categoria_display = ucfirst($transacao['categoria']);
                                $data_formatada = date('d \d\e F, Y', strtotime($transacao['data_transacao']));
                            ?>
                                <div class="transaction-item">
                                    <div class="icon-container <?php echo $class_type; ?>"><i class="<?php echo $icon; ?>"></i></div>
                                    <div class="details">
                                        <p class="description"><?php echo htmlspecialchars($transacao['descricao']); ?></p>
                                        <p class="category"><?php echo $categoria_display; ?></p>
                                        <p class="date"><?php echo $data_formatada; ?></p>
                                    </div>
                                    <span class="amount <?php echo $class_type; ?>-amount">
                                        <?php echo $amount_sign . formatar_moeda($transacao['valor']); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>
                
            </div>
            
            <div class="right-column">
                <section class="quick-actions card">
                    <h2>Ações Rápidas</h2>
                    <div class="actions-grid">
                        
                        <a href="<?php echo $caminho_base; ?>receitas" class="action-item action-recipe">
                            <i class="fas fa-plus-circle"></i>
                            <p>Receita</p>
                        </a>
                        <a href="<?php echo $caminho_base; ?>despesas" class="action-item action-expense">
                            <i class="fas fa-minus-circle"></i>
                            <p>Despesa</p>
                        </a>
                        <a href="<?php echo $caminho_base; ?>metas.php" class="action-item action-goals"> 
                            <i class="fas fa-bullseye"></i>
                            <p>Metas</p>
                        </a>
                        <a href="<?php echo $caminho_base; ?>orcamento.php" class="action-item action-report">
                            <i class="fas fa-calculator"></i>
                            <p>Orçamento</p>
                        </a>
                    </div>
                </section>
                
                <section class="monthly-budget card">
                    <h2>Orçamento Mensal (Exemplo)</h2>
                    <div class="budget-item">
                        <p class="category">Alimentação</p>
                        <div class="amounts">R$ 850 / R$ 1.000</div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 85%; background-color: #63b3ed;"></div>
                        </div>
                    </div>
                    <div class="budget-item">
                        <p class="category">Transporte</p>
                        <div class="amounts">R$ 420 / R$ 600</div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 70%; background-color: #48bb78;"></div>
                        </div>
                    </div>
                    <div class="budget-item">
                        <p class="category">Lazer</p>
                        <div class="amounts">R$ 280 / R$ 500</div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 56%; background-color: #f6ad55;"></div>
                        </div>
                    </div>
                    <div class="budget-item">
                        <p class="category">Educação</p>
                        <div class="amounts">R$ 150 / R$ 300</div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 50%; background-color: #f56565;"></div>
                        </div>
                    </div>
                </section>
                
                <section class="financial-goals card">
                    <h2>Metas Financeiras (Exemplo)</h2>
                    <div class="goal-item">
                        <p class="goal-name">Viagem para Europa</p>
                        <div class="amounts">R$ 5.500 de R$ 25.000</div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 22%; background-color: #63b3ed;"></div>
                            <span class="progress-percentage">22%</span>
                        </div>
                    </div>
                    <div class="goal-item">
                        <p class="goal-name">Reserva de Emergência</p>
                        <div class="amounts">R$ 7.500 de R$ 10.000</div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 75%; background-color: #48bb78;"></div>
                            <span class="progress-percentage">75%</span>
                        </div>
                    </div>
                </section>

                <section class="accounts card">
                    <h2>Contas (Exemplo)</h2>
                    <div class="account-item">
                        <p class="account-name">Cartão de Crédito</p>
                        <p class="bank-name">Banco XYZ</p>
                        <span class="balance">R$ 2.450,00</span>
                    </div>

                    <div class="account-item">
                        <p class="account-name">Conta Corrente</p>
                        <p class="bank-name">Banco ABC</p>
                        <span class="balance">R$ 8.750,50</span>
                    </div>

                    <div class="account-item">
                        <p class="account-name">Poupança</p>
                        <p class="bank-name">Banco XYZ</p>
                        <span class="balance">R$ 1.250,25</span>
                    </div>
                </section>
            </div>
        </div>
    </main>
    
    <footer class="footer">
        <div class="copyright">© 2024 PoupaMais. Todos os direitos reservados.</div>
    </footer>

    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script>
        const xArray = <?php echo $json_categorias; ?>;
        const yArray = <?php echo $json_valores; ?>;
        
        const colors = ['#f33f3f', '#ffc107', '#48bb78', '#63b3ed', '#f56565', '#9f7aea', '#ecc94b'];

        if (xArray.length > 0) {
            const data = [{ 
                labels: xArray, 
                values: yArray, 
                type: "pie",
                marker: {
                    colors: colors.slice(0, xArray.length) 
                },
                hoverinfo: 'label+percent+value',
                textinfo: 'percent',
                outsidetextfont: {size: 14, color: '#333'},
                automargin: true
            }];
            const layout = {
                title: 'Distribuição de Despesas do Mês',
                height: 400,
                margin: {t: 50, b: 10, l: 10, r: 10}, 
            };

            Plotly.newPlot("pie-chart-container", data, layout, {responsive: true});
        }
    </script>
    <script>
        const profileContainer = document.querySelector('.profile-dropdown-container');
        const dropdown = document.getElementById('userDropdown');

        profileContainer.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        });

        document.addEventListener('click', function(event) {
            if (!profileContainer.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>
</html>

