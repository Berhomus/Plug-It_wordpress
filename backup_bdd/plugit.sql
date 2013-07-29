-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 25 Juillet 2013 à 09:35
-- Version du serveur: 5.5.20
-- Version de PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `plugit`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `mdp_md5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`id`, `login`, `mdp_md5`) VALUES
(2, 'plugit', 'b04942b84582fc7f84712a538b7b8829');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `visible`) VALUES
(1, 'destokage', 1),
(2, 'telephonie', 1),
(3, 'mobilite', 1);

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interne` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `baseName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `lien` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `menu`
--

INSERT INTO `menu` (`id`, `interne`, `active`, `nom`, `baseName`, `position`, `lien`, `meta`) VALUES
(1, 1, 1, 'Accueil', 'accueil', 1, 'Index.php?page=accueil&sub=main', 'Société de services en informatique spécialisée dans l’infogérance, l’hébergement de systèmes d’informations la mise en place de solutions de cloud computing et la maintenance de réseaux informatique.'),
(2, 1, 1, 'Solutions', 'solutions', 2, 'Index.php?page=solutions&mode=view', 'Les solutions de plug-it sont : WanaDesk vous permet d’accéder à votre bureau virtuel depuis n’importe où* sur la planète !\r\n*connexion Internet requise. WanaDev vous propose une solution logicielle de gestion commerciale « en ligne » et entièrement sur-mesure... WanaTel vous offre la téléphonie HD, moderne, aux fonctionnalités étendues, en réduisant au maximum vos coûts ! WanaMail vous permet d’accéder à votre messagerie en tout lieu et de partager l’ensemble de vos fonctionnalités entre tous vos salariés ! WanaStore vous offre une sauvegarde automatique et sécurisée à 100 % de toutes vos données, en toute sérénité.. WanaBox vous permet de stocker tous vos documents sur l''ensemble de vos ordinateurs, tablettes et smartphones !'),
(3, 1, 1, 'Références', 'references', 3, 'Index.php?page=references&mode=view', 'Les principaux clients de Plug-it, satisfait des solutions proposées et de la mise en place de nos services d''infogérance, cloud computing, maintenance réseaux ...'),
(4, 1, 1, 'Contact', 'contact', 4, 'Index.php?page=contact', 'Contactez plug-it à Amiens pour tout renseignement sur nos solutions informatiques, de cloud computing, d''infogérance, d''hébergement de SI et de maintenance de réseaux'),
(5, 1, 1, 'Support', 'support', 5, 'Index.php?page=support', 'Un problème en informatique, plug-it propose à ses clients une assistance téléphonique afin de résoudre vos problèmes le plus rapidement et efficacement que possible.'),
(6, 1, 1, 'Paiement', 'reglement', 6, 'Index.php?page=reglement', 'Vous êtes client de plug-it et vous souhaitez régler vos factures, cette page vous permet de payer en ligne en toute sécurité.'),
(7, 1, 0, 'Boutique', 'boutique', 6, 'Index.php?page=boutique', 'Vous êtes client de plug-it et vous souhaitez régler vos factures, cette page vous permet de payer en ligne en toute sécurité.');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `images` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `prix` float NOT NULL,
  `categorie` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `priorite` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `ref`
--

CREATE TABLE IF NOT EXISTS `ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `titre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lien` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sous_titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Contenu de la table `ref`
--

