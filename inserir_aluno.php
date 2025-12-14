<?php
// 1. Dados de conexão (WAMP)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grau";

// 2. Conectar ao banco
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// 3. Receber dados do formulário
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$data_nascimento = $_POST['data_nascimento'];

// 4. Processar upload da imagem
$target_dir = "uploads/";  // pasta onde a imagem ficará

// cria pasta se não existir
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$nome_arquivo = basename($_FILES["foto"]["name"]);
$caminho_final = $target_dir . time() . "_" . $nome_arquivo;  // evita nomes duplicados

// mover arquivo para pasta uploads
if (move_uploaded_file($_FILES["foto"]["tmp_name"], $caminho_final)) {
    // deu certo
} else {
    die("Erro ao fazer upload da imagem.");
}

// 5. Inserir no banco de dados
$sql = "INSERT INTO aluno (nome, idade, data_nascimento, foto_url)
        VALUES ('$nome', '$idade', '$data_nascimento', '$caminho_final')";

// 6. Executar
if ($conn->query($sql) === TRUE) {
    echo "Aluno inserido com sucesso!";
    echo "<br><a href='index.html'>Voltar</a>";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>
