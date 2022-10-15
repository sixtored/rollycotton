/*
 Navicat Premium Data Transfer

 Source Server         : sixtored
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : pos

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 03/08/2022 15:03:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for arqueo_caja
-- ----------------------------
DROP TABLE IF EXISTS `arqueo_caja`;
CREATE TABLE `arqueo_caja`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_caja` int(11) NULL DEFAULT NULL,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `fecha_apertura` datetime(0) NULL DEFAULT NULL,
  `fecha_cierre` datetime(0) NULL DEFAULT NULL,
  `monto_inicial` decimal(15, 2) NULL DEFAULT NULL,
  `monto_final` decimal(15, 2) NULL DEFAULT NULL,
  `total_ventas` decimal(15, 2) NULL DEFAULT NULL,
  `estado` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of arqueo_caja
-- ----------------------------
INSERT INTO `arqueo_caja` VALUES (1, 2, 1, '2021-09-06 15:16:14', '2021-09-07 08:35:46', 1000.00, 800.00, 160.00, 0);

-- ----------------------------
-- Table structure for cajas
-- ----------------------------
DROP TABLE IF EXISTS `cajas`;
CREATE TABLE `cajas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_caja` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `ubicacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `nombre` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `folio` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cajas
-- ----------------------------
INSERT INTO `cajas` VALUES (1, '000001', '  CENTRO', 1, NULL, '2021-08-18 20:54:28', 'LOCAL 1', 12);
INSERT INTO `cajas` VALUES (2, '00000002', 'QUIMILI - CENTRO', 1, '2021-08-18 17:14:59', '2021-09-06 15:40:54', 'LOCAL 2 ', 14);

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias`  (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES (1, 'Computacion', 1, '2021-08-16 22:15:49', '2021-08-16 20:15:49');
INSERT INTO `categorias` VALUES (2, 'Fiambres', 0, '2021-07-24 20:30:36', '2021-07-24 18:30:36');
INSERT INTO `categorias` VALUES (3, 'Articulos para el hogar', 1, '2021-07-24 20:33:20', '2021-07-24 18:33:20');
INSERT INTO `categorias` VALUES (4, 'Celulares', 1, '2021-07-24 18:33:33', '2021-07-24 18:33:33');
INSERT INTO `categorias` VALUES (5, 'Comestibles', 1, '2021-07-24 18:33:44', '2021-07-24 18:33:44');
INSERT INTO `categorias` VALUES (6, 'Carnes', 1, '2021-07-24 18:33:52', '2021-07-24 18:33:52');
INSERT INTO `categorias` VALUES (7, 'Pollos', 1, '2021-07-24 18:34:00', '2021-07-24 18:34:00');
INSERT INTO `categorias` VALUES (8, 'nueva categoria', 1, '2022-07-18 09:52:33', '2022-07-18 09:52:33');

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `domicilio` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `celular` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clientes
-- ----------------------------
INSERT INTO `clientes` VALUES (1, 'DIAZ SIXTO', 'QUIMILI', 'sixtod@gmail.com', '23873993', '2021-07-26 08:44:31', '2021-07-26 20:38:21', 1);
INSERT INTO `clientes` VALUES (2, 'Panchi', 'Quimili', 'panchi@email.com', '122112232323', '2021-08-30 16:01:39', '2021-08-30 16:01:39', 1);
INSERT INTO `clientes` VALUES (3, 'Juliancito', 'Sgo del Estero', 'juliancito@email.com', '348904032', '2021-08-30 16:02:01', '2021-08-30 16:02:01', 1);

-- ----------------------------
-- Table structure for compras
-- ----------------------------
DROP TABLE IF EXISTS `compras`;
CREATE TABLE `compras`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folio` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `id_cajero` int(8) NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_idcajero`(`id_cajero`) USING BTREE,
  CONSTRAINT `fk_idcajero` FOREIGN KEY (`id_cajero`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of compras
-- ----------------------------
INSERT INTO `compras` VALUES (1, '612409d09fa3d', 210.00, NULL, 1, '2021-08-23 15:49:44', '2021-08-23 15:49:44');
INSERT INTO `compras` VALUES (2, '61240c468ab5d', 200.00, NULL, 1, '2021-08-23 16:00:50', '2021-08-23 16:00:50');
INSERT INTO `compras` VALUES (3, '61240ce341ed4', 150.00, NULL, 1, '2021-08-23 16:02:56', '2021-08-23 16:02:56');
INSERT INTO `compras` VALUES (4, '61240ce341ed4', 150.00, NULL, 1, '2021-08-23 16:06:10', '2021-08-23 16:06:10');
INSERT INTO `compras` VALUES (5, '61240dd97e4ba', 260.00, 1, 1, '2021-08-23 16:07:13', '2021-08-23 16:07:13');
INSERT INTO `compras` VALUES (6, '61247e27ec9fe', 10500.00, NULL, 1, '2021-08-24 00:06:11', '2021-08-24 00:06:11');
INSERT INTO `compras` VALUES (7, '612480fd4aec7', 1300.00, NULL, 1, '2021-08-24 00:18:21', '2021-08-24 00:18:21');

-- ----------------------------
-- Table structure for compras_detalle
-- ----------------------------
DROP TABLE IF EXISTS `compras_detalle`;
CREATE TABLE `compras_detalle`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_compra` int(11) NULL DEFAULT NULL,
  `id_producto` int(11) NULL DEFAULT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cantidad` decimal(9, 3) NULL DEFAULT NULL,
  `precio` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  `subtotal` decimal(11, 2) NULL DEFAULT NULL,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_compra`(`id_compra`) USING BTREE,
  INDEX `fk_producto`(`id_producto`) USING BTREE,
  CONSTRAINT `fk_compra` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of compras_detalle
-- ----------------------------
INSERT INTO `compras_detalle` VALUES (1, 4, 3, 'PLATO BLANCO', 1.000, 150.00, '2021-08-23 16:06:10', '2021-08-23 16:06:10', 1, 150.00, '000003');
INSERT INTO `compras_detalle` VALUES (2, 5, 3, 'PLATO BLANCO', 1.000, 150.00, '2021-08-23 16:07:13', '2021-08-23 16:07:13', 1, 150.00, '000003');
INSERT INTO `compras_detalle` VALUES (3, 5, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, '2021-08-23 16:07:13', '2021-08-23 16:07:13', 1, 50.00, '000002');
INSERT INTO `compras_detalle` VALUES (4, 5, 5, '  PURE DE TOMATES', 6.000, 10.00, '2021-08-23 16:07:13', '2021-08-23 16:07:13', 1, 60.00, '000006');
INSERT INTO `compras_detalle` VALUES (5, 6, 3, 'PLATO BLANCO', 50.000, 150.00, '2021-08-24 00:06:11', '2021-08-24 00:06:11', 1, 7500.00, '000003');
INSERT INTO `compras_detalle` VALUES (6, 6, 2, 'MATE DE POLIMERO SUBLIMINABLE', 60.000, 50.00, '2021-08-24 00:06:11', '2021-08-24 00:06:11', 1, 3000.00, '000002');
INSERT INTO `compras_detalle` VALUES (7, 7, 3, 'PLATO BLANCO', 5.000, 150.00, '2021-08-24 00:18:21', '2021-08-24 00:18:21', 1, 750.00, '000003');
INSERT INTO `compras_detalle` VALUES (8, 7, 5, '  PURE DE TOMATES', 5.000, 10.00, '2021-08-24 00:18:21', '2021-08-24 00:18:21', 1, 50.00, '000006');
INSERT INTO `compras_detalle` VALUES (9, 7, 2, 'MATE DE POLIMERO SUBLIMINABLE', 10.000, 50.00, '2021-08-24 00:18:21', '2021-08-24 00:18:21', 1, 500.00, '000002');

-- ----------------------------
-- Table structure for configuracion
-- ----------------------------
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion`  (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `valor` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of configuracion
-- ----------------------------
INSERT INTO `configuracion` VALUES (1, 'tienda_nombre', 'Tienda SixtoRed', '2021-08-31 22:38:33', '2021-08-31 20:38:33');
INSERT INTO `configuracion` VALUES (2, 'tienda_domicilio', 'Quimili', '2021-08-31 22:38:33', '2021-08-31 20:38:33');
INSERT INTO `configuracion` VALUES (3, 'tienda_telefono', '3843461578', '2021-08-31 22:38:33', '2021-08-31 20:38:33');
INSERT INTO `configuracion` VALUES (4, 'tienda_email', 'sixtod@gmail.com', '2021-08-31 22:38:33', '2021-08-31 20:38:33');
INSERT INTO `configuracion` VALUES (5, 'tiquet_leyenda', 'Gracias por su compra.. en nuestro sistema de punto de venta online', '2021-08-31 22:38:33', '2021-08-31 20:38:33');
INSERT INTO `configuracion` VALUES (6, 'tienda_rfc', 'TCM970625MB1', '2021-09-11 09:27:01', '2021-09-11 09:27:01');

-- ----------------------------
-- Table structure for detalle_roles_permisos
-- ----------------------------
DROP TABLE IF EXISTS `detalle_roles_permisos`;
CREATE TABLE `detalle_roles_permisos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NULL DEFAULT NULL,
  `id_permiso` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 72 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_roles_permisos
-- ----------------------------
INSERT INTO `detalle_roles_permisos` VALUES (33, 2, 3);
INSERT INTO `detalle_roles_permisos` VALUES (34, 2, 10);
INSERT INTO `detalle_roles_permisos` VALUES (35, 2, 11);
INSERT INTO `detalle_roles_permisos` VALUES (36, 2, 12);
INSERT INTO `detalle_roles_permisos` VALUES (56, 1, 1);
INSERT INTO `detalle_roles_permisos` VALUES (57, 1, 2);
INSERT INTO `detalle_roles_permisos` VALUES (58, 1, 3);
INSERT INTO `detalle_roles_permisos` VALUES (59, 1, 4);
INSERT INTO `detalle_roles_permisos` VALUES (60, 1, 5);
INSERT INTO `detalle_roles_permisos` VALUES (61, 1, 6);
INSERT INTO `detalle_roles_permisos` VALUES (62, 1, 10);
INSERT INTO `detalle_roles_permisos` VALUES (63, 1, 11);
INSERT INTO `detalle_roles_permisos` VALUES (64, 1, 12);
INSERT INTO `detalle_roles_permisos` VALUES (65, 1, 14);
INSERT INTO `detalle_roles_permisos` VALUES (66, 1, 15);
INSERT INTO `detalle_roles_permisos` VALUES (67, 1, 16);
INSERT INTO `detalle_roles_permisos` VALUES (68, 1, 17);
INSERT INTO `detalle_roles_permisos` VALUES (69, 1, 18);
INSERT INTO `detalle_roles_permisos` VALUES (70, 1, 20);
INSERT INTO `detalle_roles_permisos` VALUES (71, 1, 21);

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `evento` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `ip` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `detalles` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of logs
-- ----------------------------
INSERT INTO `logs` VALUES (1, 1, 'Inicio de session', '::1', '2021-09-04 07:31:12', NULL);
INSERT INTO `logs` VALUES (2, 1, 'Inicio de session', '::1', '2021-09-04 07:38:35', NULL);
INSERT INTO `logs` VALUES (3, 1, 'Inicio de session', '::1', '2021-09-04 07:41:03', NULL);
INSERT INTO `logs` VALUES (4, 1, 'Inicio de session', '::1', '2021-09-04 07:48:00', NULL);
INSERT INTO `logs` VALUES (5, 1, 'Inicio de session', '::1', '2021-09-04 08:01:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.15');
INSERT INTO `logs` VALUES (6, 1, 'Inicio de session', '::1', '2021-09-04 17:53:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (7, 1, 'Inicio de session', '::1', '2021-09-05 06:54:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (8, 1, 'Inicio de session', '::1', '2021-09-05 18:58:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (9, 1, 'Inicio de session', '::1', '2021-09-06 10:52:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (10, 1, 'Inicio de session', '::1', '2021-09-06 14:38:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (11, 1, 'Inicio de session', '::1', '2021-09-07 05:43:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (12, 1, 'Inicio de session', '::1', '2021-09-10 15:25:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (13, 1, 'Inicio de session', '::1', '2021-09-12 04:47:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (14, 1, 'Inicio de session', '::1', '2021-09-13 09:30:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (15, 1, 'Inicio de session', '::1', '2021-09-13 16:52:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (16, 1, 'Inicio de session', '::1', '2021-09-13 17:54:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (17, 1, 'Inicio de session', '::1', '2021-09-15 12:12:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');
INSERT INTO `logs` VALUES (18, 1, 'Inicio de session', '::1', '2021-09-15 14:27:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.63 Safari/537.36');
INSERT INTO `logs` VALUES (19, 1, 'Inicio de session', '::1', '2021-12-02 16:24:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36');
INSERT INTO `logs` VALUES (20, 1, 'Inicio de session', '::1', '2022-01-12 06:11:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36 Edg/96.0.1054.57');
INSERT INTO `logs` VALUES (21, 1, 'Inicio de session', '::1', '2022-05-01 22:51:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36');
INSERT INTO `logs` VALUES (22, 1, 'Inicio de session', '::1', '2022-07-18 09:52:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36');
INSERT INTO `logs` VALUES (23, 1, 'Inicio de session', '::1', '2022-07-18 09:54:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36');
INSERT INTO `logs` VALUES (24, 1, 'Inicio de session', '::1', '2022-07-18 09:56:46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36');
INSERT INTO `logs` VALUES (25, 1, 'Inicio de session', '::1', '2022-08-03 11:48:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36');
INSERT INTO `logs` VALUES (26, 1, 'Inicio de session', '::1', '2022-08-03 12:12:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36');

-- ----------------------------
-- Table structure for permisos
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `tipo` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permisos
-- ----------------------------
INSERT INTO `permisos` VALUES (1, 'MenuProductos', 1);
INSERT INTO `permisos` VALUES (2, 'SubProductos', 2);
INSERT INTO `permisos` VALUES (3, 'ProductosCatalogo', 3);
INSERT INTO `permisos` VALUES (4, 'ProductosNuevo', 3);
INSERT INTO `permisos` VALUES (5, 'ProductosEliminados', 3);
INSERT INTO `permisos` VALUES (6, 'ProductosEditar', 3);
INSERT INTO `permisos` VALUES (7, 'ProductosEliminar', 3);
INSERT INTO `permisos` VALUES (8, 'ProductosCodigoBarra', 3);
INSERT INTO `permisos` VALUES (9, 'SubUnidades', 2);
INSERT INTO `permisos` VALUES (10, 'UnidadesCatalogo', 3);
INSERT INTO `permisos` VALUES (11, 'UnidadesNuevo', 3);
INSERT INTO `permisos` VALUES (12, 'UnidadesEditar', 3);
INSERT INTO `permisos` VALUES (13, 'UnidadesEliminar', 3);
INSERT INTO `permisos` VALUES (14, 'UnidadesEliminados', 3);
INSERT INTO `permisos` VALUES (15, 'SubCategorias', 2);
INSERT INTO `permisos` VALUES (16, 'CategoriasCatalogo', 3);
INSERT INTO `permisos` VALUES (17, 'CategoriasNuevo', 3);
INSERT INTO `permisos` VALUES (18, 'CaegoriasEliminados', 3);
INSERT INTO `permisos` VALUES (19, 'CategoriasEditar', 3);
INSERT INTO `permisos` VALUES (20, 'MenuClientes', 1);
INSERT INTO `permisos` VALUES (21, 'ClientesCatalogo', 3);
INSERT INTO `permisos` VALUES (22, 'MenuUsuarios', 1);

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `precio_venta` decimal(11, 2) NULL DEFAULT 0.00,
  `precio_compra` decimal(11, 2) NULL DEFAULT 0.00,
  `id_unidad` smallint(4) NULL DEFAULT NULL,
  `id_categoria` smallint(4) NULL DEFAULT NULL,
  `existencia` decimal(9, 3) NULL DEFAULT 0.000,
  `stock_min` decimal(9, 3) NULL DEFAULT 0.000,
  `controla_stock` tinyint(1) NULL DEFAULT 0,
  `activo` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `codigo`(`codigo`) USING BTREE,
  INDEX `fk_unidades`(`id_unidad`) USING BTREE,
  INDEX `fk_caegorias`(`id_categoria`) USING BTREE,
  CONSTRAINT `fk_caegorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_unidades` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES (2, '000002', 'MATE DE POLIMERO SUBLIMINABLE', 100.00, 50.00, 6, 3, 72.000, 2.000, 1, 1, '2021-07-25 23:46:16', '2021-09-02 21:12:33');
INSERT INTO `productos` VALUES (3, '000003', 'PLATO BLANCO', 200.00, 150.00, 8, 3, 59.000, 6.000, 1, 1, '2021-07-25 21:51:20', '2021-09-06 17:40:54');
INSERT INTO `productos` VALUES (4, '7798156760642', 'PURE DE TOMATES', 80.00, 50.00, 6, 5, 10.000, 5.000, 1, 1, '2021-08-19 19:12:27', '2021-08-19 19:12:27');
INSERT INTO `productos` VALUES (5, '000006', '  PURE DE TOMATES', 8.00, 10.00, 6, 1, 8.000, 2.000, 1, 1, '2021-08-19 19:17:08', '2021-09-06 17:40:54');
INSERT INTO `productos` VALUES (6, '000005', 'SERVICIOS NUEVO', 1200.00, 1000.00, 6, 1, 5.000, 6.000, 1, 1, '2021-09-01 05:29:34', '2021-09-02 20:30:11');
INSERT INTO `productos` VALUES (7, '00005', 'NUEVO PRODUCTO', 1500.00, 1000.00, 6, 1, 2.000, 1.000, 1, 0, '2021-09-01 05:36:17', '2021-09-01 07:38:55');
INSERT INTO `productos` VALUES (8, '00008', ' NUEVO PRODUCTO', 1500.00, 1000.00, 6, 1, 2.000, 1.000, 1, 1, '2021-09-01 05:38:25', NULL);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `rol` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `nota` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nombre`(`nombre`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Administrador ', 'admin', 'Control total', '2021-07-26 21:21:27', '2021-08-16 21:04:46', 1);
INSERT INTO `roles` VALUES (2, 'Vendedor ', 'Cajero', 'Venta de productos al mostrador', '2021-08-18 22:37:40', '2021-08-18 22:37:40', 1);

-- ----------------------------
-- Table structure for temporal_compra
-- ----------------------------
DROP TABLE IF EXISTS `temporal_compra`;
CREATE TABLE `temporal_compra`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NULL DEFAULT NULL,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `folio` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cantidad` decimal(9, 3) NULL DEFAULT NULL,
  `precio` decimal(11, 2) NULL DEFAULT NULL,
  `subtotal` decimal(11, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temporal_compra
-- ----------------------------
INSERT INTO `temporal_compra` VALUES (34, 2, '000002', 'MATE DE POLIMERO SUBLIMINABLE', '612409d09fa3d', 1.000, 50.00, 50.00);
INSERT INTO `temporal_compra` VALUES (35, 3, '000003', 'PLATO BLANCO', '612409d09fa3d', 1.000, 150.00, 150.00);
INSERT INTO `temporal_compra` VALUES (36, 5, '000006', '  PURE DE TOMATES', '612409d09fa3d', 1.000, 10.00, 10.00);
INSERT INTO `temporal_compra` VALUES (37, 2, '000002', 'MATE DE POLIMERO SUBLIMINABLE', '61240c468ab5d', 1.000, 50.00, 50.00);
INSERT INTO `temporal_compra` VALUES (38, 3, '000003', 'PLATO BLANCO', '61240c468ab5d', 1.000, 150.00, 150.00);
INSERT INTO `temporal_compra` VALUES (48, 2, '000002', 'MATE DE POLIMERO SUBLIMINABLE', '612d8562c0fa7', 3.000, 50.00, 150.00);
INSERT INTO `temporal_compra` VALUES (49, 3, '000003', 'PLATO BLANCO', '612d8562c0fa7', 1.000, 150.00, 150.00);
INSERT INTO `temporal_compra` VALUES (50, 2, '000002', 'MATE DE POLIMERO SUBLIMINABLE', '612d863de6c4c', 1.000, 50.00, 50.00);
INSERT INTO `temporal_compra` VALUES (51, 3, '000003', 'PLATO BLANCO', '612d863de6c4c', 1.000, 150.00, 150.00);
INSERT INTO `temporal_compra` VALUES (54, 2, '000002', 'MATE DE POLIMERO SUBLIMINABLE', '612d8e102fd6c', 2.000, 50.00, 100.00);
INSERT INTO `temporal_compra` VALUES (55, 3, '000003', 'PLATO BLANCO', '612d8e102fd6c', 1.000, 150.00, 150.00);
INSERT INTO `temporal_compra` VALUES (56, 2, '000002', 'MATE DE POLIMERO SUBLIMINABLE', '612d8e2c6f916', 1.000, 50.00, 50.00);
INSERT INTO `temporal_compra` VALUES (57, 3, '000003', 'PLATO BLANCO', '612d8e2c6f916', 1.000, 150.00, 150.00);

-- ----------------------------
-- Table structure for unidades
-- ----------------------------
DROP TABLE IF EXISTS `unidades`;
CREATE TABLE `unidades`  (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `nombre_corto` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of unidades
-- ----------------------------
INSERT INTO `unidades` VALUES (3, 'Kilogramos', 'Kgrs', 1, '2021-08-16 21:15:38', '2021-08-16 19:15:38');
INSERT INTO `unidades` VALUES (5, 'Litro', 'Lt', 1, '2021-08-16 21:15:45', '2021-08-16 19:15:45');
INSERT INTO `unidades` VALUES (6, 'Unidad', 'Un', 1, '2021-07-25 21:11:19', '2021-07-25 18:09:44');
INSERT INTO `unidades` VALUES (7, 'Paquete', 'Paq', 1, '2021-07-24 18:03:00', '2021-07-24 18:03:00');
INSERT INTO `unidades` VALUES (8, 'Caja', 'Caj', 1, '2021-07-26 19:07:56', '2021-07-26 17:07:56');
INSERT INTO `unidades` VALUES (9, 'Sobre', 'Sb', 1, '2021-07-25 21:11:21', '2021-07-24 18:10:39');
INSERT INTO `unidades` VALUES (10, 'Toneladas ', 'Tn', 1, '2021-07-26 16:23:12', '2021-07-26 16:23:12');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `password` varchar(130) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `id_caja` int(8) NULL DEFAULT NULL,
  `id_rol` int(8) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `usuario`(`usuario`) USING BTREE,
  INDEX `fk_idcaja`(`id_caja`) USING BTREE,
  INDEX `fk_idrol`(`id_rol`) USING BTREE,
  CONSTRAINT `fk_idcaja` FOREIGN KEY (`id_caja`) REFERENCES `cajas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_idrol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'sixtored', 'Sixto Ramon E. Diaz', 'sixtod@gmail.com', '$2y$10$.TPt/KYj321AipCLbIvmPe86s4n3pjgHhIsERj9806XnK9MSGpvRW', 1, '2021-08-17 15:45:39', '2022-07-18 09:56:29', 2, 1);
INSERT INTO `usuarios` VALUES (2, 'sixtod', 'Sixto Diaz', 'sixtod@gmail.com', '$2y$10$jgMyT8PuG6nYiOfqvqT4EORYEv9CwkTBtMwT95OEwl7Q6KBEA5jPi', 1, '2021-08-17 20:29:29', '2022-07-18 11:55:20', 1, 2);

-- ----------------------------
-- Table structure for ventas
-- ----------------------------
DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folio` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `total` decimal(11, 2) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `id_cajero` int(11) NULL DEFAULT NULL,
  `id_cliente` int(11) NULL DEFAULT NULL,
  `id_caja` int(11) NULL DEFAULT NULL,
  `forma_pago` varchar(6) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ventas
-- ----------------------------
INSERT INTO `ventas` VALUES (3, '612d903270bda', 200.00, '2021-08-31 21:09:44', '2021-08-31 19:09:44', 1, 1, 2, '001', 0);
INSERT INTO `ventas` VALUES (4, '612e1218367b0', 210.00, '2021-08-31 06:27:39', '2021-08-31 06:27:39', 1, 1, 2, '001', 1);
INSERT INTO `ventas` VALUES (5, '612e12ea8e070', 200.00, '2021-08-31 06:31:06', '2021-08-31 06:31:06', 1, 1, 2, '001', 1);
INSERT INTO `ventas` VALUES (6, '612e1313e9102', 200.00, '2021-08-31 06:31:54', '2021-08-31 06:31:54', 1, 3, 2, '002', 1);
INSERT INTO `ventas` VALUES (7, '612e132d33d29', 210.00, '2021-08-31 06:44:42', '2021-08-31 06:44:42', 1, 1, 2, '001', 1);
INSERT INTO `ventas` VALUES (8, '612e4ab9d9426', 360.00, '2021-08-31 10:29:54', '2021-08-31 10:29:54', 1, 3, 2, '001', 1);
INSERT INTO `ventas` VALUES (9, '612e4b55c2afb', 150.00, '2021-08-31 10:34:27', '2021-08-31 10:34:27', 1, 1, 2, '001', 1);
INSERT INTO `ventas` VALUES (10, '612e4e834ecfc', 50.00, '2021-08-31 21:11:33', '2021-08-31 19:11:33', 1, 1, 2, '001', 0);
INSERT INTO `ventas` VALUES (11, '612eb1ead65b8', 160.00, '2021-08-31 21:12:22', '2021-08-31 19:12:22', 1, 3, 2, '001', 0);
INSERT INTO `ventas` VALUES (12, '612f998237e44', 200.00, '2021-09-01 10:17:35', '2021-09-01 10:17:35', 1, 1, 2, '001', 1);
INSERT INTO `ventas` VALUES (13, '11', 50.00, '2021-09-02 19:12:33', '2021-09-02 19:12:33', 1, 1, 2, '001', 1);
INSERT INTO `ventas` VALUES (14, '12', 160.00, '2021-09-02 19:12:57', '2021-09-02 19:12:57', 1, 1, 2, '001', 1);
INSERT INTO `ventas` VALUES (15, '13', 310.00, '2021-09-02 19:52:07', '2021-09-02 19:52:07', 1, 1, 2, '001', 1);
INSERT INTO `ventas` VALUES (16, '14', 160.00, '2021-09-06 15:40:54', '2021-09-06 15:40:54', 1, 1, 2, '001', 1);

-- ----------------------------
-- Table structure for ventas_detalle
-- ----------------------------
DROP TABLE IF EXISTS `ventas_detalle`;
CREATE TABLE `ventas_detalle`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ventas` int(11) NULL DEFAULT NULL,
  `id_producto` int(11) NULL DEFAULT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cantidad` decimal(9, 3) NULL DEFAULT NULL,
  `precio` decimal(11, 2) NULL DEFAULT NULL,
  `subtotal` decimal(11, 2) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ventas_detalle
-- ----------------------------
INSERT INTO `ventas_detalle` VALUES (3, 2, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, 50.00, '2021-08-31 21:00:11', '000002', 1);
INSERT INTO `ventas_detalle` VALUES (4, 3, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-08-31 15:45:10', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (5, 4, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-08-31 06:27:39', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (6, 4, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, 50.00, '2021-08-31 06:27:39', '000002', 1);
INSERT INTO `ventas_detalle` VALUES (7, 4, 5, '  PURE DE TOMATES', 1.000, 10.00, 10.00, '2021-08-31 06:27:39', '000006', 1);
INSERT INTO `ventas_detalle` VALUES (8, 5, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-08-31 06:31:06', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (9, 5, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, 50.00, '2021-08-31 06:31:06', '000002', 1);
INSERT INTO `ventas_detalle` VALUES (10, 6, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, 50.00, '2021-08-31 06:31:54', '000002', 1);
INSERT INTO `ventas_detalle` VALUES (11, 6, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-08-31 06:31:54', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (12, 7, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, 50.00, '2021-08-31 06:44:42', '000002', 1);
INSERT INTO `ventas_detalle` VALUES (13, 7, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-08-31 06:44:42', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (14, 7, 5, '  PURE DE TOMATES', 1.000, 10.00, 10.00, '2021-08-31 06:44:42', '000006', 1);
INSERT INTO `ventas_detalle` VALUES (15, 8, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, 50.00, '2021-08-31 10:29:54', '000002', 1);
INSERT INTO `ventas_detalle` VALUES (16, 8, 3, 'PLATO BLANCO', 2.000, 150.00, 300.00, '2021-08-31 10:29:54', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (17, 8, 5, '  PURE DE TOMATES', 1.000, 10.00, 10.00, '2021-08-31 10:29:54', '000006', 1);
INSERT INTO `ventas_detalle` VALUES (18, 9, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-08-31 10:34:27', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (19, 10, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, 50.00, '2021-08-31 21:11:33', '000002', 0);
INSERT INTO `ventas_detalle` VALUES (20, 11, 5, '  PURE DE TOMATES', 1.000, 10.00, 10.00, '2021-08-31 21:12:22', '000006', 0);
INSERT INTO `ventas_detalle` VALUES (21, 11, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-08-31 21:12:22', '000003', 0);
INSERT INTO `ventas_detalle` VALUES (22, 12, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, 50.00, '2021-09-01 10:17:35', '000002', 1);
INSERT INTO `ventas_detalle` VALUES (23, 12, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-09-01 10:17:35', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (24, 13, 2, 'MATE DE POLIMERO SUBLIMINABLE', 1.000, 50.00, 50.00, '2021-09-02 19:12:33', '000002', 1);
INSERT INTO `ventas_detalle` VALUES (25, 14, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-09-02 19:12:57', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (26, 14, 5, '  PURE DE TOMATES', 1.000, 10.00, 10.00, '2021-09-02 19:12:57', '000006', 1);
INSERT INTO `ventas_detalle` VALUES (27, 15, 3, 'PLATO BLANCO', 2.000, 150.00, 300.00, '2021-09-02 19:52:07', '000003', 1);
INSERT INTO `ventas_detalle` VALUES (28, 15, 5, '  PURE DE TOMATES', 1.000, 10.00, 10.00, '2021-09-02 19:52:07', '000006', 1);
INSERT INTO `ventas_detalle` VALUES (29, 16, 5, '  PURE DE TOMATES', 1.000, 10.00, 10.00, '2021-09-06 15:40:54', '000006', 1);
INSERT INTO `ventas_detalle` VALUES (30, 16, 3, 'PLATO BLANCO', 1.000, 150.00, 150.00, '2021-09-06 15:40:54', '000003', 1);

SET FOREIGN_KEY_CHECKS = 1;
