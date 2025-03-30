<?php
require_once 'classe-carro.php';

$c = new Carro("carrosmodelos", "localhost", "root", "");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">



    
</head>

<body>




    <?php

    if (isset($_POST['nome'])) //CLICOU NO BOTÃO CADASTRAR OU EDITAR
    {
        //-------------------------Editar-----------------------------
        if (isset($_GET['id_up']) && !empty($_GET['id_up']))
        {
            $id_upd = addslashes($_GET['id_up']);
            $nome = addslashes($_POST['nome']);
            $ano = addslashes($_POST['ano']);
            $modelo = addslashes($_POST['modelo']);
            $marca = addslashes($_POST['marca']);
            if (!empty($nome) && !empty($ano) && !empty($modelo) && !empty($marca))
            //EDITAR
            {
                if (!$c->atualizarDados($id_upd, $nome, $ano, $modelo, $marca));

                header("location: index.php");


            } else {
                ?>
                <div>
               <h4>"Preencha todos os campos"</h4>
               </div>
                <?php
            }
        }
        //-------------------------Cadastrar-----------------------------
        else 
        {
            $nome = addslashes($_POST['nome']);
            $ano = addslashes($_POST['ano']);
            $modelo = addslashes($_POST['modelo']);
            $marca = addslashes($_POST['marca']);
            if (!empty($nome) && !empty($ano) && !empty($modelo) && !empty($marca))
            //Cadastrar
            {
                if (!$c->cadastrarCarro($nome, $ano, $modelo, $marca)) {
                    ?>
                    <div class="aviso">
                    <script>alert('Carro já cadastrado!');</script>

                    
                    </div>
                    
                    <?php
                }
           
            }
        }
    }
    ?>

    <?php
    if (isset($_GET['id_up'])) //SE A PESSOA CLICOU NO EDITAR
    {
        $id_update = addslashes($_GET['id_up']);
        $res = $c->buscarDadosCarro($id_update);
    }
    ?>

    <section id="esquerda">
        <form method="POST">
            <h2> REGISTRO DE CARROS</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome"
                value="<?php if (isset($res)) {
                            echo $res['nome'];
                        } ?>">

            <label for="ano">Ano</label>
            <input type="text" name="ano" id="ano"
                value="<?php if (isset($res)) {
                            echo $res['ano'];
                        } ?>">
            <label for="modelo">Modelo</label>
            <input type="text" name="modelo" id="modelo"
                value="<?php if (isset($res)) {
                            echo $res['modelo'];
                        } ?>">

            <label for="modelo">Marca</label>
            <input type="text" name="marca" id="marca"
                value="<?php if (isset($res)) {
                            echo $res['marca'];
                        } ?>">
            <input type="submit" value="<?php if (isset($res)) {
                                            echo "Atualizar";
                                        } else {
                                            echo "Cadastrar";
                                        } ?>">
        </form>
    </section>

    <section id="direita">
        <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>ANO</td>
                <td colspan="1">MODELO</td>
                <td>MARCA</td>
            </tr>

            <?php
            $dados = $c->buscarDados();
            if (count($dados) > 0) //Tem carros cadastrados no banco de dados
            {
                for ($i = 0; $i < count($dados); $i++) {
                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v) {
                        if ($k != "id") {
                            echo "<td>" . $v . "</td>";
                        }
                    }
            ?>
                    <td><a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
                        <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a>
                    </td>
            <?php
                    echo "</tr>";
                }
            } else 
            {
                 // O banco de dados está vazio
                
            
            
            ?>

        </table>
        
                 <div class="aviso">
                    <br>
                  <h4>Ainda não há carros cadastrados</h4>
                
                  </div>
                <?php
                }
                ?>
            
    </section>
</body>

</html>

<?php
if (isset($_GET['id'])) {
    $id_carro = addslashes($_GET['id']);
    $c->excluirCarro($id_carro);
    header("location: index.php");
}

?>