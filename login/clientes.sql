CREATE TABLE `clientes` (
  `name` varchar(50) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fechaN` date NOT NULL,  
  `telefono` varchar(10) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `foto` varchar(250) NOT NULL,  
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `users`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name` (`name`);