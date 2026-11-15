
<?php

require_once __DIR__ . '/../config/Conexao.php';
require_once __DIR__ . '/../Tarefa.php';

class TarefaDAO
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::conectar();
    }
    
    public function cadastrar(Tarefa $tarefa): bool
    {
        $sql = "INSERT INTO tarefas
                (titulo, importancia, data_criacao, data_entrega, concluida)
                VALUES
                (:titulo, :importancia, :data_criacao, :data_entrega, :concluida)";

        $stmt = $this->conexao->prepare($sql);

        return $stmt->execute([
            ':titulo' => $tarefa->getTitulo(),
            ':importancia' => $tarefa->getImportancia(),
            ':data_criacao' => $tarefa->getDataCriacao(),
            ':data_entrega' => $tarefa->getDataEntrega(),
            ':concluida' => $tarefa->isConcluida() ? 1 : 0
        ]);
    }

    public function listarTodos(): array
    {
        $sql = "SELECT * FROM tarefas
                ORDER BY concluida ASC, data_entrega ASC, id ASC";

        $stmt = $this->conexao->query($sql);

        $tarefas = [];

        while ($dados = $stmt->fetch()) {
            $tarefas[] = $this->montarTarefa($dados);
        }

        return $tarefas;
    }

    public function buscarPorId(int $id): ?Tarefa
    {
        $sql = "SELECT * FROM tarefas WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':id' => $id]);

        $dados = $stmt->fetch();

        return $dados ? $this->montarTarefa($dados) : null;
    }

    public function atualizar(int $id, Tarefa $tarefa): bool
    {
        $sql = "UPDATE tarefas
                SET titulo = :titulo,
                    importancia = :importancia,
                    data_entrega = :data_entrega
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);

        return $stmt->execute([
            ':titulo' => $tarefa->getTitulo(),
            ':importancia' => $tarefa->getImportancia(),
            ':data_entrega' => $tarefa->getDataEntrega(),
            ':id' => $id
        ]);
    }
    public function concluir(int $id): bool
    {
        $sql = "UPDATE tarefas
                SET concluida = 1
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
    public function excluir(int $id): bool
    {
        $sql = "DELETE FROM tarefas WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
    private function montarTarefa(array $dados): Tarefa
    {
        return new Tarefa(
            $dados['titulo'],
            $dados['importancia'],
            $dados['data_criacao'],
            $dados['data_entrega'],
            (bool) $dados['concluida'],
            (int) $dados['id']
        );
    }
}
