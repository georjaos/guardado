-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2018 a las 20:16:27
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rnf`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristica`
--

CREATE TABLE `caracteristica` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `caracteristica`
--

INSERT INTO `caracteristica` (`id`, `nombre`, `descripcion`) VALUES
(12, 'Eficiencia de desempeño', 'Esta característica representa el desempeño relativo a la cantidad de recursos utilizados bajo determinadas condiciones'),
(13, 'Compatibilidad', 'Capacidad de dos o más sistemas o componentes para intercambiar información y/o llevar a cabo sus funciones requeridas cuando comparten el mismo entorno hardware o software'),
(14, 'Usabilidad', 'Capacidad del producto software para ser entendido, aprendido, usado y resultar atractivo para el usuario, cuando se usa bajo determinadas condiciones'),
(16, 'Fiabilidad', 'Capacidad de un sistema'),
(17, 'Seguridad', 'Capacidad de protección de la información y los datos de manera que personas o sistemas no autorizados no puedan leerlos o modificarlos'),
(18, 'Mantenibilidad', 'Esta característica representa la capacidad del producto software para ser modificado efectiva y eficientemente, debido a necesidades evolutivas, correctivas o perfectivas'),
(19, 'Portabilidad', 'Capacidad del producto o componente de ser transferido de forma efectiva y eficiente de un entorno hardware, software, operacional o de utilización a otro\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interfaz`
--

CREATE TABLE `interfaz` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` int(11) NOT NULL,
  `detalle_tipo` text NOT NULL,
  `proceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `interfaz`
--

INSERT INTO `interfaz` (`id`, `nombre`, `descripcion`, `tipo`, `detalle_tipo`, `proceso`) VALUES
(2, 'compras', 'se comunica con el proceso de compras', 1, 'automaticament e realiza su comunicacion ', 2),
(11, 'iiiiiii', 'ppppp', 2, 'hiiiihihhhh', 5),
(12, 'hhhhhhh', 'jjjjjjjjjjjjjjjjjjjjjj', 1, 'zzzzzzzzzzzzzzzzzzzzzzzzzz', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `normativa`
--

CREATE TABLE `normativa` (
  `idnormativa` int(11) NOT NULL,
  `idproceso` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `normativa`
--

INSERT INTO `normativa` (`idnormativa`, `idproceso`, `nombre`, `descripcion`) VALUES
(1, 5, 'dssdfsdf', 'dsdfsdsaaaaaaaaaaaaaaaaaaaaxzfgfgg'),
(2, 7, 'sdsds', 'ojojihihihihihoooooooooooooooooooooojojojojohhhhhhhhhhhhyyyyyyyyyyyyyyyyyyyyyyy'),
(3, 2, 'cccccc', 'ccccczzzzzzzzzzzzakojaodqijjdjpojdoqdqdqjpodqjpdqjdqpjdqñodjdñajadñda'),
(4, 3, 'norma', 'sasasaa'),
(5, 5, 'aaaaa', 'aaaaaaaaaaaaa'),
(6, 5, 'qqqqqqqqqqqqqqqqqqq', 'aaaazzzzzzzzzzzzz'),
(7, 5, 'jojoojo', 'yiyiiyiyiyiyiyqtqe'),
(8, 5, 'bbbbb', 'bbbb'),
(9, 5, 'bbbb', 'agagag'),
(10, 10, 'cccc', 'xxxx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paralelos`
--

CREATE TABLE `paralelos` (
  `proceso` int(11) NOT NULL,
  `paralelo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `paralelos`
--

INSERT INTO `paralelos` (`proceso`, `paralelo`) VALUES
(5, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(10) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `id_sub_caracteristica` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `nombre`, `id_sub_caracteristica`) VALUES
(14, 'Tiempos de respuesta de consultas a base de datos, o estructuras de almacenamiento de datos, colecciones', 5),
(15, 'Tiempos de operaciones de guardado de datos, registros en estructuras de almacenamiento', 5),
(16, 'Cantidades de recursos utilizados durante procesos del sistema como por ejemplo: espacio en disco de los registros insertados, archivos de log, archivos de filesystem, nivel de paginación de memoria, nivel de canales y ancho de banda, procesador del ', 6),
(17, 'Para paràmetros del sistema, definir niveles mìnimo y màximo acorde a reglas del negocio (estos paràmetros muy posiblemente deban estar disponibles al administrador del sistema, para que pueda ser configurados de manera flexible buscando no quemarlos en la implementaciòn)', 7),
(18, ' Identificaciòn y medida de respuesta de los recursos compartidos con otros sistemas de información en los puntos de interfaz', 8),
(19, 'Identificación y buen uso de los datos de entrada a un componente interno o externo del sistema de información', 9),
(20, ' identificar paràmetros de aceptación del sistema de información, que se entiendan las funciones, es facil su uso, da los innformes que quiere, acceder facil a la informacion sin tantas vueltas, es rapido, compatible con el equipo de computo que lo van a utilizar, las pantallas son agradables', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso`
--

CREATE TABLE `proceso` (
  `idproceso` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `prioridad` int(3) NOT NULL,
  `orden_secuencia` int(11) NOT NULL,
  `id_role` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proceso`
--

INSERT INTO `proceso` (`idproceso`, `nombre`, `descripcion`, `prioridad`, `orden_secuencia`, `id_role`) VALUES
(2, 'reclutamiento de personal', 'agregar nuevo personal a la empresa', 1, 7, 1),
(3, 'comprar equipos', 'compra de dispositivos hardware', 3, 4, 1),
(5, 'consultar certificados', 'verificar estado financiero de los aspirantess', 2, 1, 1),
(6, 'comprar productos', 'aaa', 1, 6, 7),
(7, 'comprar ups', 'compra para evitar que los equipos fallen cuando no hay energia', 1, 2, 7),
(9, 'jojoojo', 'nojojdaojdaojdaojo', 1, 3, 1),
(10, 'repartir cafe', 'joojajdojodauo', 2, 4, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL,
  `id_proceso` int(10) NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id`, `id_pregunta`, `id_proceso`, `descripcion`) VALUES
(1, 14, 5, 'aaaa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `idrole` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `encargado` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`idrole`, `nombre`, `descripcion`, `encargado`) VALUES
(1, 'vendedor', 'vendedor de productos', 'Jhonatan Cruz'),
(6, 'xxx', 'xxx', 'asddddddd'),
(7, 'aa', 'aawww', 'hhhh'),
(10, 'Vendedor dos', 'El vende helados', 'Pedro'),
(11, 'repartidor de tintos', 'reparte los tintos a la 9 am', 'Juan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_caracteristica`
--

CREATE TABLE `sub_caracteristica` (
  `id_sub` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `id_caract` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sub_caracteristica`
--

INSERT INTO `sub_caracteristica` (`id_sub`, `nombre`, `descripcion`, `id_caract`) VALUES
(5, 'Comportamiento temporal', 'Los tiempos de respuesta y procesamiento y los ratios de throughput de un sistema cuando lleva a cabo sus funciones bajo condiciones determinadas en relación con un banco de pruebas (benchmark) establecido', 12),
(6, 'Utilización de recursos', 'Las cantidades y tipos de recursos utilizados cuando el software lleva a cabo su función bajo condiciones determinadas', 12),
(7, 'Capacidad', 'Grado en que los límites máximos de un parámetro de un producto o sistema software cumplen con los requisitos', 12),
(8, 'Coexistencia', 'Capacidad del producto para coexistir con otro software independiente, en un entorno común, compartiendo recursos comunes sin detrimento.', 13),
(9, 'Interoperabilidad', 'Capacidad de dos o más sistemas o componentes para intercambiar información y utilizar la información intercambiada', 13),
(10, 'Madurez', 'Capacidad del sistema para satisfacer las necesidades de fiabilidad en condiciones normales', 16),
(11, 'Disponibilidad', 'Capacidad del sistema o componente de estar operativo y accesible para su uso cuando se requiere', 16),
(12, 'Tolerancia a fallos', 'Capacidad del sistema o componente para operar según lo previsto en presencia de fallos hardware o software.', 16),
(13, 'Capacidad de recuperación', 'Capacidad del producto software para recuperar los datos directamente afectados y reestablecer el estado deseado del sistema en caso de interrupción o fallo', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_interfaz`
--

CREATE TABLE `tipo_interfaz` (
  `id_tipo` int(10) NOT NULL,
  `nombre_interfaz` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_interfaz`
--

INSERT INTO `tipo_interfaz` (`id_tipo`, `nombre_interfaz`) VALUES
(1, 'Automatica'),
(2, 'Semiautomatica'),
(3, 'Manual'),
(4, 'dddddddddddddddd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipousu` int(11) NOT NULL,
  `nombre_tipousu` varchar(20) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipousu`, `nombre_tipousu`) VALUES
(1, 'Administrador'),
(2, 'Elicitador'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `user_apellido` varchar(20) COLLATE utf8_bin NOT NULL,
  `user_email` varchar(40) COLLATE utf8_bin NOT NULL,
  `user_login` varchar(20) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(40) COLLATE utf8_bin NOT NULL,
  `user_type` varchar(20) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`user_id`, `user_name`, `user_apellido`, `user_email`, `user_login`, `user_password`, `user_type`) VALUES
(1, 'Johan', 'Ordoñez', 'joan@unicauca.edu.co', 'johan', 'df7d3f6008e5ddbea40df09931b33007ee0d2ab5', '1'),
(3, 'proyecto', 'II', 'admin@rnf.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1'),
(4, 'Lucero', 'Cruz', 'luceroc@unicauca.edu.co', 'luceroC', '06b8abdc1bed263dcce2f8b6cde6c5189e61e582', '3'),
(5, 'alejandra', 'Tapia', 'alejandraTap@unicauca.edu.co', 'alejandraTp', '5563c629a6666d259e97e42b3ae5538ea402350f', '2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `interfaz`
--
ALTER TABLE `interfaz`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `normativa`
--
ALTER TABLE `normativa`
  ADD PRIMARY KEY (`idnormativa`);

--
-- Indices de la tabla `paralelos`
--
ALTER TABLE `paralelos`
  ADD PRIMARY KEY (`paralelo`,`proceso`) USING BTREE;

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD PRIMARY KEY (`idproceso`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idrole`);

--
-- Indices de la tabla `sub_caracteristica`
--
ALTER TABLE `sub_caracteristica`
  ADD PRIMARY KEY (`id_sub`);

--
-- Indices de la tabla `tipo_interfaz`
--
ALTER TABLE `tipo_interfaz`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipousu`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `interfaz`
--
ALTER TABLE `interfaz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `normativa`
--
ALTER TABLE `normativa`
  MODIFY `idnormativa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `proceso`
--
ALTER TABLE `proceso`
  MODIFY `idproceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `idrole` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `sub_caracteristica`
--
ALTER TABLE `sub_caracteristica`
  MODIFY `id_sub` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tipo_interfaz`
--
ALTER TABLE `tipo_interfaz`
  MODIFY `id_tipo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
