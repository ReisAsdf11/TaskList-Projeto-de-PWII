
<?php

require_once 'Tarefa.php';
require_once 'config/Conexao.php';
require_once 'dao/TarefaDao.php';

$dao = new TarefaDao();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$tarefa = $dao->buscarPorId($id);

if (!$tarefa) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tarefa->setTitulo(trim($_POST['titulo']));
    $tarefa->setImportancia($_POST['importancia']);
    $tarefa->setDataEntrega($_POST['data_entrega']);

    $dao->atualizar($id, $tarefa);

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
                <input
                    id="titulo"
                    name="titulo"
                    type="text"
                    value="<?= htmlspecialchars($tarefa->getTitulo(), ENT_QUOTES, 'UTF-8') ?>"
                    required
                >
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
                    <input
                        id="entrega"
                        name="data_entrega"
                        type="date"
                        min="<?= date('Y-m-d') ?>"
                        value="<?= $tarefa->getDataEntrega() ?>"
                        required
                    >
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
