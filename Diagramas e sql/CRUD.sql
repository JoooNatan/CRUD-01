-- Criacao da tabela de situacoes
CREATE TABLE sits_usuarios (
	id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(45) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NULL
);

-- Criacao da tabela de niveis de acessos
CREATE TABLE niveis_acessos (
	id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(45) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NULL
);

-- Adicionando index para sit_usuario_id e nivel_acesso_id
ALTER TABLE usuarios ADD INDEX (sit_usuario_id);
ALTER TABLE usuarios ADD INDEX (nivel_acesso_id);

-- Criando as relacoes das tabelas
ALTER TABLE usuarios ADD FOREIGN KEY (sit_usuario_id) REFERENCES sits_usuarios (id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE usuarios ADD FOREIGN KEY (nivel_acesso_id) REFERENCES niveis_acessos (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

