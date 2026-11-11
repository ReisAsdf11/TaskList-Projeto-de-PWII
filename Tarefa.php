<?php

class Tarefa
{
    private string $titulo;
    private string $importancia; 
    private string $dataCriacao;   
    private string $dataEntrega;  
    private bool $concluida;

    public function __construct(
        string $titulo,
        string $importancia,
        string $dataCriacao,
        string $dataEntrega,
        bool $concluida = false
    ) {
        $this->titulo      = $titulo;
        $this->importancia = $importancia;
        $this->dataCriacao = $dataCriacao;
        $this->dataEntrega = $dataEntrega;
        $this->concluida   = $concluida;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getImportancia(): string
    {
        return $this->importancia;
    }

    public function getDataCriacao(): string
    {
        return $this->dataCriacao;
    }

    public function getDataEntrega(): string
    {
        return $this->dataEntrega;
    }

    public function isConcluida(): bool
    {
        return $this->concluida;
    }


    public function getImportanciaTexto(): string
    {
        if ($this->importancia === 'media') {
            return 'Média';
        }

        return ucfirst($this->importancia);
    }

    public function getDataCriacaoFormatada(): string
    {
        return (new DateTime($this->dataCriacao))->format('d/m/Y');
    }

    public function getDataEntregaFormatada(): string
    {
        return (new DateTime($this->dataEntrega))->format('d/m/Y');
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function setImportancia(string $importancia): void
    {
        $this->importancia = $importancia;
    }

    public function setDataEntrega(string $dataEntrega): void
    {
        $this->dataEntrega = $dataEntrega;
    }

    public function concluir(): void
    {
        $this->concluida = true;
    }
}