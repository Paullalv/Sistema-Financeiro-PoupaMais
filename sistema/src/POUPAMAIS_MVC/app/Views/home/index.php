<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoupaMais - Seu Aliado Financeiro</title> 
    <link rel="stylesheet" href="/assets/css/inicial.css">
    <link href="https://fonts.googleapis.com/css2?family=NomeDaSuaFonte:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

<?php

$alerta = null;
$titulo = null;
$mensagem = null;
$css_class = null; 

if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'cadastro') {
    $alerta = 'cadastro';
    $css_class = 'sucesso'; 
    $titulo = 'Cadastro Concluído!';
    $mensagem = 'Usuário cadastrado com sucesso. Faça login para começar.';
} 
if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'logout') { 
    $alerta = 'logout';
    $css_class = 'sucesso'; 
    $titulo = 'Sessão Encerrada';
    $mensagem = 'Você foi desconectado com sucesso. Faça login novamente para acessar sua conta.';
}
    
    
if (isset($_GET['alerta']) && $_GET['alerta'] == 'acesso_restrito') {
    $alerta = 'acesso_restrito';
    $css_class = 'erro'; 
    $titulo = 'Acesso Negado';
    $mensagem = 'Esta é uma área restrita. Você precisa fazer login para continuar.';
} 
if (isset($_GET['alerta']) && $_GET['alerta'] == 'login_falhou') {
    $alerta = 'login_falhou';
    $css_class = 'erro'; 
    $titulo = 'Erro no Login';
    $mensagem = 'E-mail ou senha incorretos. Por favor, tente novamente.';
}
    

if (isset($_GET['erro']) && $_GET['erro'] == 'senhas_nao_conferem') {
    $alerta = 'senhas_nao_conferem';
    $css_class = 'erro';
    $titulo = 'Erro no Cadastro';
    $mensagem = 'As senhas digitadas não conferem.';
}
if (isset($_GET['erro']) && $_GET['erro'] == 'cadastro_falhou') {
    $alerta = 'cadastro_falhou';
    $css_class = 'erro';
    $titulo = 'Falha no Cadastro';
    $mensagem = 'Falha ao realizar o cadastro. O e-mail pode já estar em uso.';
}
if (isset($_GET['erro']) && $_GET['erro'] == 'acesso_negado') {
    $alerta = 'acesso_negado';
    $css_class = 'erro';
    $titulo = 'Acesso Negado';
    $mensagem = 'Sessão inválida. Por favor, faça login para acessar a área restrita.';
}

if ($alerta && $mensagem && $css_class) {
    echo '
    <div id="alerta-sistema" class="alerta-container">
        <div class="alerta-box ' . $css_class . '">
            <button class="alerta-fechar" onclick="this.closest(\'.alerta-container\').style.display = \'none\';">&times;</button>
            <h4>' . htmlspecialchars($titulo) . '</h4>
            <p>' . htmlspecialchars($mensagem) . '</p>
        </div>
    </div>';
}
?>
 


<header>
    <div class="container">
        <nav>
            <h1 class="logo"><i class="fa-solid fa-piggy-bank"></i>PoupaMais</h1>
            <ul>
                <li><a href="#recursos"><i class="fa-solid fa-list-check"></i>Recursos</a></li>
                <li><a href="#sobre"><i class="fa-solid fa-circle-info"></i>Sobre</a></li>
                
            </ul>
        </nav>
    </div>
