<?php
include_once __DIR__ . 
'/../../controllers/ProdutoController.php';

$controller = new ProdutoController();

$id = isset($_GET['id']) ? $_GET['id'] : die('ID do produto não fornecido.');

$produto = $controller->readOne($id);
$categorias_stmt = $controller->getCategorias();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    $importante = $_POST['importante'];
    $genero = $_POST['genero'];
    $notas = $_POST['notas'];

    if ($controller->update($id, $nome, $descricao, $preco, $categoria_id, $importante, $genero, $notas)) {
        header('Location: /crud_php/public/index.php?page=produtos');
        exit();
    } else {
        echo "<p class='error'>Não foi possível atualizar o produto.</p>";
    }
}

include __DIR__ . 
'/../../views/includes/header.php';
?>

<h2>Editar Produto</h2>

<form action="/crud_php/public/index.php?page=produtos&action=edit&id=<?php echo $id; ?>" method="POST">
    <label for="nome">Nome do Produto:</label>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto->nome, ENT_QUOTES); ?>" required>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao"><?php echo htmlspecialchars($produto->descricao, ENT_QUOTES); ?></textarea>

    <label for="preco">Preço:</label>
    <input type="number" id="preco" name="preco" step="0.01" value="<?php echo htmlspecialchars($produto->preco, ENT_QUOTES); ?>" required>

    <label for="categoria_id">Categoria:</label>
    <select id="categoria_id" name="categoria_id" required>
        <?php
        while ($categoria = $categorias_stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = ($categoria['id'] == $produto->categoria_id) ? 'selected' : '';
            echo "<option value=\"" . $categoria['id'] . "\" {$selected}>" . $categoria['nome'] . "</option>";
        }
        ?>
    </select>

    <label for="genero">Gênero:</label>
    <input type="text" id="genero" name="genero" value="<?php echo htmlspecialchars($produto->genero, ENT_QUOTES); ?>">

    <label for="notas">Notas:</label>
    <input type="text" id="notas" name="notas" value="<?php echo htmlspecialchars($produto->notas, ENT_QUOTES); ?>">

    <label for="importante">Produto Importante?</label>
    <select id="importante" name="importante" required>
        <?php 
        if(htmlspecialchars($produto->importante, ENT_QUOTES) == 'sim'){
            echo "<option value='sim'>Sim</option>";
            echo "<option value='nao'>Não</option>";
        }else{
            echo "<option value='nao'>Não</option>";
            echo "<option value='sim'>Sim</option>";
        }
        ?>
    </select>

    <button type="submit" class="button">Salvar</button>
    <a href="/crud_php/public/index.php?page=produtos" class="button">Cancelar</a>
</form>

<?php include __DIR__ . 
'/../../views/includes/footer.php'; ?>
