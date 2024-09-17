-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         8.0.39-0ubuntu0.22.04.1 - (Ubuntu)
-- SO del servidor:              Linux
-- HeidiSQL Versión:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sistema_de_ropa
CREATE DATABASE IF NOT EXISTS `sistema_de_ropa` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sistema_de_ropa`;

-- Volcando estructura para tabla sistema_de_ropa.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `id_categoria_padre` int NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aplica_peso` tinyint NOT NULL DEFAULT '0',
  `estado` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.categorias: ~16 rows (aproximadamente)
INSERT INTO `categorias` (`id_categoria`, `id_categoria_padre`, `nombre`, `aplica_peso`, `estado`) VALUES
	(1, 0, 'Pantalones', 0, 1),
	(2, 0, 'Blusas', 0, 1),
	(3, 0, 'Pands', 0, 1),
	(4, 0, 'Vestidos', 0, 1),
	(5, 0, 'Sudaderas', 0, 1),
	(6, 0, 'Boxers', 0, 1),
	(7, 0, 'Faldas', 0, 1),
	(8, 0, 'Playeras', 0, 1),
	(9, 0, 'Accesorios', 0, 1),
	(10, 1, 'Hombres', 0, 1),
	(11, 1, 'Mujeres', 0, 1),
	(12, 1, 'Niños', 0, 1),
	(13, 10, 'Mezcliya', 0, 1),
	(14, 10, 'Vestir', 0, 1),
	(15, 11, 'Vestir', 0, 1),
	(16, 11, 'mescliya', 0, 1);