</header>

    <main>
        
        <section class="sec">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>PoupaMais</h1>
                    <h2>Seu aliado para organizar, economizar e alcançar seus objetivos financeiros.</h2>
                    <h3>Aqui, cada centavo importa, e cada decisão conta.</h3>
                    <div class="botoes-hero">
                        <a href="#" id="btn-entrar" class="btn">Entrar</a>
                        <a href="#" id="btn-cadastro" class="btn">Criar conta</a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="/assets/imag/imageminicial.png" alt="Imagem Ilustrativa PoupaMais">
                </div>
            </div>
        </section>

        <br>

        <section id="recursos" class="recursos">
            <h1>Recursos Oferecidos</h1>
            <ul>
                <li>
                    <h2>Registros de Receitas e Despesas</h2>
                    <p>Inserção manual ou automática de entradas e saídas.<br>
                        Possibilidade de classificar cada item em categorias</p>
                </li>
                <li>
                    <h2>Orçamento Pessoal/Mensal </h2>
                    <p>Definição de limites de gastos por categoria.<br>
                        Acompanhamento do quanto já foi usado em cada área.<br>
                        Alertas quando o usuário ultrapassa o limite planejado.</p>
                </li>
                <li>
                    <h2>Metas Financeiras</h2>
                    <p>Definição de objetivos.<br>
                        Exibição do progresso </p>
                </li>
                <li>
                    <h2>Controle de Dívidas</h2>
                    <p>Cadastro de dívidas existentes<br>
                        Informações sobre parcelas, juros e datas de vencimento.</p>
                </li>
                <li>
                    <h2>Alertas e Lembretes</h2>
                    <p>Notificações sobre contas a pagar e contas a receber.<br>
                        Avisos de metas próximas do prazo.<br>
                        Sugestões automáticas de economia.</p>
                </li>
                <li>
                    <h2>Projeção e Planejamento Futuro</h2>
                    <p>Simulações: “Se eu gastar X a menos, quanto economizo até o fim do ano?”.<br>
                        Previsão de saldo futuro com base em padrões de gastos.</p>
                </li>
            </ul>

        </section>

        <section id="sobre" class="sobre">
            <h2>Sobre o PoupaMais</h2>
            <p>O Poupamais é uma plataforma de controle financeiro pessoal projetada para ajudá-lo a organizar suas
                finanças de forma prática e
                inteligente. Com ele, você consegue acompanhar seus gastos, visualizar suas economias e planejar seus
                objetivos com facilidade.
                <br>Nosso objetivo é transformar a maneira como você lida com seu dinheiro, oferecendo ferramentas
                simples e eficientes que tornam o
                planejamento financeiro mais claro e acessível. Com o Poupamais, você poupa mais, toma decisões
                conscientes e conquista a
                liberdade financeira que sempre desejou.
            </p>
        </section>

    </main>

<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>

        <form style="width: 100%;" method="POST" action="/login_submit">
 
            <h1>Login</h1>

            <div class="input-box">
                <input placeholder="Usuário ou e-mail" type="email" name="email" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" placeholder="Senha" class="password-input" name="senha" required>
                <i class="fa-regular fa-eye-slash password-icon"></i>
            </div>

            <div class="remember-forgot">
                <label>
                    <input type="checkbox">
                    Lembrar minha senha
                </label>
                <a href="#">Esqueceu senha?</a>
            </div>

            <button type="submit" class="login">Entrar</button>

        </form>
    </div>
</div>

<div id="cadastroModal" class="modal">
    <div class="modal-content">
        <span class="close-cadastro">&times;</span>

        <div id="form_header">
            <h1 id="form_title">Cadastre-se já!</h1>
        </div>

        <form method="POST" action="/cadastro_submit" id="form">
       
            <div id="input_container">
                <div class="input-box">
                    <label for="name" class="form-label">Primeiro nome</label>
                    <div class="input-field">
                        <input type="text" name="primeiro_nome" id="name" class="form-control" placeholder="Digite seu nome" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>
                <div class="input-box">
                    <label for="last_name" class="form-label">Último nome</label>
                    <div class="input-field">
                        <input type="text" name="ultimo_nome" id="last_name" class="form-control"
                            placeholder="Digite seu sobrenome">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>
                <div class="input-box">
                    <label for="birthdate" class="form-label">Nascimento</label>
                    <div class="input-field">
                        <input type="date" name="nascimento" id="birthdate" class="form-control">
                    </div>
                </div>
                <div class="input-box">
                    <label for="email" class="form-label">E-mail</label>
                    <div class="input-field">
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="exemplo@gmail.com" required>
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                </div>
                <div class="input-box">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-field">
                        <input type="password" name="senha" id="password" class="form-control"
                            placeholder="*******" required>
                        <i class="fa-regular fa-eye-slash password-icon"></i>
                    </div>
                </div>
                <div class="input-box">
                    <label for="confirm_password" class="form-label">Confirmar senha</label>
                    <div class="input-field">
                        <input type="password" name="confirmar_senha" id="confirm_password" class="form-control"
                            placeholder="*******" required>
                        <i class="fa-regular fa-eye-slash password-icon"></i>
                    </div>
                </div>
                <div class=" radio-container">
                    <label id="genero">Gênero:</label>

                    <div class="genero-opcoes">
                        <input type="radio" id="masculino" name="genero" value="M">
                        <label for="masculino">Masculino</label>

                        <input type="radio" id="feminino" name="genero" value="F">
                        <label for="feminino">Feminino</label>

                        <input type="radio" id="outro" name="genero" value="O">
                        <label for="outro">Outro</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="login">
                <i class="fa-solid fa-check"></i>
                Criar conta
            </button>    
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const passwordIcons = document.querySelectorAll('.password-icon');

    passwordIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const passwordInput = icon.closest('.input-box, .input-field').querySelector('input[type="password"], input[type="text"]');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
});
</script>

<script>
    
    function fecharAlerta(id) {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.style.display = 'none';
        }
    }
</script>


<footer class="footer">
    <div class="copyright">© 2025 PoupaMais. Todos os direitos reservados.</div>
</footer>


    <script src="/assets/javas/inicial.js"></script>
    
</body>
</html>