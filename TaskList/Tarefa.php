<?php

class Tarefa{
    private int $id;            
    private string $titulo;
    private string $importancia;  
    private string $dataCriacao;  
    private string $dataEntrega;
    private bool $concluida;

    public function __construct(int $id, string $titulo, string $importancia, string $dataCriacao, string $dataEntrega, bool $concluida = false) {
        $this->id          = $id;
        $this->titulo      = $titulo;
        $this->importancia = $importancia;
        $this->dataCriacao = $dataCriacao;
        $this->dataEntrega = $dataEntrega;
        $this->concluida   = $concluida;
    }


    public function getId(){
        return $this->id;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function getImportancia(){
        return $this->importancia;
    }

    public function getDataCriacao(){
        return $this->dataCriacao;
    }

    public function getDataEntrega(){
        return $this->dataEntrega;
    }

    public function isConcluida(){
        return $this->concluida;
    }

    public function getImportanciaTexto(){
    if ($this->importancia === 'media') {
        return 'Média';
    }

    return ucfirst($this->importancia);
}

    public function getDataCriacaoFormatada(){
        return (new DateTime($this->dataCriacao))->format('d/m/Y');
    }

    public function getDataEntregaFormatada(){
        return (new DateTime($this->dataEntrega))->format('d/m/Y');
    }


    public function concluir(){
        $this->concluida = true;
    }
}