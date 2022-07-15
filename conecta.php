 <?php
    //Adriano Migani
    
    include_once 'config.php';

    class conecta extends config
    {
        var $pdo;



        function __construct()
        {
            $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->usuario, $this->senha);
        }

        function getProduto($idHotmart)
        {
            $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE idHotmart = :idHotmart");
            $stmt->bindValue(":idHotmart", $idHotmart);
            $run = $stmt->execute();
            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rs;
        }

        function getUser($email)
        {
            $stmt = $this->pdo->prepare("SELECT * FROM  usuarios WHERE email = :email");
            $stmt->bindValue(":email", $email);
            $run = $stmt->execute();
            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rs;
        }


        //nem precisou porque se usuario ja existe é porque tem já empresa, verifica com setuser no webhok_hotmart
        function getEmpresa($email_empresa)
        {
            $stmt = $this->pdo->prepare("SELECT * FROM empresa WHERE email_empresa = :email_empresa");
            $stmt->bindValue(":email_empresa", $email_empresa);
            $run = $stmt->execute();
            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rs;
        }

        function setEmpresa($celular, $nome, $email)
        {

            date_default_timezone_set('America/Sao_Paulo');
            $data = date('Y-m-d');
            $hora = date('H:i:s');


            $stmt = $this->pdo->prepare("INSERT INTO empresa (email_empresa, url, celular_empresa, nome, data, hora) VALUES (:email_empresa, :url, :celular_empresa, :nome, :data, :hora)");
            $stmt->bindValue(":email_empresa", $email);
            $stmt->bindValue(":url", $nome);
            $stmt->bindValue(":celular_empresa", $celular);
            $stmt->bindValue(":nome", $nome);
            $stmt->bindValue(":data", $data);
            $stmt->bindValue(":hora", $hora);
            $run = $stmt->execute();
            $rs = $this->pdo->lastInsertId();
            $ultimo_id = $this->pdo->lastInsertId();

            return $ultimo_id;
        }


        function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos)
        {
            $senha = null;
            $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
            $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
            $nu = "0123456789"; // $nu contem os números
            $si = "!@#$%¨&*()_+="; // $si contem os símbolos

            if ($maiusculas) {
                // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
                $senha .= str_shuffle($ma);
            }

            if ($minusculas) {
                // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
                $senha .= str_shuffle($mi);
            }

            if ($numeros) {
                // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
                $senha .= str_shuffle($nu);
            }

            if ($simbolos) {
                // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
                $senha .= str_shuffle($si);
            }

            // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
            return substr(str_shuffle($senha), 0, $tamanho);
        }



        function setUser($celular, $nome, $email, $id_empresa, $gera_senha)
        {


            $pass = $gera_senha; // senha padrao  //padrao md5
            $senha_md5 = MD5(($pass));

            $stmt = $this->pdo->prepare("INSERT INTO usuarios (celular, nome, senha, email, id_empresa) VALUES (:celular, :nome, :senha, :email, :id_empresa)");
            $stmt->bindValue(":celular", $celular);
            $stmt->bindValue(":nome", $nome);
            $stmt->bindValue(":senha", $senha_md5);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":id_empresa", $id_empresa);
            $run = $stmt->execute();
            $rs = $this->pdo->lastInsertId();
            $ultimo_id = $this->pdo->lastInsertId();


            return $ultimo_id;
        }

        function setVenda($user, $prod, $status, $transaction, $plano, $celular, $nome_venda, $cpf_venda, $email_venda)
        {
            $stmt = $this->pdo->prepare("INSERT INTO vendas (user, prod, status, transaction, plano, celular, nome_venda, cpf_venda, email_venda) VALUES (:user, :prod, :status, :transaction, :plano, :celular, :nome_venda, :cpf_venda, :email_venda)");
            $stmt->bindValue(":user", $user);
            $stmt->bindValue(":prod", $prod);
            $stmt->bindValue(":status", $status);
            $stmt->bindValue(":transaction", $transaction);
            $stmt->bindValue(":plano", $plano);
            $stmt->bindValue(":celular", $celular);
            $stmt->bindValue(":nome_venda", $nome_venda);
            $stmt->bindValue(":cpf_venda", $cpf_venda);
            $stmt->bindValue(":email_venda", $email_venda);
            $run = $stmt->execute();
            $rs = $this->pdo->lastInsertId();
            return $rs;
        }
    }
    ?>