INSERT INTO `ref` (`id`, `image`, `titre`, `lien`, `sous_titre`, `date`, `ordre`) VALUES
(1, 'images/ref_01.jpg', 'Maison de la Culture d''Amiens', 'http://www.maisondelaculture-amiens.com/www/', 'Infogérance Cloud Computing', '2013-06-20 14:15:39', 1),
(2, 'images/ref_02.jpg', 'Missions locales de Picardie', 'http://www.missions-locales-picardie.org/', 'Infogérance Cloud Computing', '2013-06-20 14:38:36', 2),
(3, 'images/ref_03.jpg', 'Conseil Régional de Picardie', 'http://www.picardie.fr/', 'Assistance nouvelles technologies', '2013-06-20 14:40:51', 3),
(4, 'images/ref_04.jpg', 'CHU d''Amiens', 'http://www.chu-amiens.fr/', 'Marché public', '2013-06-20 14:43:10', 4),
(5, 'images/ref_05.jpg', 'CCA International', 'http://www.ccainternational.com/', 'Missions d’audit et conseil NE15838', '2013-06-20 14:44:56', 5),
(6, 'images/ref_06.jpg', 'RICOH', 'http://www.ricoh.fr/', 'Missions d’audits techniques', '2013-06-20 14:47:39', 6),
(7, 'images/ref_07.jpg', 'Spta', 'http://www.spta.fr/', 'Infogérance Cloud Computing', '2013-06-20 14:49:36', 7),
(8, 'images/ref_08.jpg', 'Neuronnexion', 'http://www.neuronnexion.fr/', 'Partenaire historique', '2013-06-20 14:53:32', 8),
(9, 'images/ref_09.jpg', 'Croix Rouge', 'http://www.croix-rouge.fr/', 'Infogérance', '2013-06-20 14:54:44', 9),
(10, 'images/ref_10.jpg', 'Orchestre de Picardie', 'http://www.orchestredepicardie.fr/', 'Infogérance', '2013-06-20 14:55:42', 10),
(11, 'images/ref_11.jpg', 'Comédie de Picardie', 'http://www.comdepic.com/', 'Infogérance', '2013-06-20 14:56:42', 11),
(12, 'images/ref_12.jpg', 'La Ligue de l''Enseignement', 'http://www.fol80.net/', 'Infogérance Cloud Computing', '2013-06-20 14:57:31', 12);

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `corps` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `subtitre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `services`
--

INSERT INTO `services` (`id`, `titre`, `corps`, `image`, `subtitre`, `date`, `ordre`) VALUES
(2, 'Maintenance : Préventive, Curative &amp; Evolutive', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Que vous ayez quelques ordinateurs ou un parc informatique comprenant des dizaines d’équipements IT, des routeurs, des passerelles, des serveurs, des sites distants, des agents itinérants, vous pouvez souscrire à l’une de nos solutions de maintenance informatique.</span>\r\nCombien de temps pouvez-vous tolérer un arrêt de production ? 1 heure, 4 heures, une journée ou plus ?\r\nSuivant votre besoin, nous pouvons vous proposer de l’intervention sur mesure au ticket horaire au contrat spécifique avec des garanties de temps d’intervention et des garanties de temps de rétablissement.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Dans tous les cas, nous pouvons référencer 3 types de maintenance :</span>\r\n\r\n<b>- La maintenance informatique préventive</b> qui consiste à effectuer un nettoyage de vos ordinateurs, de mettre à jour les logiciels ou encore d''enlever les éventuels virus ou autres malwares. Pour cela, 2 interventions par an sont prévues.\r\n<b>- La maintenance informatique curative</b> qui comprend les interventions ponctuelles de dépannage. En cas de problème, vous êtes prioritaire sur le délai d''intervention.\r\n<b>- La maintenance informatique évolutive</b> qui permet d''améliorer le système par rapport à l''évolution des technologies. Cela peut être par exemple l''installation de nouveaux équipements ou la mise à jour de logiciels.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Les avantages du contrat de maintenance informatique</span>\r\n\r\n- Vous êtes prioritaire par rapport aux clients qui n''ont pas souscrit de contrat.\r\n- Il couvre les interventions ponctuelles de dépannage.\r\n- Vous bénéficiez de tarifs préférentiels sur les interventions de maintenance informatique.\r\n</p>', 'images/services_maintenance.png', 'Maintenance', '2013-06-20 13:51:22', 3),
(3, 'Infogérance : Maintenance, dépannage & sauvegarde', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Vous êtes une petite structure en profession libérale, une association, une TPE/PME, sans informaticien ou sans\r\ncompétence particulière en informatique.</span>\r\n\r\nNous pouvons intervenir dans la gestion de votre infrastructure en vous assurant les services informatiques courant tels la maintenance, les dépannages, les\r\nsauvegardes de vos données.\r\nNotre équipe d''experts mettra son expérience au service de la gestion quotidienne de votre serveur.\r\nL''objectif principal est d''anticiper tout problème et de mettre en place les outils et procédures requises afin de pouvoir réagir immédiatement en cas d''imprévu.\r\n\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Notre équipe assurera le bon fonctionnement de votre serveur en contrôlant les points suivants :</span>\r\n\r\n- l''astreinte,\r\n- la supervision,\r\n- la sécurité,\r\n- la sauvegarde,\r\n- la redondance.\r\n\r\n<b>Ainsi, nous mettons en œuvre tout notre savoir-faire afin de respecter notre engagement de garantie de temps de rétablissement.</b>\r\n</p>\r\n', 'images/services_infogerance.png', 'Infogérance', '2013-06-21 07:25:47', 1),
(4, 'Audit &amp; conseil', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Un audit informatique est un état des lieux de votre infrastructure Informatique et Telecom. Il est réalisé afin de \r\ndéfinir des axes d''amélioration et obtenir des conseils et des préconisations pour pallier aux faiblesses constatées.</span>\r\n\r\nSouvent il est exécuté à la demande du client pour avoir un nouveau point de vue de son système d’informations et de ses vulnérabilités.\r\nMais nous pouvons l’initier dans le cadre de la signature d’un contrat de maintenance où il est nécessaire de faire cet état des lieux pour la mise en place de \r\nPCA/PRA (Plan de Continuité d’Activité/Plan de Reprise d’Activité).\r\n\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Le rapport d’audit comprend :</span>\r\n\r\n- le schéma de l’infrastructure IT (interconnexion réseau et adressage IP),\r\n- la nomenclature et les caractéristiques des équipements informatiques (PC, serveurs, routeurs, pare-feu, commutateurs, etc.),\r\n- la nomenclature des services actifs de vos serveurs,\r\n- les logiciels installés et leur demande en ressources,\r\n- les sécurités matérielles et logiciels,\r\n- la disponibilité du réseau et des serveurs,\r\n- les protections électriques et mécaniques (baie informatique, accès badgé, sondes, etc.),\r\n- les jeux de sauvegardes,\r\n- les redondances et « Fail Over ».\r\n\r\n<b>À partir de ce diagnostic, les failles sont facilement identifiables et nos conseils deviennent pertinents. Les conseils d’amélioration ou de\r\nmodification sont menés suivant les critères de production et de sécurité du client.</b>\r\n</p>\r\n', 'images/services_audit.png', 'Audit &amp; conseil', '2013-06-21 07:31:51', 2),
(5, 'Architecture réseau &amp; ingénierie IT', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Notre équipe technique est composée d’experts informatiques (niveau II) qualifiés dans les services suivants </span>\r\n\r\n- Serveurs Microsoft (SBS, Standard, entreprise et DataCenter)\r\n- Virtualisation (VMWare, HyperV)\r\n- Routage et commutation niveau III (HP, SMC, D-LINK)\r\n- Boitiers de sécurité (SonicWALL, CISCO, Fortinet)\r\n- Interconnexions WAN/LAN et réseaux sans fil (ZyXEL, ARUBA)\r\n- Téléphonie IP (keyyo)\r\n- Appliances spécifiques (IronPort, MailFontain)\r\n- Administration et consoles logiciels (AdminKit Kaspersky, NTR)\r\n\r\n<b>À partir de ces différentes compétences, nos ingénieurs sont à même de concevoir et implémenter une solution informatique/téléphonique au sein \r\nde votre structure.</b>\r\n\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Les points essentiels se décomposent en groupes :</span>\r\n\r\n- Définition des besoins du client.\r\n- Proposition d’architecture IT.\r\n- Proposition de matériel Informatique/Telecom.\r\n- Proposition des sécurités matérielles et logiciels.\r\n- Mise en service de la solution avec recette de fonctionnement.\r\n- Transfert de compétences.\r\n- Proposition d’infogérance ou de maintenance classique.\r\n\r\n</p>\r\n', 'images/services_architecture.png', 'Ingénierie IT', '2013-06-21 07:57:20', 4),
(6, 'Virtualisation : utilisation optimale des ressources', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">La virtualisation consiste à faire fonctionner un ou plusieurs systèmes d''exploitation, sur un ou plusieurs serveurs  \r\nau lieu d''en installer un seul par machine.</span>\r\n\r\nImaginez qu’au lieu de gérer plusieurs serveurs, vous n’ayez plus qu’un seul qui rassemble tous vos services.\r\n\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Les intérêts sont :</span>\r\n\r\n- utilisation optimale des ressources d''un parc de machines (répartition des machines virtuelles sur les machines physiques en fonction des charges respectives),\r\n- installation, déploiement et migration facile des machines virtuelles d''une machine physique à une autre, notamment dans le contexte d''une mise en production à \r\npartir d''un environnement de qualification ou de pré-production, livraison facilitée,\r\n- économie sur le matériel par mutualisation (consommation électrique, entretien physique, surveillance, support, compatibilité matérielle, etc.),\r\n- installation, tests, développements, cassage et possibilité de recommencer sans casser le système d''exploitation hôte,\r\n- sécurisation et/ou isolation d''un réseau (cassage des systèmes d''exploitation virtuels, mais pas des systèmes d''exploitation hôtes qui sont invisibles pour \r\nl''attaquant, tests d''architectures applicatives et réseau),\r\n- isolation des différents utilisateurs simultanés d''une même machine (utilisation de type site central),\r\n- allocation dynamique de la puissance de calcul en fonction des besoins de chaque application à un instant donné,\r\n- diminution des risques liés au dimensionnement des serveurs lors de la définition de l''architecture d''une application, l''ajout de puissance (nouveau serveur etc)\r\n étant alors transparente.\r\n\r\n</p>', 'images/services_virtualisation.png', 'Virtualisation', '2013-06-21 08:10:15', 5),
(7, 'Mise à la norme Européenne des PCA', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">C’est à la suite d’une mission dans un groupe de plus de 4 500 salariés que nous proposons nos services à préparer la norme Européenne EN15838 pour les grands comptes.</span></p><b>\r\nCette mission consistait à travailler en collaboration avec l’agence AFNOR sur la section NF Services IT pour l’obtention de la norme Européenne\r\n NF Services NP-7. L’étude du taux de disponibilité des services IT se traduit par la pondération du taux de disponibilité de chaque service IT qui la \r\n compose.\r\n</b>\r\nDans un premier temps, nous inventorions les différents services en qualifiant les matériels, les contrats et sécurités associés.\r\nPuis dans un second volet, nous rapporterons les interactions entre les services IT et les fournisseurs, l’augmentation de la sécurité via les tiers « DataCenter »,\r\n les Plans de Continuité d’Activités mis en œuvre, la conservation des données, les processus, les modes opératoires appliqués à la production et le chiffrage de la \r\n disponibilité via l’indicateur NF NP-7.\r\nC’est un processus relativement complexe mais efficace pour une grande structure.\r\n\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">N''hésitez pas à nous contacter pour toute étude !</span>\r\n\r\n', 'images/services_norme.png', 'Mise à la norme', '2013-06-21 08:15:01', 6);

-- --------------------------------------------------------

--
-- Structure de la table `solutions`
--

CREATE TABLE IF NOT EXISTS `solutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `corps` text COLLATE utf8_unicode_ci NOT NULL,
  `image_car` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_sol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Contenu de la table `solutions`
