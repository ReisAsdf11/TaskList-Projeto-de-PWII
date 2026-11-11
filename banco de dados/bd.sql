
CREATE DATABASE IF NOT EXISTS tasklist
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tasklist;

CREATE TABLE IF NOT EXISTS tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    importancia ENUM('alta', 'media', 'baixa') NOT NULL DEFAULT 'media',
    data_criacao DATE NOT NULL,
    data_entrega DATE NOT NULL,
    concluida TINYINT(1) NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
