<?php

/*********************************************************************************************************************
 Curso: Engenharia de Software
 Disciplina: Linguagem e Técnicas de Programacão
 Professor: Flores
 Turma: ESOFT-2A
 Componentes: 
            25169060-2 - Alex Rafael Ferreira
            25001459-2 - Eduardo Gritten dos Santos Spohr
            25177941-2 - Juan Pyerre de Sousa Carvalho 
            25044068-2 - Legiane Cristina de Souza Oliveira Chagas
            25164713-2 - Luan Enrico Santana Peça
            25182011-2 - Miguel Felipe Gazola
            25181985-2 - Nathaly Yukie Otofuji Honda
            25181898-2 - Pedro Paulo Rodrigues Mardegam
 Data: 11 de Novembro de 2025
 Descritivo: Desenvolvimento de um Sistema CRUD em PHP com MySQL
 **********************************************************************************************************************/

include_once __DIR__ . '/../../controllers/ProdutoController.php';

$controller = new ProdutoController();
$categorias_stmt = $controller->getCategorias();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    $importante = $_POST['importante'];
    $genero = $_POST['genero'];
    $notas = $_POST['notas'];

    if ($controller->create($nome, $descricao, $preco, $categoria_id, $importante, $genero, $notas)) {
        header('Location: /crud_php/public/index.php?page=produtos');
        exit();
    } else {
        echo "<p class='error'>Não foi possível criar o produto.</p>";
    }
}

include __DIR__ . '/../../views/includes/header.php';
?>

<h2>Criar Produto</h2>

<form id="form" action="/crud_php/public/index.php?page=produtos&action=create" method="POST">
    <label for="nome">Nome do Produto:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao"></textarea>

    <label for="preco">Preço:</label>
    <input type="number" id="preco" name="preco" step="0.01" required>

    <label for="categoria_id">Categoria:</label>
    <select id="categoria_id" name="categoria_id" required>
        <?php
        while ($categoria = $categorias_stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value=\"" . $categoria['id'] . "\">" . $categoria['nome'] . "</option>";
        }
        ?>
    </select>

    <label for="genero">Gênero:</label>
    <input type="text" id="genero" name="genero">

    <label for="notas">Notas:</label>
    <input type="text" id="notas" name="notas">
    
    <label for="importante">Produto Importante?</label>
    <select id="importante" name="importante" required>
        <option value="nao">Não</option>    
        <option value="sim">Sim</option>
    </select>

    <button type="submit" class="button">Salvar</button>
    <a href="/crud_php/public/index.php?page=produtos" class="button">Cancelar</a>
</form>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
