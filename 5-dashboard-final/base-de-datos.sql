-- Base de datos para el curso PHP
CREATE DATABASE IF NOT EXISTS php_curso CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE php_curso;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol ENUM('admin','usuario') DEFAULT 'usuario',
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Usuario de prueba: email test@example.com / contraseña 123456
INSERT INTO usuarios (nombre, email, password_hash, rol)
VALUES ('Admin Demo', 'test@example.com', SHA2('123456', 256), 'admin')
ON DUPLICATE KEY UPDATE email=email;
