-- Adminer 4.8.1 MySQL 11.1.2-MariaDB-1:11.1.2+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `Creneau`;
CREATE TABLE `Creneau` (
                           `id` int(4) NOT NULL AUTO_INCREMENT,
                           `jourSemaine` int(4) NOT NULL,
                           `heureDeDepart` time NOT NULL,
                           `heureDeFin` time NOT NULL,
                           `emission_id` int(3) NOT NULL,
                           PRIMARY KEY (`id`),
                           KEY `emission_id` (`emission_id`),
                           CONSTRAINT `Creneau_ibfk_1` FOREIGN KEY (`emission_id`) REFERENCES `Emission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


DROP TABLE IF EXISTS `Emission`;
CREATE TABLE `Emission` (
                            `id` int(3) NOT NULL AUTO_INCREMENT,
                            `titre` varchar(128) NOT NULL,
                            `description` varchar(128) NOT NULL,
                            `theme` varchar(128) NOT NULL,
                            `photo` varchar(128) DEFAULT NULL,
                            `user_mail` varchar(128) DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            KEY `user_mail` (`user_mail`),
                            CONSTRAINT `Emission_ibfk_1` FOREIGN KEY (`user_mail`) REFERENCES `User` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


DROP TABLE IF EXISTS `InvitesPodcast`;
CREATE TABLE `InvitesPodcast` (
                                  `emailInvite` varchar(128) NOT NULL,
                                  `idPodcast` int(4) NOT NULL,
                                  KEY `idPodcast` (`idPodcast`),
                                  KEY `emailInvite` (`emailInvite`),
                                  CONSTRAINT `InvitesPodcast_ibfk_1` FOREIGN KEY (`idPodcast`) REFERENCES `Podcast` (`id`),
                                  CONSTRAINT `InvitesPodcast_ibfk_2` FOREIGN KEY (`emailInvite`) REFERENCES `User` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


DROP TABLE IF EXISTS `Podcast`;
CREATE TABLE `Podcast` (
                           `id` int(4) NOT NULL AUTO_INCREMENT,
                           `titre` varchar(128) NOT NULL,
                           `description` varchar(128) DEFAULT NULL,
                           `duree` time NOT NULL,
                           `date` date NOT NULL,
                           `audio` varchar(512) NOT NULL,
                           `photo` varchar(256) DEFAULT NULL,
                           `emission_id` int(3) DEFAULT NULL,
                           PRIMARY KEY (`id`),
                           KEY `emission_id` (`emission_id`),
                           CONSTRAINT `Podcast_ibfk_1` FOREIGN KEY (`emission_id`) REFERENCES `Emission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
                        `email` varchar(128) NOT NULL,
                        `password` varchar(128) NOT NULL,
                        `prenom` varchar(128) NOT NULL,
                        `nom` varchar(128) NOT NULL,
                        `role` int(4) NOT NULL,
                        `refresh_token` varchar(64) DEFAULT NULL,
                        `refresh_token_expiration_date` timestamp NULL DEFAULT NULL,
                        `reset_password_token` varchar(64) DEFAULT NULL,
                        `reset_password_token_expiration_date` timestamp NULL DEFAULT NULL,
                        PRIMARY KEY (`email`),
                        UNIQUE KEY `refresh_token_expiration_date` (`refresh_token_expiration_date`),
                        UNIQUE KEY `reset_password_token` (`reset_password_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


-- 2023-12-19 12:47:58
