-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 22, 2026 at 12:16 AM
-- Server version: 8.0.44
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biblioteca`
--

-- --------------------------------------------------------

--
-- Table structure for table `autor`
--

CREATE TABLE `autor` (
  `id` int NOT NULL,
  `nombre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `apellido` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `fecha_nac` date NOT NULL,
  `biografia` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `foto` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `autor`
--

INSERT INTO `autor` (`id`, `nombre`, `apellido`, `fecha_nac`, `biografia`, `foto`) VALUES
(2, 'Antoine', 'de Saint-Exupéry', '1900-06-29', 'Escritor y aviador francés, famoso por El Principito.', 'antoine.jpg'),
(3, 'Antoine', 'de Saint-Exupéry', '1900-06-29', 'Escritor y aviador francés, famoso por El Principito.', 'antoine.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `libro`
--

CREATE TABLE `libro` (
  `id` int NOT NULL,
  `id_autor` int NOT NULL,
  `titulo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `descripcion` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `imagen` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `libro`
--

INSERT INTO `libro` (`id`, `id_autor`, `titulo`, `descripcion`, `imagen`, `fecha_publicacion`) VALUES
(3, 3, 'El gran libro de Matías', 'Una prueba espectacular usando tokens JWT', 'sin_imagen.jpg', '2026-06-21'),
(4, 3, 'Crónicas de un Programador en el Espacio', 'Un viaje intergaláctico donde los bugs cobran vida y amenazan el universo.', 'libro_espacio.jpg', '2026-01-15'),
(5, 3, 'El Misterio del Token Vencido', 'Un detective informático busca desesperadamente el error 401 en un servidor maldito.', 'misterio_token.jpg', '2026-03-22'),
(6, 3, 'Las Crónicas de PDO y MySQL', 'Una batalla épica entre guerreros de código y monstruos relacionales en la base de datos.', 'cronicas_pdo.jpg', '2026-05-10'),
(7, 3, 'Sobreviviendo a MAMP sin morir en el intento', 'Una guía espiritual para mantener la calma cuando tu Mac decide borrar los headers.', 'sobreviviendo_mamp.jpg', '2026-06-21'),
(8, 3, 'Sobreviviendo a MAMP sin morir en el intento', 'Una guía espiritual para mantener la calma cuando tu Mac decide borrar los headers.', 'sobreviviendo_mamp.jpg', '2026-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `password`) VALUES
(1, '1234', '$2y$10$zdRMZYTvLDvItNGvtNIuQuWDNwZ1T7XeK9NlWxjeHy9IFpVwMP9WG'),
(2, '12345', '$2y$10$Ol1kmpD5v0YyO9nzfyT9b.ixUQijBGhhc.df5zv28ZuK5MsmhDLP6'),
(4, 'matias', '$2y$10$io9HcRkMItuR9bEecfsh2eN.x.XVkXewQonrdt61e3zdVFZgvKJm6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autor`
--
ALTER TABLE `autor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `autor` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
