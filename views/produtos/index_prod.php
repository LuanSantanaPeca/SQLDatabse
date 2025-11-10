<?php
include_once __DIR__ . '/../../controllers/ProdutoController.php';

$controller = new ProdutoController();
$data = $controller->index();
$stmt = $data['stmt'];
$num = $data['num'];
$href = '';
$ids = '';

include __DIR__ . '/../../views/includes/header.php';
?>

<h2>Produtos</h2>

<a href="/crud_php/public/index.php?page=produtos&action=create" class="button">Criar Novo Produto</a>

<?php
if($num > 0){
    echo "<table>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nome</th>";
            echo "<th>Descrição</th>"; 
            echo "<th>Preço</th>";
            echo "<th>Categoria</th>";
            echo "<th>Gênero</th>";
            echo "<th>Notas</th>";
            echo "<th>Ações</th>";
        echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        echo "<tr>";
            echo "<td>{$id}</td>";
            if($importante == 'sim'){
                echo "<td>{$nome}*</td>";
            }else{
                echo "<td>{$nome}</td>";
            }
            echo "<td>{$descricao}</td>";
            echo "<td>R$ " . number_format($preco, 2, ',', '.') . "</td>";
            echo "<td>{$categoria_nome}</td>";
            echo "<td>{$genero}</td>";
            echo "<td>{$notas}</td>";
            echo "<td>";
                echo "<a href=\"/crud_php/public/index.php?page=produtos&action=edit&id={$id}\" class=\"button edit\">Editar</a>";
                if($importante == 'nao'){
                    $href = "/crud_php/public/index.php?page=produtos&action=delete&id={$id}";
                }else if($importante == 'sim'){
                    $href = "#popup{$id}";
                    echo "<div class=\"popup\" id=\"popup{$id}\">";
                        echo "<p>Você tem certeza que quer deletar esse produto?</p>";
                        echo "<div class=\"actions\">";
                            echo "<a href=\"/crud_php/public/index.php?page=produtos&action=delete&id={$id}\" class=\"button delete\">Sim</a>";
                            echo "<a href=\"#form\" class=\"button close\">Não</a>";
                        echo "</div>";
                    echo "</div>";
                }
                echo "<a href=\"$href\" class=\"button delete\" id=\"delete\">Deletar</a>";
            echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum produto encontrado.</p>";
}
?>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>