--

INSERT INTO `solutions` (`id`, `titre`, `corps`, `image_car`, `image_sol`, `description`, `date`, `ordre`) VALUES
(1, 'WanaDesk', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Accéder à votre bureau virtuel depuis une simple connexion internet</span>\r\n\r\n<b>- Le Cloud vous permet d’utiliser vos applications depuis internet :</b>\r\nDepuis n’importe quel périphérique connecté (PC, MAC, iPad, iPhone, etc.).\r\nPlus d’achat de logiciels : bureautique, gestion, antivirus, comptabilité.\r\nPlus de soucis de mises à jour.\r\n\r\n<b>- Accéder à vos données à tout moment et de n’importe où :</b>\r\nDepuis votre bureau, en déplacement ou à domicile.\r\nPlus de soucis de sauvegarde, on s’en occupe pour vous.\r\n\r\n<b>- Vos données en toute sécurité :</b>\r\nVous accédez à vos données cryptées via un portail sécurisé grâce à un login et un mot de passe personnel.\r\n\r\n<b>- Vos applications métiers installées sur votre ou vos serveurs virtuels dédiés.</b>\r\n\r\n<b>- Un coût maîtrisé :</b>\r\nVous n’achetez rien, vous souscrivez juste un abonnement mensuel au coût défini.\r\n\r\n<b>- Une démarche écologique :</b>\r\nLe Cloud ne sollicite pas inutilement vos ressources informatiques et prolonge la durée de vie de votre matériel.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">À partir de 1 utilisateur, stockage illimité et coût maîtrisé !</span>\r\n\r\n</p>', 'images/slide_01.jpg', 'images/solutions_wanadesk.jpg', 'vous permet d’accéder à votre bureau virtuel  depuis n’importe où* sur la planète ! *connexion Internet requise', '2013-06-20 14:34:29', 7),
(2, 'WanaDev', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">WanaDEV est une gestion commerciale complète en fonctionnement Cloud computing. Vous retrouverez toutes les fonctionnalités d’une gestion commerciale TPE/PME tels que :</span>\r\n\r\n- Devis, commandes, bons de livraison, factures pour les achats et les ventes.\r\n- Gestion des contrats de maintenance.\r\n- Gestion du stock.\r\n- Gestion de la DEEE.\r\n- Statistiques multicritères.\r\n- Module de comptabilité. Ce produit est un développement « maison » ce qui offre à l’utilisateur un environnement personnalisable à souhait ainsi que la possibilité de créer des développements spécifiques à votre métier. Le module de comptabilité est compatible avec tous les logiciels de comptabilité du marché.\r\n\r\n</p>\r\n', 'images/slide_02.jpg', 'images/solutions_wanadev.jpg', 'vous propose une solution logicielle de gestion commerciale « en ligne » et entièrement sur-mesure...', '2013-06-21 08:25:16', 8),
(3, 'WanaTel', '<p>\r\n<img src="images/keyyo.png"/>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre"><a class="mail" href="http://www.keyyo.com/fr/">www.keyyo.fr</a><br/></span>\r\n<b>\r\n- Votre téléphonie d''entreprise disponible en 48h !\r\n- Votre ligne de fax par mail offerte.\r\n- Standard téléphonique inclus\r\n- La simplicité d''une solution Plug & Call et fax.</b>\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Votre téléphonie hébergé tout compris à partir de 15 € HT/mois par poste</span>\r\n\r\n<b>Téléphonie IP et fax de 1 à 200 postes :</b>\r\n- Messagerie vocale par mail.\r\n- Appels illimités ou à la consommation.\r\n- Fax par mail.\r\n- Conférence téléphonique.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">La téléphonie IP est une solution modulaire de 1 à 200 postes avec un forfait tout compris par utilisateur.</span>\r\n\r\nQuelle que soit la taille de votre entreprise ou son activité, la téléphonie IP est la solution qui vous permet d''optimiser à la fois vos coûts, vos infrastructures et la \r\ngestion de vos télécoms.\r\n\r\n<b>De nombreux avantages au service de votre entreprise :</b>\r\n- simplicité de mise en œuvre,\r\n- richesse des fonctionnalités,\r\n- économies et liberté,\r\n- souplesse et évolutivité.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Découvrez la souplesse d''une gestion poste par poste de votre téléphonie></span>\r\n\r\nVous choisissez le forfait adapté à chacun de vos utilisateurs et modulez en toute liberté votre parc téléphonique : un tarif à la consommation pour les utilisateurs ayant un faible volume d''appels.\r\n\r\n<b>Illimité Centrex (15 € HT/mois et /poste) :</b>\r\n- Appels illimités vers les fixes en France.\r\n- Appels illimités 24h/24 vers les mobiles de l''entreprise.\r\n- Appels illimités vers 50 destinations.\r\n\r\n<b>Illimité Mobile Centrex (29 € HT /mois et /poste) :</b>\r\n- Appels illimités vers les fixes en France.\r\n- Appels illimités vers les mobiles de tous les opérateurs.\r\n- Appels illimités vers les mobiles de l''entreprise 24h/24.\r\n- Appels illimités vers 50 destinations.\r\n- Ligne pour équipements Data : 15,80 € HT/mois.\r\n\r\n<b>Possibilté de souscrire à une ligne analogique pour vos fax, terminaux de paiement, affranchisseuses, portiers, alarmes, etc.</b>\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">L’offre de téléphonie IP comprend :</span>\r\n\r\n<b>- La portabilité de vos anciens numéros</b>\r\nKeyyo effectue pour vous gratuitement la portabilité de vos numéros auprès de France Telecom.\r\n<b>- De nouveaux numéros au choix</b><br/>\r\nNous vous proposons différents types de numéros : géographique, Voip, Gold, spéciaux, etc.\r\n\r\n<b>- Votre standard téléphonique évolutif</b>\r\nIl permet à votre entreprise de s''affranchir d''une installation complexe et coûteuse d''un PABX et de bénéficier de toutes les fonctionnalités intégrées : pré-décroché,\r\ngroupe d’appel, musique d’attente, standard vocal interactif (SVI), journal d’appel, renvoi d’appel, numéro abrégé, interception, mise en parc, supervision poste \r\nstandardiste, etc.\r\n\r\n<b>- Une ligne de Fax par mail</b>\r\nPour envoyer et recevoir vos fax où que vous soyez.\r\n\r\n<b>- Tous les services convergents, téléphoniques, annuaire</b>\r\nTous vos services sont intégrés à vos lignes. Dès la mise à disposition de nouveaux services, vous en bénéficiez automatiquement et gratuitement.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Solution IPBX</span>\r\n\r\n<b>L’IPBX permet d’adresser le marché des PABX en renouvellement.</b>\r\nVous évoluez dans un environnement totalement maitrisé dans lequel le constructeur et l''opérateur vous accompagnent dans vos installations et vous garantissent \r\nainsi un passage à la VoIP en toute tranquillité.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Un large choix de constructeurs</span>\r\n\r\nCompatible avec les plus grands constructeurs du marché, les solutions Keyyo Business peuvent avantageusement remplacer les accès T0 et T2 France Telecom \r\npour fonctionner en full IP (réception et émission des appels via Keyyo) ou en hybride (réception des appels via France Telecom, sortie via Keyyo).\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Les offres IPBX</span>\r\n\r\n<b>L''offre complète avec IPBX Cisco : " Le pack HD SIP " :</b>\r\n- Accès SDSL Keyyo 100% garanti.\r\n- Appels illimités vers les postes fixes en France + 50 destinations :\r\nAfrique du Sud, Allemagne, Andorre, Argentine, Australie, Autriche, Belgique, Brésil, Bulgarie, Canada (+ mobiles), Chili, Chine (+ mobiles), Chypre, Corée du \r\nSud, Croatie, Danemark, Espagne, Estonie, États-Unis (+ mobiles), Finlande, Grèce, Hong-Kong (+mobiles), Hongrie, Irlande, Islande, Israël, Italie, Japon, Jersey, \r\nMacao (+ mobiles), Macédoine, Malaisie (+ mobiles),Malte, Monaco, Norvège, Nouvelle-Zélande, Panama, Pays-Bas, Pérou, Portugal, Rép. Tchèque, \r\nRoyaume-Uni, Singapour (+ mobiles), Slovaquie, Suède, Suisse, Taiwan, Thaïlande (+ mobiles), Vatican.\r\n- Des communications vers les mobiles incluses.\r\n- La technologie audio Haute Définition.\r\n- T0 de 2 à 6 T0.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Découvrir le Pack HD SIP<br/></span>\r\n\r\n<b>L''illimité Mobile par Keyyo Business : " T0/T2 Illimité Mobile " :</b>\r\n- Appels illimités vers les mobiles tous opérateurs : du lundi au vendredi, de 8h à 18h.\r\n- Appels illimités vers les postes fixes en France + 50 destinations :\r\nAfrique du Sud, Allemagne, Andorre, Argentine, Australie, Autriche, Belgique, Brésil, Bulgarie, Canada (+ mobiles), Chili, Chine (+ mobiles), Chypre, Corée du \r\nSud, Croatie, Danemark, Espagne, Estonie, États-Unis (+ mobiles), Finlande, Grèce, Hong-Kong (+mobiles), Hongrie, Irlande, Islande, Israël, Italie, Japon, Jersey, \r\nMacao (+ mobiles), Macédoine, Malaisie (+ mobiles),Malte, Monaco, Norvège, Nouvelle-Zélande, Panama, Pays-Bas, Pérou, Portugal, Rép. Tchèque, \r\nRoyaume-Uni, Singapour (+ mobiles), Slovaquie, Suède, Suisse, Taiwan, Thaïlande (+ mobiles), Vatican.\r\n- T0 de 1 à 8 T0.\r\n- T2 de 15 à 30 canaux.\r\n- Disponible sur accès Tiers ou sur accès DSL Keyyo.\r\n\r\n<b>L''illimité par Keyyo Business : " T0/T2 IP illimité " :</b>\r\n- T0 de 1 à 8 T0.\r\n- T2 de 15 à 30 canaux.\r\n- Appels illimités vers les fixes en France et 50 destinations :\r\nAfrique du Sud, Allemagne, Andorre, Argentine, Australie, Autriche, Belgique, Brésil, Bulgarie, Canada (+ mobiles), Chili, Chine (+ mobiles), Chypre, Corée du \r\nSud, Croatie, Danemark, Espagne, Estonie, États-Unis (+ mobiles), Finlande, Grèce, Hong-Kong (+mobiles), Hongrie, Irlande, Islande, Israël, Italie, Japon, Jersey, \r\nMacao (+ mobiles), Macédoine, Malaisie (+ mobiles),Malte, Monaco, Norvège, Nouvelle-Zélande, Panama, Pays-Bas, Pérou, Portugal, Rép. Tchèque, \r\nRoyaume-Uni, Singapour (+ mobiles), Slovaquie, Suède, Suisse, Taiwan, Thaïlande (+ mobiles), Vatican.\r\n- Tarifs mobiles : hors-forfait.\r\n\r\n<b>La liberté par Keyyo Business " T0/T2 Libres " :</b>\r\n- Pas d''abonnement.\r\n- Facturation à la consommation.\r\n\r\n</p>', 'images/slide_03.jpg', 'images/solutions_wanatel.jpg', 'vous offre la téléphonie HD, moderne, aux fonctionnalités étendues, en réduisant au maximum vos coûts !', '2013-06-21 08:55:36', 9),
(4, 'WanaMail', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Messagerie collaborative</span>\r\n<b>\r\nMicrosoft Exchange Messagerie électronique, calendriers et contacts professionnels sur votre PC, téléphone ou sur Internet.\r\n</b>\r\n<b>Fonctionnalités :</b>\r\n- Les utilisateurs peuvent consulter leur courrier électronique, leur calendrier et leurs contacts de pratiquement n''importe où à l''aide de leurs ordinateur, navigateur ou téléphone.\r\n- Des boîtes aux lettres de 25 Go par utilisateur s''intègrent en toute simplicité à Outlook.\r\n- Des pièces jointes d''une taille maximale de 25 Mo peuvent être envoyées.\r\n- Accédez à des outils de gestion en ligne simples d''utilisation qui vous permettent d''administrer les autorisations des utilisateurs et les paramètres des services, et de configurer la messagerie électronique sur votre propre domaine.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Antispam</span>\r\n\r\n<b>Face aux techniques en constante évolution déployées pour pénétrer les défenses existantes des entreprises, les menaces e-mail ne se limitent plus aux simples messages indésirables.</b>\r\n\r\nNotre solution Anti-Spam combine les meilleures techniques classiques avec la technologie révolutionnaire de détection contextuelle afin \r\nd’éliminer le plus large éventail de menaces e-mail connues ou émergentes.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Emailing de masse</span>\r\n\r\nL’e-mail, est l’un des moyens de communications des plus utilisé et est devenu incontournable ces dernières années.\r\nL’e-mail est utilisé tous les jours de différentes façons, tel que l’envoi de courrier, l’envoi de courrier avec de gros fichiers, l’envoi de newsletter, l’envoi d’e-mails publicitaires ou bien encore l’e-mail d’alerte, etc.\r\n\r\n<b>Avec nos serveurs d''emailing, Nous vous permettons d''envoyer tous vos emailing depuis votre logiciel de messagerie (ex: Outlook, Thunderbird) et de suivre leurs résultats grâce à l''outil de tracking associé et ce jusqu''à 100 000 par jour avec une simple ligne ADSL.</b>\r\n\r\n</p>', 'images/slide_04.jpg', 'images/solutions_wanamail.jpg', 'vous permet d’accéder à votre messagerie en tout lieu et de partager l’ensemble de vos fonctionnalités entre tous vos salariés !', '2013-06-21 08:55:36', 9),
(5, 'WanaStore', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Sauvegardez vos données stratégiques. Protéger les données qui garantissent la bonne marche de votre entreprise.</span>\r\n\r\nPlug-it propose une télé sauvegarde incrémentielle à l’octet via une simple ligne internet.\r\nAprès la sauvegarde initiale, Plug-it sauvegarde uniquement les morceaux de fichier nouveaux ou modifiés, économisant ainsi la bande passante et garantissant des sauvegardes ultérieures extrêmement rapides.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">À partir de 1 Go, nombre de poste illimité et coût maitrisé</span>\r\n</p>\r\n', 'images/slide_05.jpg', 'images/solutions_wanastore.jpg', 'vous offre une sauvegarde automatique et sécurisée à 100 % de toutes vos données, en toute sérénité...', '2013-06-21 09:08:51', 9),
(6, 'WanaBox', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Stocker l''ensemble de vos documents</span>\r\n\r\n- Disponible sur l''ensemble de vos ordinateurs.\r\n- Accessible sur toutes vos tablettes et smartphones.\r\n- Sauvegardes quotidiennes disponibles sur 45 jours.\r\n- Partagez vos données avec d''autres utilisateurs.\r\n- Travaillez en mode déconnecté sur vos documents.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">Des tarifs très attractifs selon chaque utilisation</span>\r\n<b>\r\n- Stockage jusqu''à 20 Go : 4,90 € HT par mois.\r\n- Stockage de 20 Go à 49 Go : 6,90 € HT par mois.\r\n- Stockage de 49 Go à 100 Go : 14,90 € HT par mois.\r\n</b>\r\n</p>\r\n', 'images/slide_06.jpg', 'images/solutions_wanabox.jpg', 'vous permet de stocker tous vos documents sur l''ensemble de vos ordinateurs, tablettes et smartphones !', '2013-06-21 09:13:55', 9),
(7, 'WanaShare', '<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">WanaShare est une plateforme de gestion de l''information et de collaboration professionnelle basée sur le produit Microsoft© SharePoint 2010 qui vous aide à améliorer votre productivité et à gérer votre contenu, \r\nen utilisant un navigateur Internet.</span>\r\n\r\nLes fonctionnalités intégrées de WanaShare, optimisées par des technologies d''indexation et de \r\nrecherche, vous permettent de vous adapter rapidement à l''évolution de vos besoins métier.\r\nVous pouvez ainsi prendre des décisions fondées sur des données métier consolidées et déployer des \r\napplications métiers de façon rapide et sécurisée afin de renforcer la collaboration dans et hors de votre\r\nentreprise.\r\n</p>\r\n<p>\r\n<img style="margin-right:10px;" src="images/fleche.png"/><span class="titre">WanaShare, pour quels usages ? WanaShare vous permet d''accroître la productivité via un ensemble intégré de\r\nfonctionnalités innovantes. Parmi elles, on peut citer :</span>\r\n\r\n- Accessibilité.\r\n- Affichage d''informations.\r\n- Prise en main de WSS 3.0.\r\n- Conservation de plusieurs versions de fichiers et d''éléments.\r\n- Création de sites, de listes et de bibliothèques.\r\n- Formules et fonctions.\r\n- Gestion de sites et de paramètres.\r\n- Intégration du courrier électronique aux sites, listes et bibliothèques.\r\n- Organisation de réunions.\r\n- Partage de fichiers et de documents.\r\n- Partage d''informations.\r\n- Personnalisation de sites, de pages, de listes et de bibliothèques.\r\n- Utilisation des environnements internationaux.\r\n- Utilisation des flux de travail pour gérer les processus.\r\n</p>', 'images/slide_07.jpg', 'images/solutions_wanashare.jpg', 'vous permet de gérer l’information en collaboration professionnelle, en utilisant juste un navigateur Internet.', '2013-06-21 09:19:48', 9);

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `nomcli` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `montant` int(11) NOT NULL,
  `societe` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `com` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code_retour` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
