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

include_once '../config/database.php';
include_once '../models/Produto.php';
include_once '../models/Categoria.php';

class ProdutoController {
    private $conn;
    private $produto;
    private $categoria;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->produto = new Produto($this->conn);
        $this->categoria = new Categoria($this->conn);
    }

    public function index() {
        $stmt = $this->produto->read();
        $num = $stmt->rowCount();
        return ['stmt' => $stmt, 'num' => $num];
    }

    public function create($nome, $descricao, $preco, $categoria_id, $importante, $genero, $notas) {
        $this->produto->nome = $nome;
        $this->produto->descricao = $descricao;
        $this->produto->preco = $preco;
        $this->produto->categoria_id = $categoria_id;
        $this->produto->importante = $importante;
        $this->produto->genero = $genero;
        $this->produto->notas = $notas;
        if($this->produto->create()) {
            return true;
        }
        return false;
    }

    public function readOne($id) {
        $this->produto->id = $id;
        $this->produto->readOne();
        return $this->produto;
    }

    public function update($id, $nome, $descricao, $preco, $categoria_id, $importante, $genero, $notas) {
        $this->produto->id = $id;
        $this->produto->nome = $nome;
        $this->produto->descricao = $descricao;
        $this->produto->preco = $preco;
        $this->produto->categoria_id = $categoria_id;
        $this->produto->importante = $importante;
        $this->produto->genero = $genero;
        $this->produto->notas = $notas;
        if($this->produto->update()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $this->produto->id = $id;
        if($this->produto->delete()) {
            return true;
        }
        return false;
    }

    public function getCategorias() {
        $stmt = $this->categoria->read();
        return $stmt;
    }
}
?>
