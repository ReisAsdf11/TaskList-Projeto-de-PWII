<?php
require_once 'Tarefa.php';   // antes do session_start(), para a sessão reconhecer a classe
session_start();

// Escapa o texto antes de mostrar na página
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// SESSION: guarda as tarefas (banco provisório)
if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}

// Quando um formulário ou botão é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['titulo'])) {                        // formulário "Nova tarefa"
        $_SESSION['tarefas'][] = new Tarefa($_POST['titulo'], $_POST['importancia'], date('Y-m-d'), $_POST['data_entrega']);

        // COOKIE: lembra a última importância escolhida (30 dias)
        setcookie('ultima_importancia', $_POST['importancia'], time() + 60 * 60 * 24 * 30, '/');
    } elseif (isset($_POST['concluir'], $_SESSION['tarefas'][$_POST['concluir']])) {   // botão Concluir
        $_SESSION['tarefas'][$_POST['concluir']]->concluir();
    } elseif (isset($_POST['excluir'])) {                 // botão Excluir
        unset($_SESSION['tarefas'][$_POST['excluir']]);
    }

    header('Location: index.php');   // evita reenviar o formulário ao apertar F5
    exit;
}

$ultima = $_COOKIE['ultima_importancia'] ?? 'media';

// Separa as tarefas em pendentes e concluídas (a chave de cada uma continua sendo o "id")
$pendentes  = [];
$concluidas = [];
foreach ($_SESSION['tarefas'] as $id => $t) {
    if ($t->isConcluida()) {
        $concluidas[$id] = $t;
    } else {
        $pendentes[$id] = $t;
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
          <?= count($pendentes) ?> <?= count($pendentes) === 1 ? 'tarefa pendente' : 'tarefas pendentes' ?>
        </span>
      </header>

      <section class="card">
        <h2>Nova tarefa</h2>
        <form class="task-form" method="post" action="">
          <div class="field">
            <label for="titulo">Tarefa</label>
            <input id="titulo" name="titulo" type="text" placeholder="Ex.: Estudar para a prova" required>
          </div>

          <div class="field-row">
            <div class="field">
              <label for="importancia">Importância</label>
              <select id="importancia" name="importancia">
                <option value="alta" <?= $ultima === 'alta' ? 'selected' : '' ?>>Alta</option>
                <option value="media" <?= $ultima === 'media' ? 'selected' : '' ?>>Média</option>
                <option value="baixa" <?= $ultima === 'baixa' ? 'selected' : '' ?>>Baixa</option>
              </select>
            </div>
            <div class="field">
              <label for="criacao">Data de criação</label>
              <input id="criacao" name="data_criacao" type="date" value="<?= date('Y-m-d') ?>" readonly>
            </div>
            <div class="field">
              <label for="entrega">Data de entrega</label>
              <input id="entrega" name="data_entrega" type="date" required>
            </div>
          </div>

          <div>
            <button type="submit" class="btn btn-primary">Adicionar tarefa</button>
          </div>
        </form>
      </section>

      <div class="lists">

        <section class="list">
          <h2>Pendentes (<?= count($pendentes) ?>)</h2>

          <?php foreach ($pendentes as $id => $tarefa): ?>
          <article class="task">
            <div class="task-top">
              <strong class="task-title"><?= e($tarefa->getTitulo()) ?></strong>
              <span class="badge badge-<?= e($tarefa->getImportancia()) ?>"><?= e($tarefa->getImportanciaTexto()) ?></span>
            </div>
            <div class="task-dates">
              <span>Criada em: <?= $tarefa->getDataCriacaoFormatada() ?></span>
              <span>Entrega: <?= $tarefa->getDataEntregaFormatada() ?></span>
            </div>
            <div class="task-actions">
              <form method="post">
                <button type="submit" name="concluir" value="<?= $id ?>" class="btn btn-primary">
                  <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5L20 6"/></svg>
                  Concluir
                </button>
              </form>
              <a class="btn" href="editar.php?id=<?= $id ?>">Editar</a>
              <form method="post">
                <button type="submit" name="excluir" value="<?= $id ?>" class="btn">Excluir</button>
              </form>
            </div>
          </article>
          <?php endforeach; ?>

        </section>

        <section class="list">
          <h2>Concluídas (<?= count($concluidas) ?>)</h2>

          <?php foreach ($concluidas as $id => $tarefa): ?>
          <article class="task done">
            <div class="task-top">
              <strong class="task-title"><?= e($tarefa->getTitulo()) ?></strong>
              <span class="badge badge-<?= e($tarefa->getImportancia()) ?>"><?= e($tarefa->getImportanciaTexto()) ?></span>
            </div>
            <div class="task-dates">
              <span>Criada em: <?= $tarefa->getDataCriacaoFormatada() ?></span>
              <span>Entrega: <?= $tarefa->getDataEntregaFormatada() ?></span>
            </div>
            <div class="task-actions">
              <form method="post">
                <button type="submit" name="excluir" value="<?= $id ?>" class="btn">Excluir</button>
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