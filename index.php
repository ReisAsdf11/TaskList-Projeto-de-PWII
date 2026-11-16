
<?php

require_once 'Tarefa.php';
require_once 'config/Conexao.php';
require_once 'dao/TarefaDao.php';

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$dao = new TarefaDao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['titulo'])) {

        $tarefa = new Tarefa(
            trim($_POST['titulo']),
            $_POST['importancia'],
            date('Y-m-d'),
            $_POST['data_entrega']
        );

        $dao->cadastrar($tarefa);

        setcookie(
            'ultima_importancia',
            $_POST['importancia'],
            time() + 60 * 60 * 24 * 30,
            '/'
        );

    } elseif (isset($_POST['concluir'])) {

        $dao->concluir((int) $_POST['concluir']);

    } elseif (isset($_POST['excluir'])) {

        $dao->excluir((int) $_POST['excluir']);
    }

    header('Location: index.php');
    exit;
}

$todasTarefas = $dao->listarTodos();

$pendentes = [];
$concluidas = [];

foreach ($todasTarefas as $tarefa) {

    if ($tarefa->isConcluida()) {
        $concluidas[] = $tarefa;
    } else {
        $pendentes[] = $tarefa;
    }
}

$ultima = $_COOKIE['ultima_importancia'] ?? 'media';

$classesImportancia = [
    'alta'  => 'text-bg-danger',
    'media' => 'text-bg-warning',
    'baixa' => 'text-bg-secondary',
];

?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minha Tasklist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

<main class="container py-5">

    <header class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-3 mb-4 border-bottom">
        <h1 class="h2 mb-0">Minha Tasklist</h1>
        <span class="badge rounded-pill text-bg-secondary fs-6">
            <?= count($pendentes) ?>
            <?= count($pendentes) === 1 ? 'tarefa pendente' : 'tarefas pendentes' ?>
        </span>
    </header>

    <section class="card mb-4">
        <div class="card-body">

            <h2 class="h4 card-title mb-3">Nova tarefa</h2>

            <form method="post">

                <div class="mb-3">
                    <label for="titulo" class="form-label">Tarefa</label>
                    <input id="titulo" name="titulo" type="text" class="form-control" placeholder="Ex.: Estudar para a prova" required>
                </div>

                <div class="row g-3 mb-3">

                    <div class="col-md-4">
                        <label for="importancia" class="form-label">Importância</label>
                        <select id="importancia" name="importancia" class="form-select">
                            <option value="alta" <?= $ultima === 'alta' ? 'selected' : '' ?>>Alta</option>
                            <option value="media" <?= $ultima === 'media' ? 'selected' : '' ?>>Média</option>
                            <option value="baixa" <?= $ultima === 'baixa' ? 'selected' : '' ?>>Baixa</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="criacao" class="form-label">Data de criação</label>
                        <input id="criacao" type="date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label for="entrega" class="form-label">Data de entrega</label>
                        <input id="entrega" name="data_entrega" type="date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Adicionar tarefa</button>

            </form>

        </div>
    </section>

    <div class="row g-4">

        <section class="col-lg-6 d-flex flex-column gap-3">

            <h2 class="h4 mb-0">Pendentes (<?= count($pendentes) ?>)</h2>

            <?php foreach ($pendentes as $tarefa): ?>

                <article class="card">
                    <div class="card-body d-flex flex-column gap-3">

                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                            <strong class="card-title h5 mb-0"><?= e($tarefa->getTitulo()) ?></strong>
                            <span class="badge rounded-pill <?= $classesImportancia[$tarefa->getImportancia()] ?? 'text-bg-secondary' ?>">
                                <?= e($tarefa->getImportanciaTexto()) ?>
                            </span>
                        </div>

                        <div class="d-flex flex-wrap column-gap-4 small text-body-secondary">
                            <span>Criada em: <?= $tarefa->getDataCriacaoFormatada() ?></span>
                            <span>Entrega: <?= $tarefa->getDataEntregaFormatada() ?></span>
                        </div>

                        <div class="d-flex flex-wrap gap-2">

                            <form method="post">
                                <button type="submit" name="concluir" value="<?= $tarefa->getId() ?>" class="btn btn-sm btn-primary">
                                    Concluir
                                </button>
                            </form>

                            <a class="btn btn-sm btn-outline-secondary" href="editar.php?id=<?= $tarefa->getId() ?>">Editar</a>

                            <form method="post">
                                <button type="submit" name="excluir" value="<?= $tarefa->getId() ?>" class="btn btn-sm btn-outline-danger">
                                    Excluir
                                </button>
                            </form>

                        </div>

                    </div>
                </article>

            <?php endforeach; ?>

            <?php if (empty($pendentes)): ?>
                <p class="text-body-secondary">Nenhuma tarefa pendente.</p>
            <?php endif; ?>

        </section>

        <section class="col-lg-6 d-flex flex-column gap-3">

            <h2 class="h4 mb-0">Concluídas (<?= count($concluidas) ?>)</h2>

            <?php foreach ($concluidas as $tarefa): ?>

                <article class="card bg-body-tertiary">
                    <div class="card-body d-flex flex-column gap-3">

                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                            <strong class="card-title h5 mb-0 text-decoration-line-through text-body-secondary"><?= e($tarefa->getTitulo()) ?></strong>
                            <span class="badge rounded-pill text-bg-secondary">
                                <?= e($tarefa->getImportanciaTexto()) ?>
                            </span>
                        </div>

                        <div class="d-flex flex-wrap column-gap-4 small text-body-secondary">
                            <span>Criada em: <?= $tarefa->getDataCriacaoFormatada() ?></span>
                            <span>Entrega: <?= $tarefa->getDataEntregaFormatada() ?></span>
                        </div>

                        <div class="d-flex flex-wrap gap-2">

                            <form method="post">
                                <button type="submit" name="excluir" value="<?= $tarefa->getId() ?>" class="btn btn-sm btn-outline-danger">
                                    Excluir
                                </button>
                            </form>

                        </div>

                    </div>
                </article>

            <?php endforeach; ?>

            <?php if (empty($concluidas)): ?>
                <p class="text-body-secondary">Nenhuma tarefa concluída.</p>
            <?php endif; ?>

        </section>

    </div>

</main>

</body>
</html>
