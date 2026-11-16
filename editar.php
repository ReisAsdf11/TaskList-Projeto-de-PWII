
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
<html lang="pt-BR" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar tarefa – Minha Tasklist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

<main class="container py-5">

    <header class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-3 mb-4 border-bottom">
        <h1 class="h2 mb-0">Minha Tasklist</h1>
    </header>

    <section class="card">
        <div class="card-body">

            <h2 class="h4 card-title mb-3">Editar tarefa</h2>

            <form method="post">

                <div class="mb-3">
                    <label for="titulo" class="form-label">Tarefa</label>
                    <input
                        id="titulo"
                        name="titulo"
                        type="text"
                        class="form-control"
                        value="<?= htmlspecialchars($tarefa->getTitulo(), ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>

                <div class="row g-3 mb-3">

                    <div class="col-md-4">
                        <label for="importancia" class="form-label">Importância</label>
                        <select id="importancia" name="importancia" class="form-select">
                            <option value="alta" <?= $tarefa->getImportancia() === 'alta' ? 'selected' : '' ?>>Alta</option>
                            <option value="media" <?= $tarefa->getImportancia() === 'media' ? 'selected' : '' ?>>Média</option>
                            <option value="baixa" <?= $tarefa->getImportancia() === 'baixa' ? 'selected' : '' ?>>Baixa</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="criacao" class="form-label">Data de criação</label>
                        <input id="criacao" type="date" class="form-control" value="<?= $tarefa->getDataCriacao() ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label for="entrega" class="form-label">Data de entrega</label>
                        <input
                            id="entrega"
                            name="data_entrega"
                            type="date"
                            class="form-control"
                            min="<?= date('Y-m-d') ?>"
                            value="<?= $tarefa->getDataEntrega() ?>"
                            required
                        >
                    </div>

                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
                </div>

            </form>

        </div>
    </section>

</main>

</body>
</html>
