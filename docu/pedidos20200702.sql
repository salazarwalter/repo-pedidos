-- MySQL dump 10.17  Distrib 10.3.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: pedidos
-- ------------------------------------------------------
-- Server version	10.3.22-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accion`
--

DROP TABLE IF EXISTS `accion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accion` varchar(30) NOT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `ajax` varchar(1) DEFAULT 'N',
  `controlador_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_accion_controlador` (`accion`,`controlador_id`),
  KEY `fk_accion_controlador1_idx` (`controlador_id`),
  CONSTRAINT `fk_accion_controlador1` FOREIGN KEY (`controlador_id`) REFERENCES `controlador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accion`
--

LOCK TABLES `accion` WRITE;
/*!40000 ALTER TABLE `accion` DISABLE KEYS */;
INSERT INTO `accion` VALUES (1,'index','S','N',1),(2,'index','S','N',2),(3,'index','S','N',3),(4,'index','S','N',4),(5,'index','S','N',5),(6,'add','S','N',4),(7,'edit','S','N',4),(8,'del','S','N',4),(9,'act','S','N',4),(10,'add','S','N',5),(11,'edit','S','N',5),(12,'del','S','N',5),(13,'act','S','N',5),(14,'add','S','N',6),(15,'edit','S','N',6),(16,'del','S','N',6),(17,'act','S','N',6),(18,'index','S','N',6),(19,'get_por_rol_id','S','S',4),(20,'index','S','N',7),(21,'add','S','N',7),(22,'edit','S','N',7),(23,'del','S','N',7),(24,'act','S','N',7),(25,'index','S','N',8),(26,'edit','S','N',8),(27,'del','S','N',8),(28,'act','S','N',8),(29,'add','S','N',8),(30,'clave','S','N',9),(31,'foto','S','N',9),(32,'salir','S','N',9),(33,'index','S','N',10),(34,'add','S','N',10),(35,'edit','S','N',10),(36,'del','S','N',10),(37,'act','S','N',10),(38,'icono','S','N',10),(39,'add','S','N',2),(40,'edit','S','N',2),(41,'del','S','N',2),(42,'act','S','N',2),(43,'lista_por_provincia','S','N',8),(44,'index','S','N',11),(45,'add','S','N',11),(46,'panel','S','N',12),(47,'edit','S','N',11),(48,'salir','S','N',13),(49,'foto','S','N',13),(50,'clave','S','N',13),(51,'general','S','N',14),(52,'domicilio','S','N',14),(53,'lista_por_provincia','S','S',15),(54,'busqueda','S','N',14),(55,'perfil','S','N',12),(56,'index','S','N',16),(57,'edit','S','N',16),(58,'del','S','N',16),(59,'act','S','N',16),(60,'add','S','N',16),(61,'index','S','N',17),(62,'add','S','N',17),(63,'edit','S','N',17),(64,'del','S','N',17),(65,'act','S','N',17),(66,'index','S','N',18),(67,'add','S','N',18),(68,'edit','S','N',18),(69,'del','S','N',18),(70,'act','S','N',18),(71,'add','S','N',19),(72,'index','S','N',19),(73,'edit','S','N',19),(74,'del','S','N',19),(75,'act','S','N',19),(76,'index','S','N',20),(77,'add','S','N',20),(78,'filtrado','S','N',19),(79,'edit','S','N',20),(80,'del','S','N',20),(81,'act','S','N',20),(82,'componentes','S','N',20),(83,'agregarcompo','S','N',20),(84,'quitar','S','N',20),(85,'index','S','N',21),(86,'add','S','N',21),(87,'edit','S','N',21),(88,'del','S','N',21),(89,'act','S','N',21),(90,'salir','S','N',22),(91,'panel','S','N',23),(92,'empresas','S','N',23);
/*!40000 ALTER TABLE `accion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adm_nom` varchar(45) DEFAULT NULL,
  `adm_cel` varchar(15) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `adm_mail` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_usuario_idx` (`usuario_id`),
  CONSTRAINT `fk_admin_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES (1,'Salazar Walter','3813584546',1,NULL),(2,'Stolbizer Margarita','3814 234345',2,NULL);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulo`
--

