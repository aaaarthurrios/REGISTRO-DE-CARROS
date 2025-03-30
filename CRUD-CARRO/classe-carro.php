<?php

class Carro
{

    private $pdo;
    //Conexão com o banco de dados	

    public $modelo;
    public $motor;
    public $ano;
    public $marca;

    





    public function __construct($dbname, $host, $user, $senha)



    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $senha);
        } catch (PDOException $e) {
            echo "Erro com banco de dados: " . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo "Erro generico: " . $e->getMessage();
            exit();
        }
    }

    //Função para buscar dados e colocar no C.R.U.D Direito
    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM carros ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    public function cadastrarCarro($nome, $ano, $modelo, $marca)
    {


        //Verificar se o carro já está cadastrado

        $cmd = $this->pdo->prepare("SELECT id from carros WHERE modelo = :m");
        $cmd->bindValue(":m", $modelo);
        $cmd->execute();
        if ($cmd->rowCount() > 0) //Carro já está cadastrado
        {
            return false;
        } else {
            $cmd = $this->pdo->prepare("INSERT INTO carros (nome, ano, modelo,marca) VALUES (:n, :a, :m,:l)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":a", $ano);
            $cmd->bindValue(":l", $marca);
            $cmd->bindValue(":m", $modelo);
            $cmd->execute();
            return true;
        }
    }

    public function excluirCarro($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM carros WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    //Buscar dados de um carro
    public function buscarDadosCarro($id)
    {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM carros WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    //Atualizar dados de um carro


    public function atualizarDados($id, $nome, $ano, $modelo, $marca)
    {



        $cmd = $this->pdo->prepare("UPDATE carros SET nome = :n, 
        ano = :a, modelo = :m, marca = :l WHERE id = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":a", $ano);
        $cmd->bindValue(":m", $modelo);
        $cmd->bindValue(":l", $marca);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        return true;
    }
}
