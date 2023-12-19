-- Adminer 4.8.1 MySQL 11.1.2-MariaDB-1:11.1.2+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `Creneau` (`id`, `jourSemaine`, `heureDeDepart`, `heureDeFin`, `emission_id`) VALUES
                                                                                              (1,	1,	'10:00:00',	'12:00:00',	1),
                                                                                              (2,	2,	'14:00:00',	'16:00:00',	2),
                                                                                              (3,	3,	'18:00:00',	'20:00:00',	3);

INSERT INTO `Emission` (`id`, `titre`, `description`, `theme`, `photo`, `user_mail`) VALUES
                                                                                         (1,	'Emission 1',	'Description 1',	'Theme 1',	'photo1.jpg',	'admin@example.com'),
                                                                                         (2,	'Emission 2',	'Description 2',	'Theme 2',	'photo2.jpg',	'user1@example.com'),
                                                                                         (3,	'Emission 3',	'Description 3',	'Theme 3',	'photo3.jpg',	'user2@example.com');

INSERT INTO `InvitesPodcast` (`emailInvite`, `idPodcast`) VALUES
                                                              ('user1@example.com',	1),
                                                              ('user1@example.com',	2),
                                                              ('user2@example.com',	3);

INSERT INTO `Podcast` (`id`, `titre`, `description`, `duree`, `date`, `audio`, `photo`, `emission_id`) VALUES
                                                                                                           (1,	'Podcast 1',	'Description 1',	'01:30:00',	'2023-12-19',	'audio1.mp3',	'podcast1.jpg',	1),
                                                                                                           (2,	'Podcast 2',	'Description 2',	'02:00:00',	'2023-12-20',	'audio2.mp3',	'podcast2.jpg',	2),
                                                                                                           (3,	'Podcast 3',	'Description 3',	'01:45:00',	'2023-12-21',	'audio3.mp3',	'podcast3.jpg',	3);

INSERT INTO `User` (`email`, `password`, `prenom`, `nom`, `role`, `refresh_token`, `refresh_token_expiration_date`, `reset_password_token`, `reset_password_token_expiration_date`) VALUES
                                                                                                                                                                                        ('admin@example.com',	'hashed_password',	'Admin',	'User',	1,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                                                        ('user1@example.com',	'hashed_password',	'John',	'Doe',	2,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                                                        ('user2@example.com',	'hashed_password',	'Jane',	'Doe',	2,	NULL,	NULL,	NULL,	NULL);

-- 2023-12-19 12:48:33
