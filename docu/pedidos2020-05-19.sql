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
INSERT INTO `administrador` VALUES (1,'Salazar Walter','3453234',1),(2,'Santiago del VAlle','381343234',2);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
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
  PRIMARY KEY (`id`),
  KEY `fk_cliente_usuario1_idx` (`usuario_id`),
  KEY `fk_cliente_localidad1_idx` (`localidad_id`),
  CONSTRAINT `fk_cliente_localidad1` FOREIGN KEY (`localidad_id`) REFERENCES `localidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localidad`
--

DROP TABLE IF EXISTS `localidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `localidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc` varchar(60) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `provincia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_localidad_provincia1_idx` (`provincia_id`),
  CONSTRAINT `fk_localidad_provincia1` FOREIGN KEY (`provincia_id`) REFERENCES `provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localidad`
--

LOCK TABLES `localidad` WRITE;
/*!40000 ALTER TABLE `localidad` DISABLE KEYS */;
INSERT INTO `localidad` VALUES (1,'Tafi Viejo','S',1),(2,'Banda Del rio Sali','S',1),(3,'Lules','S',1),(4,'Famailla','S',1),(5,'Monteros','S',1),(6,'Bella Vista','S',1),(7,'Yerba Buena','S',1),(8,'San Salvador','S',4),(9,'Resistencia','S',5),(10,'San Miguel','S',1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `negocio`
--

DROP TABLE IF EXISTS `negocio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `negocio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `neg_nom` varchar(45) DEFAULT NULL,
  `neg_dom` varchar(45) DEFAULT NULL,
  `neg_tel` varchar(30) DEFAULT NULL,
  `neg_mail` varchar(30) DEFAULT NULL,
  `localidad_id` int(11) NOT NULL,
  `rubro_id` int(11) NOT NULL,
  `neg_cuit` varchar(15) DEFAULT NULL,
  `tags` varchar(200) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  PRIMARY KEY (`id`),
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
INSERT INTO `negocio` VALUES (1,'HM&Soft','San Martio 575','3813584546','salazarwalter@gmail.com',10,1,'20213356772','Gestion','S'),(2,'Bagon','Las Heras 3456','3814 644546','begoncompadre@gmail.com',10,3,'34234232435','Snack Mascotas','S');
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
  PRIMARY KEY (`id`),
  KEY `fk_pedido_cliente1_idx` (`cliente_id`),
  CONSTRAINT `fk_pedido_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
  `producto_id` int(11) NOT NULL,
  `cant` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidolinea_pedido1_idx` (`pedido_id`),
  KEY `fk_pedidolinea_producto1_idx` (`producto_id`),
  CONSTRAINT `fk_pedidolinea_pedido1` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidolinea_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_nom` varchar(60) DEFAULT NULL,
  `pro_pre` double(12,2) DEFAULT NULL,
  `marca_id` int(11) NOT NULL,
  `unidad_id` int(11) NOT NULL,
  `publicado` varchar(1) DEFAULT 'N',
  `pro_foto` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto_marca1_idx` (`marca_id`),
  KEY `fk_producto_unidad1_idx` (`unidad_id`),
  CONSTRAINT `fk_producto_marca1` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_unidad1` FOREIGN KEY (`unidad_id`) REFERENCES `unidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promosion`
--

DROP TABLE IF EXISTS `promosion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promosion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_cant` int(11) DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  `compuesto_por_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_promosion_producto1_idx` (`producto_id`),
  KEY `fk_promosion_producto2_idx` (`compuesto_por_id`),
  CONSTRAINT `fk_promosion_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_promosion_producto2` FOREIGN KEY (`compuesto_por_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promosion`
--

LOCK TABLES `promosion` WRITE;
/*!40000 ALTER TABLE `promosion` DISABLE KEYS */;
/*!40000 ALTER TABLE `promosion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincia`
--

DROP TABLE IF EXISTS `provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prov` varchar(30) DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincia`
--

LOCK TABLES `provincia` WRITE;
/*!40000 ALTER TABLE `provincia` DISABLE KEYS */;
INSERT INTO `provincia` VALUES (1,'Tucuman','S'),(2,'Santiago del Estero','S'),(3,'Salta','S'),(4,'Jujuy','S'),(5,'Chaco','S'),(6,'Formosa','S');
/*!40000 ALTER TABLE `provincia` ENABLE KEYS */;
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
INSERT INTO `rubro` VALUES (1,'Software','S',NULL),(2,'Mecanica','S',NULL),(3,'Gastromia','S',NULL),(4,'Salud','S',NULL),(5,'Mecanica','S',NULL);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad`
--

LOCK TABLES `unidad` WRITE;
/*!40000 ALTER TABLE `unidad` DISABLE KEYS */;
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
  `usu` varchar(60) DEFAULT NULL,
  `cla` varchar(90) DEFAULT NULL,
  `foto` varchar(60) DEFAULT NULL,
  `confirmado` varchar(1) DEFAULT 'N',
  `usuario_at` datetime DEFAULT NULL,
  `activo` varchar(1) DEFAULT 'S',
  `negocio_id` int(11) NOT NULL,
  `rol` varchar(45) DEFAULT 'L' COMMENT 'S=Super Sayayin\nL=Local\nE=Entrega\nR=Repartidor',
  PRIMARY KEY (`id`),
  KEY `fk_usuario_negocio1_idx` (`negocio_id`),
  CONSTRAINT `fk_usuario_negocio1` FOREIGN KEY (`negocio_id`) REFERENCES `negocio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'YWRtaW4yMDIw','MjAyMGFkbWlu',NULL,'S','2020-05-19 12:34:38','S',1,'S'),(2,'c2FudGlhZ28=','c2FudGlhZ28=',NULL,'S','2020-05-19 12:34:38','S',2,'L');
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

-- Dump completed on 2020-05-19 16:49:32
