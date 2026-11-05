<?php
require_once 'Tarefa.php';

// Escapa o texto antes de mostrar na página (evita injeção de HTML)
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// As listas começam vazias. Quando o banco estiver pronto, elas virão do TarefaDAO:
// $pendentes  = $dao->listarPendentes();
// $concluidas = $dao->listarConcluidas();
$pendentes  = [];
$concluidas = [];

$totalPendentes  = count($pendentes);
$totalConcluidas = count($concluidas);
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
          <?= $totalPendentes ?> <?= $totalPendentes === 1 ? 'tarefa pendente' : 'tarefas pendentes' ?>
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
                <option value="alta">Alta</option>
                <option value="media">Média</option>
                <option value="baixa">Baixa</option>
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
          <h2>Pendentes (<?= $totalPendentes ?>)</h2>

          <?php foreach ($pendentes as $tarefa): ?>
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
              <button type="button" class="btn btn-primary">
                <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5L20 6"/></svg>
                Concluir
              </button>
              <button type="button" class="btn">Editar</button>
              <button type="button" class="btn">Excluir</button>
            </div>
          </article>
          <?php endforeach; ?>

        </section>

        <section class="list">
          <h2>Concluídas (<?= $totalConcluidas ?>)</h2>

          <?php foreach ($concluidas as $tarefa): ?>
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
              <button type="button" class="btn">Excluir</button>
            </div>
          </article>
          <?php endforeach; ?>

        </section>

      </div>
    </div>
  </main>
</body>
</html>