DROP TABLE IF EXISTS `articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `art_nom` varchar(60) DEFAULT NULL,
  `art_pre` double(12,2) DEFAULT NULL,
  `promosion` varchar(1) DEFAULT 'N',
  `publicado` varchar(1) DEFAULT 'N',
  `negocio_id` int(11) NOT NULL,
  `art_cod` int(11) DEFAULT NULL,
  `barra` varchar(25) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  PRIMARY KEY (`id`),
  KEY `fk_articulo_negocio1_idx` (`negocio_id`),
  CONSTRAINT `fk_articulo_negocio1` FOREIGN KEY (`negocio_id`) REFERENCES `negocio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo`
--

LOCK TABLES `articulo` WRITE;
/*!40000 ALTER TABLE `articulo` DISABLE KEYS */;
INSERT INTO `articulo` VALUES (2,'Café x 500gr',347.24,'N','N',2,NULL,NULL,'S'),(3,'Yerba Mate x Kg',450.00,'N','N',2,NULL,NULL,'S'),(4,'Yerba Mate x 500Gr',355.00,'N','N',2,NULL,NULL,'S'),(5,'Té caja 25 Saquitos',137.00,'N','N',2,NULL,NULL,'S'),(6,'Azucar',37.75,'N','N',2,NULL,NULL,'S'),(7,'Azucar Fardo 10Kg',780.24,'N','N',2,NULL,NULL,'S'),(8,'Fideos x 500gr',57.90,'N','N',2,NULL,NULL,'S'),(9,'Promosion la primera 5x4',1568.50,'S','S',2,NULL,NULL,'S'),(13,'Lleve 3 pague 2',789.50,'S','N',2,NULL,NULL,'S'),(14,'xxxxxxxxxxxx',970.00,'S','S',2,NULL,NULL,'N');
/*!40000 ALTER TABLE `articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulolinea`
--

DROP TABLE IF EXISTS `articulolinea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulolinea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cant` int(11) DEFAULT NULL,
  `articulo_id` int(11) NOT NULL,
  `descripcion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_articulolinea_articulo1_idx` (`articulo_id`),
  KEY `fk_articulolinea_articulodescripcion1_idx` (`descripcion_id`),
  CONSTRAINT `fk_articulolinea_articulo1` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_articulolinea_articulodescripcion1` FOREIGN KEY (`descripcion_id`) REFERENCES `descripcion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulolinea`
--

