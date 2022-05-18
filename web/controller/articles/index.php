
<?php
require_once 'model/connection.php';

function article_list() {
    $db = new Connect();
    $pdo = $db->pdo();
    $sql = "SELECT * FROM articles";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    include 'template/articles.php';
}

function article_detail($id) {
    $_SERVER['REQUEST_URI'];
    $db = new Connect();
    $pdo = $db->pdo();
    $sql = "SELECT * FROM articles where id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    include 'template/articles.php';
}
