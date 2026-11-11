<?php

require_once 'Tarefa.php';
require_once 'dao/TarefaDAO.php';

function e(string $texto): string
{
  return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$dao = new TarefaDAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['titulo'])) {

    $titulo = trim($_POST['titulo']);
    $importancia = $_POST['importancia'] ?? 'media';
    $dataEntrega = $_POST['data_entrega'] ?? '';

    if (
      $titulo !== '' &&
      in_array($importancia, ['alta', 'media', 'baixa'], true) &&
      $dataEntrega !== ''
    ) {
      $tarefa = new Tarefa(
        $titulo,
        $importancia,
        date('Y-m-d'),
        $dataEntrega
      );

      $dao->cadastrar($tarefa);

      setcookie(
        'ultima_importancia',
        $importancia,
        time() + 60 * 60 * 24 * 30,
        '/'
      );
    }
  } elseif (isset($_POST['concluir'])) {

    $dao->concluir((int) $_POST['concluir']);
  } elseif (isset($_POST['excluir'])) {

    $dao->excluir((int) $_POST['excluir']);
  }

  header('Location: index.php');
  exit;
}

$ultima = $_COOKIE['ultima_importancia'] ?? 'media';

$tarefas = $dao->listarTodos();

$pendentes = [];
$concluidas = [];

foreach ($tarefas as $tarefa) {

  if ($tarefa->isConcluida()) {
    $concluidas[] = $tarefa;
  } else {
    $pendentes[] = $tarefa;
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Minha Tasklist</title>

  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <main class="page">

    <div class="container">

      <header class="header">

        <h1>Minha Tasklist</h1>

        <span class="counter">
          <?= count($pendentes) ?>
          <?= count($pendentes) === 1 ? 'tarefa pendente' : 'tarefas pendentes' ?>
        </span>

      </header>

      <section class="card">

        <h2>Nova tarefa</h2>

        <form class="task-form" method="post" action="">

          <div class="field">

            <label for="titulo">Tarefa</label>

            <input
              id="titulo"
              name="titulo"
              type="text"
              placeholder="Ex.: Estudar para a prova"
              required>

          </div>

          <div class="field-row">

            <div class="field">

              <label for="importancia">Importância</label>

              <select id="importancia" name="importancia">

                <option value="alta" <?= $ultima === 'alta' ? 'selected' : '' ?>>
                  Alta
                </option>

                <option value="media" <?= $ultima === 'media' ? 'selected' : '' ?>>
                  Média
                </option>

                <option value="baixa" <?= $ultima === 'baixa' ? 'selected' : '' ?>>
                  Baixa
                </option>

              </select>

            </div>

            <div class="field">

              <label for="criacao">Data de criação</label>

              <input
                id="criacao"
                name="data_criacao"
                type="date"
                value="<?= date('Y-m-d') ?>"
                readonly>

            </div>

            <div class="field">

              <label for="entrega">Data de entrega</label>

              <input
                id="entrega"
                name="data_entrega"
                type="date"
                required>

            </div>

          </div>

          <div>
            <button type="submit" class="btn btn-primary">
              Adicionar tarefa
            </button>
          </div>

        </form>

      </section>

      <div class="lists">

        <section class="list">

          <h2>Pendentes (<?= count($pendentes) ?>)</h2>

          <?php foreach ($pendentes as $tarefa): ?>

            <article class="task">

              <div class="task-top">

                <strong class="task-title">
                  <?= e($tarefa->getTitulo()) ?>
                </strong>

                <span class="badge badge-<?= e($tarefa->getImportancia()) ?>">
                  <?= e($tarefa->getImportanciaTexto()) ?>
                </span>

              </div>

              <div class="task-dates">

                <span>
                  Criada em: <?= $tarefa->getDataCriacaoFormatada() ?>
                </span>

                <span>
                  Entrega: <?= $tarefa->getDataEntregaFormatada() ?>
                </span>

              </div>

              <div class="task-actions">

                <form method="post">

                  <button
                    type="submit"
                    name="concluir"
                    value="<?= $tarefa->getId() ?>"
                    class="btn btn-primary">
                    <svg
                      aria-hidden="true"
                      width="18"
                      height="18"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="3"
                      stroke-linecap="round"
                      stroke-linejoin="round">
                      <path d="M4 12l5 5L20 6" />
                    </svg>

                    Concluir
                  </button>

                </form>

                <a
                  class="btn"
                  href="editar.php?id=<?= $tarefa->getId() ?>">
                  Editar
                </a>

                <form method="post">

                  <button
                    type="submit"
                    name="excluir"
                    value="<?= $tarefa->getId() ?>"
                    class="btn">
                    Excluir
                  </button>

                </form>

              </div>

            </article>

          <?php endforeach; ?>

        </section>

        <section class="list">

          <h2>Concluídas (<?= count($concluidas) ?>)</h2>

          <?php foreach ($concluidas as $tarefa): ?>

            <article class="task done">

              <div class="task-top">

                <strong class="task-title">
                  <?= e($tarefa->getTitulo()) ?>
                </strong>

                <span class="badge badge-<?= e($tarefa->getImportancia()) ?>">
                  <?= e($tarefa->getImportanciaTexto()) ?>
                </span>

              </div>

              <div class="task-dates">

                <span>
                  Criada em: <?= $tarefa->getDataCriacaoFormatada() ?>
                </span>

                <span>
                  Entrega: <?= $tarefa->getDataEntregaFormatada() ?>
                </span>

              </div>

              <div class="task-actions">

                <form method="post">

                  <button
                    type="submit"
                    name="excluir"
                    value="<?= $tarefa->getId() ?>"
                    class="btn">
                    Excluir
                  </button>

                </form>

              </div>

            </article>

          <?php endforeach; ?>

        </section>

      </div>

    </div>

  </main>

</body>

</html>