LOCK TABLES `articulolinea` WRITE;
/*!40000 ALTER TABLE `articulolinea` DISABLE KEYS */;
INSERT INTO `articulolinea` VALUES (1,1,2,3),(2,1,3,4),(3,1,4,5),(4,1,5,6),(5,1,6,7),(6,1,7,8),(7,1,8,9),(11,4,14,8),(20,5,14,5),(27,6,14,9),(32,3,13,3);
/*!40000 ALTER TABLE `articulolinea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(45) DEFAULT NULL,
  `icono` varchar(60) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `negocio_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria_negocio1_idx` (`negocio_id`),
  CONSTRAINT `fk_categoria_negocio1` FOREIGN KEY (`negocio_id`) REFERENCES `negocio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'No definida',NULL,'S',2),(2,'Comida para Mascotas',NULL,'S',2),(3,'Alimento p/Pájaros',NULL,'S',2),(4,'Desayuno',NULL,'S',2),(5,'Accesorios Mascota',NULL,'S',2);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cli_nom` varchar(45) DEFAULT NULL,
  `cli_cel` varchar(15) DEFAULT NULL,
  `cli_dom` varchar(40) DEFAULT NULL,
  `cli_mail` varchar(30) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `localidad_id` int(11) NOT NULL,
  `negocio` varchar(1) DEFAULT 'S',
  `cli_dni` int(11) DEFAULT NULL,
  `cli_neg` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_usuario1_idx` (`usuario_id`),
  KEY `fk_cliente_localidad1_idx` (`localidad_id`),
  CONSTRAINT `fk_cliente_localidad1` FOREIGN KEY (`localidad_id`) REFERENCES `localidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Arias Pedro Jose','3184123123','Las Heras 346',NULL,3,4,'S',8088691,'Peluqueria el Limpito'),(2,'Yabran Jorge','3813432432','Ruta 38 Km 456',NULL,4,3,'S',21335432,'Pañalera del Norte');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrata`
--

DROP TABLE IF EXISTS `contrata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desde` datetime DEFAULT NULL,
  `hasta` datetime DEFAULT NULL,
  `precio` double(16,2) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `modulo_id` int(11) NOT NULL,
  `negocio_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_negocio_modulo` (`modulo_id`,`negocio_id`),
  KEY `fk_contrata_modulo1_idx` (`modulo_id`),
  KEY `fk_contrata_negocio1_idx` (`negocio_id`),
  CONSTRAINT `fk_contrata_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrata_negocio1` FOREIGN KEY (`negocio_id`) REFERENCES `negocio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrata`
--

LOCK TABLES `contrata` WRITE;
/*!40000 ALTER TABLE `contrata` DISABLE KEYS */;
INSERT INTO `contrata` VALUES (1,'2020-06-25 04:00:04',NULL,0.00,'S',1,1),(2,'2020-06-25 06:52:59',NULL,2000.00,'S',2,2);
/*!40000 ALTER TABLE `contrata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controlador`
--

DROP TABLE IF EXISTS `controlador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `controlador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controlador` varchar(30) NOT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `rol_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_control_modulo_rol` (`modulo_id`,`rol_id`,`controlador`),
  KEY `fk_controlador_rol1_idx` (`rol_id`),
  KEY `fk_controlador_modulo1_idx` (`modulo_id`),
  CONSTRAINT `fk_controlador_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_controlador_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controlador`
--

LOCK TABLES `controlador` WRITE;
/*!40000 ALTER TABLE `controlador` DISABLE KEYS */;
INSERT INTO `controlador` VALUES (1,'ingreso','S',1,1),(2,'negocio','S',1,1),(3,'rol','S',1,1),(4,'controlador','S',1,1),(5,'accion','S',1,1),(6,'modulo','S',1,1),(7,'provincia','S',1,1),(8,'localidad','S',1,1),(9,'usuario','S',1,1),(10,'rubro','S',1,1),(11,'contrata','S',1,1),(12,'localadmin','S',2,2),(13,'usuario','S',2,2),(14,'negocio','S',2,2),(15,'localidad','S',2,2),(16,'unidad','S',2,2),(17,'marca','S',2,2),(18,'categoria','S',2,2),(19,'articulo','S',2,2),(20,'promosion','S',2,2),(21,'clientesneg','S',2,2),(22,'usuario','S',3,2),(23,'clientesneg','S',3,2);
/*!40000 ALTER TABLE `controlador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `descripcion`
--

DROP TABLE IF EXISTS `descripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `descripcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_pre` double(12,2) DEFAULT NULL,
  `marca_id` int(11) NOT NULL,
  `unidad_id` int(11) NOT NULL,
  `pro_foto` varchar(60) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto_marca1_idx` (`marca_id`),
  KEY `fk_producto_unidad1_idx` (`unidad_id`),
  KEY `fk_producto_categoria1_idx` (`categoria_id`),
  CONSTRAINT `fk_producto_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_marca1` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_unidad1` FOREIGN KEY (`unidad_id`) REFERENCES `unidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `descripcion`
--

LOCK TABLES `descripcion` WRITE;
/*!40000 ALTER TABLE `descripcion` DISABLE KEYS */;
INSERT INTO `descripcion` VALUES (3,347.24,4,1,NULL,4,'Café x 500gr'),(4,450.00,5,1,NULL,4,'Yerba Mate x Kg'),(5,355.00,5,1,NULL,4,'Yerba Mate x 500Gr'),(6,137.00,4,1,NULL,4,'Té caja 25 Saquitos'),(7,37.75,6,2,NULL,4,'Azucar'),(8,780.24,6,1,NULL,4,'Azucar Fardo 10Kg'),(9,57.90,7,1,NULL,3,'Fideos x 500gr');
/*!40000 ALTER TABLE `descripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localidad`
--

DROP TABLE IF EXISTS `localidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `localidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc` varchar(60) NOT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `provincia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_localidad_provincia` (`loc`,`provincia_id`),
  KEY `fk_localidad_provincia1_idx` (`provincia_id`),
  CONSTRAINT `fk_localidad_provincia1` FOREIGN KEY (`provincia_id`) REFERENCES `provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localidad`
--

LOCK TABLES `localidad` WRITE;
/*!40000 ALTER TABLE `localidad` DISABLE KEYS */;
INSERT INTO `localidad` VALUES (1,'No definida','S',1),(2,'San Miguel','S',2),(3,'Lules','S',2),(4,'Monteros','S',2),(5,'Tafi Viejo','S',2),(6,'La Banda','S',3),(7,'Metán','S',4);
/*!40000 ALTER TABLE `localidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(30) DEFAULT NULL,
  `negocio_id` int(11) NOT NULL,
  `activo` varchar(1) DEFAULT 'S',
  PRIMARY KEY (`id`),
  KEY `fk_marca_negocio1_idx` (`negocio_id`),
  CONSTRAINT `fk_marca_negocio1` FOREIGN KEY (`negocio_id`) REFERENCES `negocio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` VALUES (1,'No Definida',2,'S'),(2,'Tucson Kye',2,'S'),(3,'Piloto',2,'S'),(4,'La Virgina',2,'S'),(5,'La Hoja',2,'S'),(6,'Ledesma',2,'S'),(7,'Molinos SA',2,'S');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulo`
--

DROP TABLE IF EXISTS `modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo` varchar(30) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulo`
--

LOCK TABLES `modulo` WRITE;
/*!40000 ALTER TABLE `modulo` DISABLE KEYS */;
INSERT INTO `modulo` VALUES (1,'Módulo Base SayaYin','S'),(2,'Gestion Pedidos','S'),(3,'Turnos. Atencion','S');
/*!40000 ALTER TABLE `modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `negocio`
--

DROP TABLE IF EXISTS `negocio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `negocio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `neg_nom` varchar(45) NOT NULL,
  `neg_dom` varchar(45) DEFAULT NULL,
  `neg_tel` varchar(30) DEFAULT NULL,
  `neg_mail` varchar(30) DEFAULT NULL,
  `localidad_id` int(11) NOT NULL,
  `rubro_id` int(11) NOT NULL,
  `neg_cuit` varchar(15) DEFAULT NULL,
  `tags` varchar(200) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `horario` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `neg_nom_UNIQUE` (`neg_nom`),
  KEY `fk_negocio_localidad1_idx` (`localidad_id`),
  KEY `fk_negocio_rubro1_idx` (`rubro_id`),
  CONSTRAINT `fk_negocio_localidad1` FOREIGN KEY (`localidad_id`) REFERENCES `localidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_negocio_rubro1` FOREIGN KEY (`rubro_id`) REFERENCES `rubro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `negocio`
--

LOCK TABLES `negocio` WRITE;
/*!40000 ALTER TABLE `negocio` DISABLE KEYS */;
INSERT INTO `negocio` VALUES (1,'HM&Soft','','381358454','@gmail',2,1,'','','S',NULL),(2,'Taller del Sol','Chacabuco 1930','3856 213543','tallerdelsol@gmail.com',5,4,NULL,'frenos, electricidad del automotor','S','Lun Vier 9-13 y 16-22 sab 11-22hs');
/*!40000 ALTER TABLE `negocio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_at` datetime DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `estado` varchar(1) DEFAULT 'P' COMMENT 'P=Pedido\nL=Preparado\nC=Cargado\nE=Entregado\nX=Cancelado\n',
  `fecha_in` datetime DEFAULT NULL,
  `total` double(12,2) DEFAULT 0.00,
  `negocio_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_cliente1_idx` (`cliente_id`),
  KEY `fk_pedido_negocio1_idx` (`negocio_id`),
  CONSTRAINT `fk_pedido_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_negocio1` FOREIGN KEY (`negocio_id`) REFERENCES `negocio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidolinea`
--

DROP TABLE IF EXISTS `pedidolinea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidolinea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `cant` int(11) DEFAULT NULL,
  `articulo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidolinea_pedido1_idx` (`pedido_id`),
  KEY `fk_pedidolinea_articulo1_idx` (`articulo_id`),
  CONSTRAINT `fk_pedidolinea_articulo1` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidolinea_pedido1` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidolinea`
--

LOCK TABLES `pedidolinea` WRITE;
/*!40000 ALTER TABLE `pedidolinea` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidolinea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincia`
--

DROP TABLE IF EXISTS `provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prov` varchar(30) NOT NULL,
  `activo` varchar(1) DEFAULT 'S',
  PRIMARY KEY (`id`),
  UNIQUE KEY `prov_UNIQUE` (`prov`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincia`
--

LOCK TABLES `provincia` WRITE;
/*!40000 ALTER TABLE `provincia` DISABLE KEYS */;
INSERT INTO `provincia` VALUES (1,'No Definida','S'),(2,'Tucumán','S'),(3,'Santiago del Estero','S'),(4,'Salta','S');
/*!40000 ALTER TABLE `provincia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rol_UNIQUE` (`rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Super Saya Yin','S'),(2,'Administrador Local','S'),(3,'Rol Negocio Cliente','S'),(4,'Rol Entrega','S');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubro`
--

DROP TABLE IF EXISTS `rubro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rubro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rubro` varchar(30) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `icono` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubro`
--

LOCK TABLES `rubro` WRITE;
/*!40000 ALTER TABLE `rubro` DISABLE KEYS */;
INSERT INTO `rubro` VALUES (1,'Software Factory','S',NULL),(2,'Papas Fritas','S','028ffd793e2cc45e9e1758f9d7e89a71.svg'),(3,'Pañalera','S','156ec39da3725cbd59a80f95b3820bd2.svg'),(4,'Mecánica','S','65139f4a5dd77af685b35c7e5b6912a0.svg'),(5,'Veterinaria','S','2d102a1fcf434bb87fa2d5c47289674d.svg');
/*!40000 ALTER TABLE `rubro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidad`
--

DROP TABLE IF EXISTS `unidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unidad` varchar(25) DEFAULT NULL,
  `abreviatura` varchar(6) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `negocio_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_unidad_negocio1_idx` (`negocio_id`),
  CONSTRAINT `fk_unidad_negocio1` FOREIGN KEY (`negocio_id`) REFERENCES `negocio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad`
--

LOCK TABLES `unidad` WRITE;
/*!40000 ALTER TABLE `unidad` DISABLE KEYS */;
INSERT INTO `unidad` VALUES (1,'Unidad','un','S',2),(2,'Kilogramo','Kg','S',2),(3,'No definido','nd','S',2),(4,'Gramo','Gr','S',2),(5,'500 Gramos','500Gr','S',2),(6,'250Gr','250gr','S',2),(7,'25 Unidades','25u','S',2);
/*!40000 ALTER TABLE `unidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usu` varchar(60) NOT NULL,
  `cla` varchar(90) NOT NULL,
  `foto` varchar(60) DEFAULT NULL,
  `confirmado` varchar(1) DEFAULT 'N',
  `usuario_at` datetime DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `negocio_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usu_UNIQUE` (`usu`),
  KEY `fk_usuario_negocio1_idx` (`negocio_id`),
  KEY `fk_usuario_rol1_idx` (`rol_id`),
  CONSTRAINT `fk_usuario_negocio1` FOREIGN KEY (`negocio_id`) REFERENCES `negocio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'YWRtaW4yMDIw','MjAyMGFkbWlu',NULL,'N',NULL,'S',1,1),(2,'anVhbjIwMjA=','MjAyMGp1YW4=',NULL,'S','2020-06-25 05:38:39','S',2,2),(3,'cGVkcm8yMDIw','MjAyMHBlZHJv',NULL,'S','2020-06-28 17:58:35','S',2,3),(4,'am9yZ2UyMDIw','MjAyMGpvcmdl',NULL,'S','2020-06-28 19:16:35','S',2,3);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendedor`
--

DROP TABLE IF EXISTS `vendedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ven_nom` varchar(45) DEFAULT NULL,
  `ven_cel` varchar(30) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `ven_mail` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vendedor_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_vendedor_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendedor`
--

LOCK TABLES `vendedor` WRITE;
/*!40000 ALTER TABLE `vendedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendedor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-02 10:26:44
