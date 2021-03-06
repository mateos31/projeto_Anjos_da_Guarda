<?php
session_start();
ob_start();
$btnCadastro = filter_input(INPUT_POST, 'btnCadastro', FILTER_SANITIZE_STRING);
if ($btnCadastro) {
    include_once 'conexao.php';
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados); //mostra o array criado
    $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
    $result_usuario =
        "INSERT INTO  usuarios(
        nome,
        sobrenome, 
        cpf, 
        rg, 
        email, 
        senha, 
        telefone, 
        cep, 
        endereco, 
        bairro, 
        cidade, 
        estado, 
        numero, 
        complemento, 
        created) VALUES(
        '" . $dados['nome'] . "',
        '" . $dados['sobrenome'] . "', 
        '" . $dados['cpf'] . "',
        '" . $dados['rg'] . "',
        '" . $dados['email'] . "',
        '" . $dados['senha'] . "',
        '" . $dados['telefone'] . "',
        '" . $dados['cep'] . "',
        '" . $dados['rua'] . "',
        '" . $dados['bairro'] . "',
        '" . $dados['cidade'] . "',
        '" . $dados['uf'] . "',
        '" . $dados['numero'] . "',
        '" . $dados['complemento'] . "',
        now())";

    $resultado = mysqli_query($conn, $result_usuario);
    if (mysqli_insert_id($conn)) {
        $_SESSION['msgCad'] =  "<script>window.alert('usuário cadastrado com sucesso')</script><p style='var(--title-color)> Usuário Cadastrado </p>";
        header("Location: index.html");
    } else {
        $_SESSION['msg'] =  " <p style='color: red; margin-top:20px; margin-bottom: -30px'>Erro ao cadastrar o usuário</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/anjos_da_guarda_logo_favicon.png" />

    <script type="text/javascript" src="js/end_viacep.js"></script>
    <link rel="stylesheet" href="css/styles.css">

    <title>Cadastro de Cuidador</title>
</head>


<body>
    <div id="cad-pro">
        <header>

            <a href="index.html">
                <img src="img/anjos_da_guarda_logo_sf" width="225px">
            </a>

            <a href="index.html">
                <img src="img/arrow.svg" alt="" height="12px" collor="#2274a5">
                Voltar para home
            </a>
        </header>

        <form method="POST" action="">

            <h1>Cadastre-se como cuidador!</h1>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

            if (isset($_SESSION['msgCad'])) {
                echo $_SESSION['msgCad'];
                unset($_SESSION['msgCad']);
            }
            ?>

            <fieldset>

                <legend>
                    <h2>Dados Básicos</h2>
                    <h6>Preenchimento Obrigatório (*)</h6>
                </legend>

                <!--FORMULÁRIO DE CADASTRO - DADOS BÁSICOS-->

                <div class="field-group">
                    <div class="field">
                        <label for="name">Nome *</label>
                        <input type="text" name="nome" maxlength="40" placeholder="Insira seu nome">
                    </div>

                    <div class="field">
                        <label for="name">Sobrenome *</label>
                        <input type="text" name="sobrenome" maxlength="40" placeholder="Insira seu sobrenome">
                    </div>
                </div>

                <div class="field">
                    <label for="email">E-mail *</label>
                    <input type="text" name="email" maxlength="50" placeholder="Insira seu melhor e-mail">
                </div>

                <div class="field">
                    <label for="sexo">Sexo *</label>
                    <div class="cntr">

                        <label for="opt1" class="radio">
                            <input type="radio" name="sexo" id="opt1" class="hidden" value="M" />
                            <span class="label"></span>Masculino
                        </label>

                        <label for="opt2" class="radio">
                            <input type="radio" name="sexo" id="opt2" class="hidden" value="F" />
                            <span class="label"></span>Feminino
                        </label>

                        <label for="opt3" class="radio">
                            <input type="radio" name="sexo" id="opt3" class="hidden" value="O" />
                            <span class="label"></span>Outro
                        </label>

                        <label for="opt4" class="radio">
                            <input type="radio" name="sexo" id="opt4" class="hidden" value="U" />
                            <span class="label"></span>Prefiro não declarar
                        </label>
                    </div>
                </div>
                <div class="field">
                    <label for="whatsapp">Tel. Whatsapp (DDD)+(Tel.) *</label>
                    <input type="text" name="telefone" maxlength="50" placeholder="Insira o seu número de WhatsApp">
                </div>

                <div class="field-group">
                    <div class="field">
                        <label for="CPF">CPF (somente números) *</label>
                        <input type="text" name="cpf" placeholder="Insira seu CPF">
                    </div>

                    <div class="field">
                        <label for="RG">RG (somente números) *</label>
                        <input type="text" name="rg" placeholder="Insira seu número de documento">
                    </div>
                </div>

                <div class="field-group">
                    <div class="field">
                        <label for="senha">Digite sua senha *</label>
                        <input type="password" name="senha" placeholder="Insira uma senha">
                    </div>

                    <div class="field">
                        <label for="senha_confirma">Digite sua senha novamente *</label>
                        <input type="password" name="senha_confirma" placeholder="Insira sua senha novamente">
                    </div>
                </div>
            </fieldset>

            <!--FORMULÁRIO DE CADASTRO - DADOS DO PROFISSIONAL-->
            <fieldset>
                <legend>
                    <h2>Dados Profissionais</h2>
                    <h6>Aviso: Esses dados estarão dispostos a revisão.</h6>
                </legend>

                <label for="sexo">Possui experiência profissional na área de cuidados ou saúde? *</label>
                <div class="field">
                    
                        <label for="exp1" class="radio">
                            <input type="radio" name="exp" id="exp1" class="hidden" value="S" />
                            <span class="label"></span>Sim, possuo experiência na área.
                        </label>

                        <label for="exp2" class="radio">
                            <input type="radio" name="exp" id="exp2" class="hidden" value="N" />
                            <span class="label"></span>Não possuo experiência.
                        </label>
                    
                </div>
 <!--
                <div class="field">
                    <label for="formacao">Se sim, conte-nos!</label>
                    <textarea placeholder="Conte-nos sua experiência"></textarea>
                </div> -->

                <label for="sexo">Possui formação profissional na área de cuidados ou saúde? *</label>
                <div class="field">
                    
                        <label for="form1" class="radio">
                            <input type="radio" name="formacao" id="form1" class="hidden" value="S" />
                            <span class="label"></span>Sim, possuo formação profissional na área.
                        </label>

                        <label for="form2" class="radio">
                            <input type="radio" name="formacao" id="form2" class="hidden" value="N" />
                            <span class="label"></span>Não possuo formação profissional.
                        </label>
                    
                </div>

                <div class="field">
                    <label for="formacao">Escolha suas especialidades *</label>
                    <div class="field-check">
                        <div class="check">
                            <input type="checkbox" name="especs" valor="I" id="check1">
                            <label for="check1">Cuidador de idosos</label>
                        </div>

                        <div class="check">
                            <input type="checkbox" name="especs" valor="C" id="check2">
                            <label for="check2">Cuidador de crianças</label>
                        </div>

                        <div class="check">
                            <input type="checkbox" name="especs" valor="F" id="check3">
                            <label for="check3">Tratamento de feridos</label>
                        </div>

                        <div class="check">
                            <input type="checkbox" name="especs" valor="e" id="check4">
                            <label for="check4">Cuidador de PNE's (Pessoas com Necessidades Especiais)</label>
                        </div>

                        <div class="check">
                            <input type="checkbox" name="especs" valor="e" id="check5">
                            <label for="check5">Cuidador de PcD's (Pessoas com Deficiências)</label>
                        </div>
                    </div>


                </div>

            </fieldset>

            <fieldset>
                <legend>
                    <h2>Endereço</h2>
                    <h6>Aviso: Este formulário se auto-completa</h6>
                </legend>


                <div class="field">
                    <label for="cep">CEP *</label>
                    <input name="cep" type="text" id="cep" placeholder="Insira o seu número de CEP" maxlength="9" onblur="pesquisacep(this.value);" /></label>
                </div>

                <div class="field">
                    <label>Rua *</label>
                    <input name="rua" type="text" id="rua" placeholder="Insira o nome da sua rua" />
                </div>

                <div class="field-group">
                    <div class="field">
                        <label>Bairro *</label>
                        <input name="bairro" type="text" id="bairro" placeholder="Insira o nome do seu bairro" />
                    </div>

                    <div class="field">
                        <label>Cidade *</label>
                        <input name="cidade" type="text" id="cidade" placeholder="Insira o nome da sua cidade" />
                    </div>
                </div>

                <div class="field-group">
                    <div class="field">
                        <label>Estado *</label>
                        <input name="uf" type="text" id="uf" placeholder="Insira sua UF" maxlength="2" />
                    </div>

                    <div class="field">
                        <label>Número </label>
                        <input name="numero" type="text" id="numero" placeholder="Insira o número do imóvel">
                    </div>

                </div>

                <div class="field">
                    <label>Complemento</label>
                    <input name="complemento" type="text" id="complemento" placeholder="Ex.: Apto. Nº5, Bloco 2">
                </div>

                <p class="sublink">Já é cadastrado? <a href="loginPro.php">Clique aqui</a>.</p>
                <!--   <button type="submit">Cadastrar-se</button><br><br>-->
                <input class="button" name="btnCadastro" type="submit" value="Cadastrar"></input><br><br>

                <h6>
                    Ao clicar em “Cadastrar-se”, você aceita os Termos de Uso da Anjos da Guarda e confirma que leu a Política de Privacidade. Você também concorda em receber mensagens em seu e-mail, inclusive automáticas, provenientes da companhia e de suas afiliadas para fins informativos e/ou de marketing, no número que informou. A aceitação do recebimento de mensagens de marketing não é condição para usar os serviços da Anjos da Guarda. Você compreende que, para cancelar o recebimento, pode cancelá-los via e-mail.
                </h6>

    </div>
    </fieldset>


    </form>
</body>
</div>

</html>