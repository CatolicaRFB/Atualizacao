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
        $caminhoArquivo = '\' . $nomeArquivo;

        // Ler o conteúdo do arquivo
        $conteudoArquivo = file_get_contents($arquivo['tmp_name']);

        // Autenticação e configuração da requisição
        $token = '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'; // Substitua pelo seu token de acesso pessoal do GitHub
        $owner = 'CatólicaRFB'; // Substitua pelo nome do proprietário do repositório
        $repo = 'Arquivos'; // Substitua pelo nome do repositório
        $path = $caminhoArquivo; // Substitua pelo caminho e nome do arquivo no repositório

        // Dados para a requisição
        $data = array(
            'message' => 'Adicionando arquivo via API do GitHub',
            'content' => base64_encode($conteudoArquivo)
        );

        // Realizar a requisição para criar o arquivo
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/{$owner}/{$repo}/contents/{$path}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: token ' . $token,
            'Content-Type: application/json',
            'User-Agent: Your-App'
        ));
        $response = curl_exec($ch);
        curl_close($ch);

        // Verificar a resposta da API do GitHub
        $responseData = json_decode($response, true);
        if (isset($responseData['content']['sha'])) {
            // Arquivo criado com sucesso, você pode realizar outras operações aqui

            // Exemplo: exibir uma mensagem de sucesso e exibir os dados recebidos
            echo "Formulário enviado com sucesso!<br><br>";
            echo "Nome: " . $nome . "<br>";
            echo "E-mail: " . $email . "<br>";
            echo "Telefone: " . $telefone . "<br>";
            echo "Arquivo anexado: " . $nomeArquivo . "<br>";
        } else {
            echo "Erro ao criar o arquivo no GitHub.";
        }
    } else {
        echo "Erro ao enviar o arquivo.";
    }
} else {
    echo "O formulário não foi enviado corretamente.";
}
?>
