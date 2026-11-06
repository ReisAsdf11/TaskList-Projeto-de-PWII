<?php
require_once 'Tarefa.php';   // antes do session_start(), para a sessão reconhecer a classe
session_start();

// Pega o id da URL (editar.php?id=3) e procura a tarefa na sessão
$id = $_GET['id'] ?? '';
if (!isset($_SESSION['tarefas'][$id])) {
    header('Location: index.php');
    exit;
}
$tarefa = $_SESSION['tarefas'][$id];

// Quando o formulário é enviado: atualiza a tarefa e volta para a lista
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarefa->setTitulo($_POST['titulo']);
    $tarefa->setImportancia($_POST['importancia']);
    $tarefa->setDataEntrega($_POST['data_entrega']);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar tarefa – Minha Tasklist</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="page">
    <div class="container">

      <header class="header">
        <h1>Minha Tasklist</h1>
      </header>

      <section class="card">
        <h2>Editar tarefa</h2>
        <form class="task-form" method="post">
          <div class="field">
            <label for="titulo">Tarefa</label>
            <input id="titulo" name="titulo" type="text" value="<?= htmlspecialchars($tarefa->getTitulo(), ENT_QUOTES, 'UTF-8') ?>" required>
          </div>

          <div class="field-row">
            <div class="field">
              <label for="importancia">Importância</label>
              <select id="importancia" name="importancia">
                <option value="alta" <?= $tarefa->getImportancia() === 'alta' ? 'selected' : '' ?>>Alta</option>
                <option value="media" <?= $tarefa->getImportancia() === 'media' ? 'selected' : '' ?>>Média</option>
                <option value="baixa" <?= $tarefa->getImportancia() === 'baixa' ? 'selected' : '' ?>>Baixa</option>
              </select>
            </div>
            <div class="field">
              <label for="criacao">Data de criação</label>
              <input id="criacao" type="date" value="<?= $tarefa->getDataCriacao() ?>" readonly>
            </div>
            <div class="field">
              <label for="entrega">Data de entrega</label>
              <input id="entrega" name="data_entrega" type="date" value="<?= $tarefa->getDataEntrega() ?>" required>
            </div>
          </div>

          <div class="task-actions">
            <button type="submit" class="btn btn-primary">Salvar alterações</button>
            <a class="btn" href="index.php">Cancelar</a>
          </div>
        </form>
      </section>

    </div>
  </main>
</body>
</html>