-- Volcando estructura para tabla sistema_de_ropa.colores
CREATE TABLE IF NOT EXISTS `colores` (
  `id_color` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_color`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.colores: ~5 rows (aproximadamente)
INSERT INTO `colores` (`id_color`, `nombre`) VALUES
	(1, 'azul'),
	(2, 'negro'),
	(3, 'blanco'),
	(4, 'rosita'),
	(5, 'azul bajito');

-- Volcando estructura para tabla sistema_de_ropa.compras
CREATE TABLE IF NOT EXISTS `compras` (
  `id_compra` int NOT NULL AUTO_INCREMENT,
  `nro_ticket` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_usuario` int NOT NULL,
  `cant_productos` float NOT NULL,
  `total` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_compra`),
  KEY `FK_compras_usuarios` (`id_usuario`),
  CONSTRAINT `FK_compras_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.compras: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sistema_de_ropa.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id_configuracion` int NOT NULL AUTO_INCREMENT,
  `validar_stock` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_configuracion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.configuracion: ~0 rows (aproximadamente)
INSERT INTO `configuracion` (`id_configuracion`, `validar_stock`) VALUES
	(1, NULL);

-- Volcando estructura para tabla sistema_de_ropa.det_compras
CREATE TABLE IF NOT EXISTS `det_compras` (
  `id_det_compra` int NOT NULL AUTO_INCREMENT,
  `id_compra` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` float NOT NULL,
  `costo_unitario` float NOT NULL,
  `subtotal` float NOT NULL,
  PRIMARY KEY (`id_det_compra`),
  KEY `FK_det_compras_compras` (`id_compra`),
  KEY `FK_det_compras_productos` (`id_producto`),
  CONSTRAINT `FK_det_compras_compras` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`),
  CONSTRAINT `FK_det_compras_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.det_compras: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sistema_de_ropa.det_ventas
CREATE TABLE IF NOT EXISTS `det_ventas` (
  `id_det_venta` int NOT NULL AUTO_INCREMENT,
  `id_venta` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` float NOT NULL,
  `precio_unitario` float NOT NULL,
  `utilidad` float NOT NULL,
  `subtotal` float NOT NULL,
  PRIMARY KEY (`id_det_venta`),
  KEY `FK_det_ventas_ventas` (`id_venta`),
  KEY `FK_det_ventas_productos` (`id_producto`),
  CONSTRAINT `FK_det_ventas_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  CONSTRAINT `FK_det_ventas_ventas` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.det_ventas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sistema_de_ropa.imagenes
CREATE TABLE IF NOT EXISTS `imagenes` (
  `id_imagen` int NOT NULL AUTO_INCREMENT,
  `modulo` varchar(100) NOT NULL,
  `id_registro` int NOT NULL DEFAULT '0',
  `img` varchar(2000) NOT NULL,
  PRIMARY KEY (`id_imagen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.imagenes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sistema_de_ropa.inventario
CREATE TABLE IF NOT EXISTS `inventario` (
  `id_inventario` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  PRIMARY KEY (`id_inventario`),
  KEY `FK_inventario_productos` (`id_producto`),
  CONSTRAINT `FK_inventario_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.inventario: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sistema_de_ropa.marcas
CREATE TABLE IF NOT EXISTS `marcas` (
  `id_marca` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.marcas: ~4 rows (aproximadamente)
INSERT INTO `marcas` (`id_marca`, `nombre`) VALUES
	(1, 'jean'),
	(2, 'levis'),
	(3, 'tulum'),
	(4, 'hubis');

-- Volcando estructura para tabla sistema_de_ropa.modulos
CREATE TABLE IF NOT EXISTS `modulos` (
  `id_modulo` int NOT NULL AUTO_INCREMENT,
  `modulo` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `padre_id` int NOT NULL,
  `vista` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `icon_menu` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `orden` int NOT NULL,
  PRIMARY KEY (`id_modulo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla sistema_de_ropa.modulos: ~13 rows (aproximadamente)
INSERT INTO `modulos` (`id_modulo`, `modulo`, `padre_id`, `vista`, `icon_menu`, `orden`) VALUES
	(1, 'Usuarios', 0, '', 'fas fa-users', 0),
	(2, 'Usuarios', 1, 'usuarios.php', 'far fa-circle text-danger', 1),
	(3, 'Asignar modulos', 1, 'usuario_modulos.php', 'far fa-circle text-warning', 2),
	(4, 'Productos', 0, '', 'fas fa-cart-plus', 0),
	(5, 'Categorias', 4, 'categorias.php', 'far fa-circle text-info', 3),
	(6, 'Configuracion', 0, '', 'fas fa-cogs', 0),
	(7, 'Unidad de medida', 6, 'unidades_medida.php', 'far fa-circle text-danger', 1),
	(8, 'Tallas', 6, 'tallas.php', 'far fa-circle text-warning', 2),
	(9, 'Marcas', 6, 'marcas.php', 'far fa-circle text-info', 3),
	(10, 'Colores', 6, 'colores.php', 'far fa-circle text-warning', 4),
	(17, 'Configuracion general', 6, 'configuracion.php', 'far fa-circle text-danger', 5),
	(18, 'Productos', 4, 'productos.php', 'far fa-circle text-danger', 1);

-- Volcando estructura para tabla sistema_de_ropa.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `id_categoria` int DEFAULT NULL,
  `id_udm` int DEFAULT NULL,
  `id_udm_compra` int DEFAULT NULL,
  `id_talla` int DEFAULT NULL,
  `id_color` int DEFAULT NULL,
  `id_marca` int DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `costo` float DEFAULT NULL,
  `utilidad` float DEFAULT NULL,
  `stock` float DEFAULT NULL,
  `min_stock` float DEFAULT NULL,
  `codigo_barras` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `img_principal` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `qr_base64` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id_producto`) USING BTREE,
  KEY `FK_productos_categorias` (`id_categoria`),
  KEY `FK_productos_unidades_medida` (`id_udm`),
  KEY `FK_productos_unidades_medida_2` (`id_udm_compra`),
  KEY `FK_productos_tallas` (`id_talla`),
  KEY `FK_productos_colores` (`id_color`),
  KEY `FK_productos_marcas` (`id_marca`),
  CONSTRAINT `FK_productos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  CONSTRAINT `FK_productos_colores` FOREIGN KEY (`id_color`) REFERENCES `colores` (`id_color`),
  CONSTRAINT `FK_productos_marcas` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`),
  CONSTRAINT `FK_productos_tallas` FOREIGN KEY (`id_talla`) REFERENCES `tallas` (`id_talla`),
  CONSTRAINT `FK_productos_unidades_medida` FOREIGN KEY (`id_udm`) REFERENCES `unidades_medida` (`id_unidad_medida`),
  CONSTRAINT `FK_productos_unidades_medida_2` FOREIGN KEY (`id_udm_compra`) REFERENCES `unidades_medida` (`id_unidad_medida`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.productos: ~1 rows (aproximadamente)
INSERT INTO `productos` (`id_producto`, `nombre`, `id_categoria`, `id_udm`, `id_udm_compra`, `id_talla`, `id_color`, `id_marca`, `precio`, `costo`, `utilidad`, `stock`, `min_stock`, `codigo_barras`, `img_principal`, `qr_base64`) VALUES
	(44, 'Pantalones de vestir de hombre', 9, 12, 12, 1, 1, 4, 50.5, 0, 0, 1, 0, '', '', NULL);

-- Volcando estructura para tabla sistema_de_ropa.tallas
CREATE TABLE IF NOT EXISTS `tallas` (
  `id_talla` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_talla`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.tallas: ~5 rows (aproximadamente)
INSERT INTO `tallas` (`id_talla`, `nombre`) VALUES
	(1, '28'),
	(2, '30'),
	(3, '32'),
	(4, 'chica'),
	(5, 'mediana');

-- Volcando estructura para tabla sistema_de_ropa.unidades_medida
CREATE TABLE IF NOT EXISTS `unidades_medida` (
  `id_unidad_medida` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_udm_referencia` int NOT NULL,
  `ratio` tinyint NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_unidad_medida`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.unidades_medida: ~2 rows (aproximadamente)
INSERT INTO `unidades_medida` (`id_unidad_medida`, `nombre`, `id_udm_referencia`, `ratio`, `estado`) VALUES
	(1, 'Unidades', 0, 1, 1),
	(12, 'Docenas', 1, 12, 1);

-- Volcando estructura para tabla sistema_de_ropa.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contrasena` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_modulo_inicio` int DEFAULT NULL,
  `estado` tinyint DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `FK_usuarios_modulos` (`id_modulo_inicio`),
  CONSTRAINT `FK_usuarios_modulos` FOREIGN KEY (`id_modulo_inicio`) REFERENCES `modulos` (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.usuarios: ~2 rows (aproximadamente)
INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `usuario`, `contrasena`, `id_modulo_inicio`, `estado`) VALUES
	(1, 'Jose Luis', 'Vences', 'jose', 'jose', 18, 1),
	(2, 'Rita', 'Vences', 'rita', 'rita', NULL, 1);

-- Volcando estructura para tabla sistema_de_ropa.usuario_modulos
CREATE TABLE IF NOT EXISTS `usuario_modulos` (
  `id_usuario_modulo` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_modulo` int NOT NULL,
  `estado` tinyint NOT NULL,
  PRIMARY KEY (`id_usuario_modulo`) USING BTREE,
  KEY `FK_usuario_modulos_usuarios` (`id_usuario`),
  KEY `FK_usuario_modulos_modulos` (`id_modulo`),
  CONSTRAINT `FK_usuario_modulos_modulos` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`),
  CONSTRAINT `FK_usuario_modulos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=871 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla sistema_de_ropa.usuario_modulos: ~12 rows (aproximadamente)
INSERT INTO `usuario_modulos` (`id_usuario_modulo`, `id_usuario`, `id_modulo`, `estado`) VALUES
	(505, 1, 3, 1),
	(816, 1, 1, 1),
	(861, 1, 4, 1),
	(862, 1, 6, 1),
	(863, 1, 2, 1),
	(864, 1, 7, 1),
	(865, 1, 18, 1),
	(866, 1, 8, 1),
	(867, 1, 5, 1),
	(868, 1, 9, 1),
	(869, 1, 10, 1),
	(870, 1, 17, 1);

-- Volcando estructura para tabla sistema_de_ropa.ventas
CREATE TABLE IF NOT EXISTS `ventas` (
  `id_venta` int NOT NULL AUTO_INCREMENT,
  `nro_ticket` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_usuario` int NOT NULL,
  `cant_productos` float NOT NULL,
  `total` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_venta`) USING BTREE,
  KEY `FK_ventas_usuarios` (`id_usuario`),
  CONSTRAINT `FK_ventas_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistema_de_ropa.ventas: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
