CREATE DATABASE ecotechroots;
USE ecotechroots;

ALTER TABLE tb_publicacao ADD COLUMN img_publicacao VARCHAR(255);


  CREATE TABLE tb_usuarios (
    id_usuarios INT AUTO_INCREMENT PRIMARY KEY,
    nm_usuario VARCHAR(100),
    email VARCHAR(100),
    senha VARCHAR(225),
    telefone CHAR(11),
    reset_token VARCHAR(100) 
);


  CREATE TABLE tb_perfil (
    id_perfil INT AUTO_INCREMENT PRIMARY KEY,
    img_perfil VARCHAR(255),
    tb_usuarios_id_usuarios INT,
    nm_usuario VARCHAR(45),
    biografia TEXT(150),
    FOREIGN KEY (tb_usuarios_id_usuarios) REFERENCES tb_usuarios(id_usuarios)
);
 
 
  CREATE TABLE tb_publicacao (
    id_publicacao INT AUTO_INCREMENT PRIMARY KEY,
    tb_usuarios_id_usuarios INT,
    nm_publicacao VARCHAR(45),
    descricao TEXT(150),
    coordenadas POINT,
    FOREIGN KEY (tb_usuarios_id_usuarios) REFERENCES tb_usuarios(id_usuarios)
); 
  
  CREATE TABLE tb_plantios (
    id_plantio INT AUTO_INCREMENT PRIMARY KEY,
    tb_usuarios_id_usuarios INT,
    tb_publicacao_id_publicacao INT,
    dt_plantio DATE,
    qt_mudas INT,
    descricao VARCHAR(150),
    coordenadas POINT,
    nm_mudas VARCHAR(45),
    FOREIGN KEY (tb_usuarios_id_usuarios) REFERENCES tb_usuarios(id_usuarios),
    FOREIGN KEY (tb_publicacao_id_publicacao) REFERENCES tb_publicacao(id_publicacao)
); 

  CREATE TABLE tb_pin (
    id_pin INT AUTO_INCREMENT PRIMARY KEY,
    tb_usuarios_id_usuarios INT,
    coordenadas POINT,
    dt_pin DATE,
    FOREIGN KEY (tb_usuarios_id_usuarios) REFERENCES tb_usuarios(id_usuarios)
);