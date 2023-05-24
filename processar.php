<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados pessoais
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Arquivo anexado
    $arquivo = $_FILES['documento'];

    // Verificar se um arquivo foi enviado
    if ($arquivo['error'] === UPLOAD_ERR_OK) {
        $nomeArquivo = $arquivo['name'];
        $caminhoArquivo = 'CatolicaRFB/Arquivos' . $nomeArquivo;

        // Mover o arquivo para o local desejado
        if (move_uploaded_file($arquivo['tmp_name'], $caminhoArquivo)) {
            // Arquivo movido com sucesso, você pode realizar outras operações aqui

            // Exemplo: exibir uma mensagem de sucesso e exibir os dados recebidos
            echo "Formulário enviado com sucesso!<br><br>";
            echo "Nome: " . $nome . "<br>";
            echo "E-mail: " . $email . "<br>";
            echo "Telefone: " . $telefone . "<br>";
            echo "Arquivo anexado: " . $nomeArquivo . "<br>";
        } else {
            echo "Erro ao mover o arquivo para o destino desejado.";
        }
    } else {
        echo "Erro ao enviar o arquivo.";
    }
} else {
    echo "O formulário não foi enviado corretamente.";
}
?>
