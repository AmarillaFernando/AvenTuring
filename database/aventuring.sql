-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2026 a las 19:48:20
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aventuring`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `modulo` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `comentario` text NOT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `modulo`, `usuario`, `comentario`, `likes`, `dislikes`, `fecha`) VALUES
(1, 'fundamentos', 'Fernando', 'La diferencia entre IA fuerte e IA débil quedó muy clara.', 14, 2, '2026-06-09 20:04:17'),
(2, 'fundamentos', 'Lucía', 'Me pareció interesante la explicación sobre la Prueba de Turing.', 10, 2, '2026-06-09 20:04:17'),
(3, 'fundamentos', 'Carlos', 'Los ejemplos históricos ayudan mucho a entender el tema.', 7, 0, '2026-06-09 20:04:17'),
(4, 'agentes', 'María', 'El modelo REAS está muy bien explicado.', 12, 1, '2026-06-09 20:04:17'),
(5, 'agentes', 'Juan', 'No sabía que un chatbot también podía considerarse un agente.', 7, 0, '2026-06-09 20:04:17'),
(6, 'formalizacion', 'Pedro', 'La abstracción es fundamental para resolver problemas complejos.', 7, 0, '2026-06-09 20:04:17'),
(7, 'formalizacion', 'Ana', 'El ejemplo de logística me ayudó a comprender los estados.', 4, 0, '2026-06-09 20:04:17'),
(8, 'busqueda', 'Sofía', 'La diferencia entre búsqueda informada y no informada quedó muy clara.', 10, 1, '2026-06-09 20:04:17'),
(9, 'busqueda', 'Miguel', 'El ejemplo del GPS es excelente para entender las heurísticas.', 14, 0, '2026-06-09 20:04:17'),
(10, 'fundamentos', 'Fernando2', 'Buen tip', 1, 2, '2026-06-09 21:28:44'),
(11, 'fundamentos', 'rodrigo', 'buen ', 2, 0, '2026-06-09 22:49:15'),
(12, 'fundamentos', 'Vanesa', 'Buen contenido', 1, 0, '2026-06-09 23:02:17'),
(13, 'fundamentos', 'Maria', 'Informacion poco precisa', 3, 0, '2026-06-09 23:03:10'),
(14, 'fundamentos', 'Sandro', 'Bien', 4, 0, '2026-06-09 23:22:51'),
(15, 'fundamentos', 'Marianela', 'En blanco', 0, 1, '2026-06-14 04:28:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `vistas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `nombre`, `vistas`) VALUES
('agentes-inteligentes', 'Agentes Inteligentes', 0),
('algoritmos-geneticos', 'Algoritmos Genéticos', 0),
('aprendizaje-reforzado', 'Aprendizaje Reforzado', 0),
('big-data', 'Big Data', 0),
('busqueda', 'Estrategias de Búsqueda', 0),
('formalizacion', 'Formalización y Abstracción', 0),
('fundamentos', 'Fundamentos IA', 30),
('logica-borrosa', 'Lógica Borrosa', 0),
('machine-learning', 'Machine Learning', 0),
('modelos-aprendizaje', 'Modelos de Aprendizaje', 0),
('percepcion-pln', 'Percepción y PLN', 1),
('sistemas-expertos', 'Sistemas Expertos', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_ratings`
--

CREATE TABLE `modulo_ratings` (
  `id` int(11) NOT NULL,
  `modulo_id` varchar(50) NOT NULL,
  `estrellas` decimal(2,1) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulo_ratings`
--

INSERT INTO `modulo_ratings` (`id`, `modulo_id`, `estrellas`, `fecha`) VALUES
(1, 'fundamentos', '4.0', '2026-06-14 05:25:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `softwares`
--

CREATE TABLE `softwares` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `licencia` varchar(50) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `enlace` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT 5,
  `modulo` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `softwares`
--

INSERT INTO `softwares` (`id`, `nombre`, `descripcion`, `categoria`, `licencia`, `anio`, `autor`, `enlace`, `rating`, `modulo`) VALUES
(5, 'ELIZA', 'Programa pionero de procesamiento de lenguaje natural que simulaba conversaciones humanas imitando a un psicoterapeuta.', 'NLP', 'Open Source', 1966, 'Joseph Weizenbaum', 'https://web.njit.edu/~ronkowit/eliza.html', 4, 'fundamentos'),
(6, 'Remote Agent', 'Sistema de IA desarrollado por la NASA capaz de planificar y ejecutar tareas de forma autónoma a bordo de naves espaciales.', 'Agentes Inteligentes', 'Privativo', 1999, 'NASA', 'https://ti.arc.nasa.gov/tech/asr/planning-and-scheduling/remote-agent/', 5, 'agentes-inteligentes'),
(7, 'DART', 'Software de planificación logística desarrollado por DARPA usado para formalizar y resolver problemas de transporte militar.', 'Planificación', 'Privativo', 1991, 'DARPA', 'https://en.wikipedia.org/wiki/DART_(software)', 3, 'formalizacion'),
(8, 'Deep Blue', 'Sistema de ajedrez desarrollado por IBM que derrotó al campeón mundial Garry Kasparov usando búsqueda heurística avanzada.', 'Búsqueda', 'Privativo', 1997, 'IBM', 'https://www.ibm.com/ibm/history/ibm100/us/en/icons/deepblue/', 5, 'busqueda'),
(9, 'WEKA', 'Plataforma de machine learning y minería de datos que incluye algoritmos de clasificación, regresión y clustering.', 'Machine Learning', 'Open Source', 1999, 'University of Waikato', 'https://www.cs.waikato.ac.nz/ml/weka/', 4, 'machine-learning'),
(10, 'R', 'Lenguaje y entorno estadístico ampliamente usado para implementar los 5 modelos de aprendizaje automático.', 'Machine Learning', 'Open Source', 1993, 'Ross Ihaka y Robert Gentleman', 'https://www.r-project.org/', 4, 'modelos-aprendizaje'),
(11, 'MAME Toolkit', 'Entorno Python para investigación en aprendizaje reforzado que permite implementar Q-Learning, SARSA y MDP.', 'Aprendizaje Reforzado', 'Open Source', 2015, 'John Mather', 'https://github.com/mikedewar/MAME', 3, 'aprendizaje-reforzado'),
(12, 'BotColony', 'Plataforma de desarrollo de agentes conversacionales con capacidades de PLN y reconocimiento de patrones.', 'NLP', 'Freemium', 2012, 'Eugene Goostman Team', 'https://www.botcolony.com/', 3, 'percepcion-pln'),
(13, 'CLIPS', 'Lenguaje de programación para sistemas expertos desarrollado por la NASA, basado en reglas de producción.', 'Sistemas Expertos', 'Open Source', 1985, 'NASA', 'https://www.clipsrules.net/', 4, 'sistemas-expertos'),
(14, 'JESS', 'Motor de reglas y lenguaje de scripting para sistemas expertos con soporte para lógica borrosa y razonamiento difuso.', 'Lógica Borrosa', 'Freemium', 1995, 'Ernest Friedman-Hill', 'https://jess.sandia.gov/', 3, 'logica-borrosa'),
(15, 'Pyevolve', 'Framework Python para implementar algoritmos genéticos y computación evolutiva con operadores de cruce y mutación.', 'Algoritmos Genéticos', 'Open Source', 2009, 'Christian S. Perone', 'https://pyevolve.sourceforge.net/', 3, 'algoritmos-geneticos'),
(16, 'Apache Hadoop', 'Framework de procesamiento distribuido para Big Data que implementa el paradigma MapReduce a gran escala.', 'Big Data', 'Open Source', 2006, 'Apache Software Foundation', 'https://hadoop.apache.org/', 5, 'big-data');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software_likes`
--

CREATE TABLE `software_likes` (
  `id` int(11) NOT NULL,
  `software_id` int(11) NOT NULL,
  `likes_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulo_ratings`
--
ALTER TABLE `modulo_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `softwares`
--
ALTER TABLE `softwares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `software_likes`
--
ALTER TABLE `software_likes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `modulo_ratings`
--
ALTER TABLE `modulo_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `softwares`
--
ALTER TABLE `softwares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `software_likes`
--
ALTER TABLE `software_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
