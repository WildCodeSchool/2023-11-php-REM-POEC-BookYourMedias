<?php

require 'vendor/autoload.php';
if (file_exists('config/db.php')) {
    require 'config/db.php';
} else {
    require 'config/db.php.dist';
}

require 'config/config.php';

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . '; charset=utf8',
        DB_USER,
        DB_PASSWORD
    );

    $pdo->exec('DROP DATABASE IF EXISTS ' . DB_NAME);
    $pdo->exec('CREATE DATABASE ' . DB_NAME);
    $pdo->exec('USE ' . DB_NAME);
    $pdo->exec('CREATE TABLE user (id INT PRIMARY KEY AUTO_INCREMENT, 
    adresse_email VARCHAR(255) NOT NULL, 
    mot_de_passe VARCHAR(255), 
    pseudo VARCHAR(45)  NOT NULL, 
    role BOOLEAN NULL)');
    $pdo->exec('CREATE TABLE emprunt (id INT PRIMARY KEY AUTO_INCREMENT,
    date_emprunt DATE,
    date_retour DATE,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id))');
    $pdo->exec('CREATE TABLE auteur (id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NULL)');
    $pdo->exec('CREATE TABLE categorie (id INT PRIMARY KEY AUTO_INCREMENT,
    name_categorie VARCHAR(100))');

    $pdo->exec('CREATE TABLE medias (id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(150) NOT NULL,
    published_date DATE,
    description_media VARCHAR(6000) NOT NULL,
    image_couverture VARCHAR(5000) NOT NULL,
    lien_extrait VARCHAR(5000)NOT NULL,
    disponible BOOLEAN NULL,
    id_categorie INT,
    id_user INT,
    id_auteur INT,
    id_emprunt INT,
    FOREIGN KEY (id_categorie) REFERENCES categorie(id),
    FOREIGN KEY (id_emprunt) REFERENCES emprunt(id),
    FOREIGN KEY (id_user) REFERENCES user(id),
    FOREIGN KEY (id_auteur) REFERENCES auteur(id))');

    // $pdo->exec('CREATE TABLE medias (id INT PRIMARY KEY AUTO_INCREMENT, titre VARCHAR(150) NOT NULL, published_date DATE)');

    $pdo->exec('ALTER TABLE emprunt ADD COLUMN medias_id INT NOT NULL');
    $pdo->exec('ALTER TABLE emprunt ADD FOREIGN KEY (medias_id) REFERENCES medias(id)');

    //ajouter des INSERT INTO pour les données à afficher

    $pdo->exec("INSERT INTO auteur (name) VALUES 
    ('C.S Lewis'),
    ('J.K Rowling'),
    ('Luis Sepulveda'),
    ('Franz-Olivier Giesbert'),
    ('Eiichiro Oda'),
    ('J. R. R. Tolkien'),
    ('Victor Hugo'),
    ('Masaki Kobayashi'),
    ('Martin Scorsese'),
    ('Christopher Nolan'),
    ('Akira Kurosa'),
    ('Francis Ford Coppola'),
    ('Shigeaki Kubo'),
    ('Bong Joon-ho'),
    ('David Yates'),
    ('Quentin Tarantino'),
    ('Tim Burton'),
    ('Guy Ritchie'),
    ('Prachya Pinkaew'),
    ('Slowdive'),
    ('Life Of Agony'),
    ('One Direction'),
    ('Hamza'),
    ('Sufjan Steven'),
    ('Lil Yachty')");

    $pdo->exec("INSERT INTO categorie (name_categorie) VALUES 
    ('livre'),
    ('film'),
    ('album')");

    //la requête ci-dessous fonctionne
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Le Monde de Narnia','2010-09-11','Retrouvez, réunis en un seul ouvrage, les sept volumes du Monde de Narnia, l\'oeuvre de CS. Lewis :  Le Neveu du magicien, Le Lion, la Sorcière Blanche et l\'Armoire magique, Le Cheval et son écuyer, Le Prince Caspian, L\'Odyssée du Passeur d\'Aurore, 6- Le Fauteuil d\'argent, La Dernière Bataille. Guidés par le Lion Aslan, découvrez dans son intégralité la saga fantastique du grand romancier, ami de Tolkien.', 'https://m.media-amazon.com/images/I/91u4fEsre2L._SL1500_.jpg', 'https://fr.wikipedia.org/wiki/Le_Monde_de_Narnia', 1, 1, 1)");

    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Harry Potter et le Prisonnier d\'Azkaban','1999-07-08','Sirius Black, le dangereux criminel qui s\'est échappé de la forteresse d\'Azkaban, recherche Harry Potter. C\'est donc sous bonne garde que l\'apprenti sorcier fait sa troisième rentrée. Au programme : des cours de divination, la fabrication d\'une potion de Ratatinage, le dressage des hippogriffes... Mais Harry est-il vraiment à l\'abri du danger qui le menace? Le troisième tome des aventures de Harry Potter vous emportera dans un tourbillon de surprises et d\'émotions.', 'https://m.media-amazon.com/images/I/71YT20-TsvL._AC_UF1000,1000_QL80_.jpg', 'https://www.google.fr/books/edition/Harry_Potter_et_le_Prisonnier_d_Azkaban/vWxokFDTpy4C?hl=fr&gbpv=1&printsec=frontcover', 1, 1, 2)");

    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Dernières nouvelles du Sud', '2012-04-19', 'Nous sommes partis un jour vers le sud du monde pour voir ce qu\'on allait y trouver. Notre itinéraire était très simple: pour des raisons de logistique, le voyage commençait à San Carlos de Bariloche puis, à partir du 42e Parallèle, nous descendions jusqu\'au Cap Horn, toujours en territoire argentin, et revenions par la Patagonie chilienne jusqu\'à la grande île de Chiloé, soit quatre mille cinq cents kilomètres environ. Mais, tout ce que nous avons vu, entendu, senti, mangé et bu à partir du moment où nous nous sommes mis en route, nous a fait comprendre qu\'au bout d\'un mois nous aurions tout juste parcouru une centaine de kilomètres. Sur chacune des histoires passe sans doute le souffle des choses inexorablement perdues, cet inventaire des pertes dont parlait Osvaldo Soriano, coût impitoyable de notre époque. Pendant que nous étions sur la route, sans but précis, sans limite de temps, sans boussole et sans tricheries, cette formidable mécanique de la vie qui permet toujours de retrouver les siens nous a amenés à rencontrer beaucoup de ces barbares dont parle Konstantinos Kavafis. Quelques semaines après notre retour en Europe, mon socio, mon associé, m\'a remis un dossier bourré de superbes photos tirées en format de travail et on n\'a plus parlé du livre. Drôles d\'animaux que les livres. Celui-ci a décidé de sa forme finale il y a quatre ans : nous volions au-dessus du détroit de Magellan dans un fragile coucou ballotté par le vent, le pilote pestait contre les nuages qui l\'empêchaient de voir où diable se trouvait la piste d\'atterrissage et les points cardinaux étaient une référence absurde, c\'est alors que mon socio m\'a signalé qu\'il y avait, là en bas, quelques-unes des histoires et des photos qui nous manquaient', 'https://editions-metailie.com/wp-content/uploads/couvHDjpg/dernieres%20nouvelles%20du%20sud-300x460.jpg', 'https://www.google.fr/books/edition/Derni%C3%A8res_nouvelles_du_Sud/ENDXDwAAQBAJ?hl=fr&gbpv=1&printsec=frontcover', 1, 1, 3)");

    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Histoire intime de la Vᵉ République', '2020-09-15', 'Plongez dans les coulisses de la Vᵉ République française avec notre récit captivant qui explore les moments clés, les intrigues politiques et les personnages influents de cette période. De la naissance du régime avec le général de Gaulle à ses évolutions et défis contemporains, nous dévoilons les dessous de la politique française. À travers des témoignages exclusifs, des anecdotes surprenantes et des archives inédites, ce livre offre une perspective intime sur l\'histoire récente de la France. Des coulisses de l\'Élysée aux débats houleux à l\'Assemblée nationale, plongez au cœur des décennies qui ont façonné la nation. L\'auteur, passionné par la politique et fin observateur des arcanes du pouvoir, livre ici une analyse approfondie et accessible de cette période complexe et fascinante de l\'histoire française.', 'Franz-Olivier Giesbert', 'https://www.livresenfamille.fr/xx/23585-franz-olivier-giesbert-histoire-intime-de-la-ve-republique-tome-1-le-sursaut.html', 1, 1, 4)");

    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('One Piece - Tome 106', '2023-06-12', 'Découvrez le dernier opus de la célèbre saga One Piece avec le Tome 106. Embarquez aux côtés de Luffy et de son équipage pour de nouvelles aventures palpitantes, de mystères dévoilés et de combats épiques. Ce tome promet des rebondissements inattendus qui tiendront en haleine les fans de la série. Explorez de nouveaux territoires, affrontez de redoutables ennemis et plongez dans l\'univers riche et captivant créé par Eiichiro Oda.', 'https://static.fnac-static.com/multimedia/PE/Images/FR/NR/b2/37/ee/15611826/1507-1/tsp20231207090257/One-Piece-Edition-originale-Tome-106.jpg', 'https://www.fnac.com/a18235279/One-Piece-One-Piece-Edition-originale-Tome-106-Eiichiro-Oda', 1, 1, 5)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Le Seigneur des Anneaux - La Fraternité de l\'Anneau Tome 1', '2019-10-03', 'Plongez dans l\'univers fantastique de J.R.R. Tolkien avec le premier tome du Seigneur des Anneaux, La Fraternité de l\'Anneau. Suivez Frodo Baggins dans sa quête périlleuse pour détruire l\'Anneau Unique et sauver la Terre du Milieu du mal. Ce chef-d\'œuvre de la littérature fantastique vous transporte dans un monde épique rempli de créatures mythiques, d\'amitiés indéfectibles et de batailles épiques entre le bien et le mal.', 'https://m.media-amazon.com/images/I/81bllplMK3L._SL1500_.jpg', 'https://www.amazon.fr/SEIGNEUR-ANNEAUX-FRATERNITE-LANNEAU/dp/2075134049', 1, 1, 6)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Les Misérables', '1890-01-01', 'Plongez dans le chef-d\'œuvre intemporel de Victor Hugo avec Les Misérables. Suivez l\'histoire poignante de Jean Valjean, de Fantine, de Cosette et des autres personnages inoubliables dans le contexte de la France du XIXe siècle. Cette épopée sociale explore des thèmes universels tels que la justice, l\'amour et la rédemption, et continue de toucher les lecteurs du monde entier.', 'lien_de_l_image', 'https://www.google.fr/books/edition/Les_mis%C3%A9rables/wzDr2I8DWMAC?hl=fr&gbpv=1&pg=PP9&printsec=frontcover', 1, 1, 7)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Harakiri', '2006-12-06', 'Explorez le drame intense et les codes d\'honneur samouraïs avec le film Harakiri. Réalisé par Masaki Kobayashi, ce chef-d\'œuvre cinématographique japonais offre une réflexion profonde sur la loyauté, le sacrifice et la dignité. Plongez dans l\'histoire captivante d\'un rōnin déterminé à défier les normes sociales et à révéler la vérité cachée derrière les apparences.', 'https://fr.shopping.rakuten.com/photo/876843204.jpg', 'https://laboutique.carlottafilms.com/products/harakiri-de-masaki-kobayashi', 1, 2, 8)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Shutter Island', '2010-02-24', 'Explorez les mystères psychologiques de Shutter Island, un thriller captivant réalisé par Martin Scorsese. Plongez dans l\'intrigue complexe d\'enquêteurs confrontés à des énigmes troublantes sur une île psychiatrique isolée. Avec des retournements de situation inattendus, ce film offre une expérience cinématographique immersive et haletante.', 'https://m.media-amazon.com/images/I/916VtXkyrHL._AC_UF1000,1000_QL80_.jpg', 'https://www.youtube.com/watch?v=Hz0ToXuAxag', 1, 2, 9)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Le Prestige', '2006-11-15', 'Plongez dans le monde du mystère et de l\'illusion avec Le Prestige, un film réalisé par Christopher Nolan. Suivez l\'affrontement entre deux magiciens rivaux, interprétés par Hugh Jackman et Christian Bale, alors qu\'ils rivalisent pour créer le tour ultime. Avec des rebondissements inattendus, ce thriller explore les thèmes de l\'obsession et de la rivalité.', 'https://www.youtube.com/watch?v=6L9ZAH09En4', 'https://www.youtube.com/watch?v=6L9ZAH09En4', 1, 2, 10)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Seven Samuraï', '1955-11-30', 'Découvrez le classique du cinéma japonais avec Seven Samuraï, réalisé par Akira Kurosawa. Ce film épique suit un groupe de samouraïs engagés pour défendre un village contre des bandits. Avec des scènes de bataille mémorables et des personnages complexes, cette œuvre a influencé de nombreux films ultérieurs et continue de captiver les cinéphiles du monde entier.', 'https://fr.web.img4.acsta.net/pictures/210/081/21008198_20130524165225146.png', 'https://www.youtube.com/watch?v=KJmVK4EUbgU', 1, 2, 11)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Le Parrain', '1972-10-18', 'Plongez dans l\'univers impitoyable de la mafia avec The Godfather, réalisé par Francis Ford Coppola. Basé sur le roman de Mario Puzo, ce film emblématique suit la famille Corleone et leur patriarche, interprété par Marlon Brando. Avec des performances mémorables et une histoire de pouvoir, de famille et de trahison, The Godfather demeure un classique du cinéma.', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.imdb.com%2Ftitle%2Ftt0068646%2F&psig=AOvVaw2MvhNn5z3z2dPzJr6YAIpD&ust=1703171131514000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCICA6YqlnoMDFQAAAAAdAAAAABAD', 'https://www.youtube.com/watch?v=bmtuIhesQWA', 1, 2, 12)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('High and Low', '2016-07-16', 'Explorez les nuances morales et sociales avec le film japonais High and Low, réalisé par Akira Kurosawa. Ce drame policier captivant explore les conséquences d\'un enlèvement qui met en lumière les disparités entre les classes sociales. Avec une narration complexe et des performances remarquables, ce film offre une réflexion profonde sur la nature humaine.', 'https://www.nautiljon.com/images/asian-movie/00/96/high_low_the_movie_2669.webp', 'https://www.youtube.com/watch?v=fQHStGrqXv0', 1, 2, 13)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Parasite', '2019-05-21', 'Découvrez le film sud-coréen récompensé aux Oscars, Parasite, réalisé par Bong Joon-ho. Cette œuvre cinématographique novatrice explore les tensions sociales à travers l\'histoire d\'une famille qui infiltre la vie d\'une famille fortunée.', 'lien_de_l_image', 'https://www.youtube.com/watch?v=-Yo_lxZ6Z0k', 1, 2, 14)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Les Animaux Fantastiques - Le Secret de Dumbledore', '2022-04-06', 'Plongez dans l\'univers magique de J.K. Rowling avec Les Animaux Fantastiques - Le Secret de Dumbledore. Suivez les aventures du sorcier Norbert Dragonneau dans cette nouvelle itération de la franchise. Avec des créatures magiques, des mystères et des enjeux élevés, ce film transporte les spectateurs dans le monde ensorcelant de la magie.', 'https://fr.web.img6.acsta.net/c_310_420/pictures/22/03/16/15/20/0170262.jpg', 'https://www.youtube.com/watch?v=VkiwSNPxDg4', 1, 2, 15)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Django Unchained', '2013-01-16', 'Explorez le Far West brutal et esclavagiste avec Django Unchained, réalisé par Quentin Tarantino. Ce western spaghetti contemporain suit Django, un esclave affranchi, et un chasseur de primes allemand alors qu\'ils entreprennent une mission pour sauver la femme de Django des griffes d\'un impitoyable planteur. Avec un mélange unique d\'action, d\'humour noir et de commentaires sociaux, le film a remporté plusieurs récompenses, dont des Oscars, pour ses performances exceptionnelles et sa réalisation visionnaire.', 'https://fr.web.img6.acsta.net/medias/nmedia/18/90/08/59/20366454.jpg', 'https://www.youtube.com/watch?v=K2XjgsfzDrU', 1, 2, 16)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Alice au Pays des Merveilles', '2010-03-03', 'Explorez une version visuellement époustouflante du Pays des Merveilles avec Alice au Pays des Merveilles réalisé par Tim Burton. Ce film combine habilement le style distinctif de Burton avec l\'histoire classique de Lewis Carroll. Suivez Alice, interprétée par Mia Wasikowska, dans son voyage fantastique rempli de personnages excentriques, de créatures magiques et d\'aventures étranges. Avec des effets visuels éblouissants et une interprétation captivante, le film offre une expérience cinématographique unique.', 'https://www.youtube.com/watch?v=c4ais9sftFE', 'https://www.youtube.com/watch?v=c4ais9sftFE', 1, 2, 17)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Charlie et la Chocolaterie', '2005-07-13', 'Plongez dans l\'usine de chocolat de Willy Wonka avec Charlie et la Chocolaterie, réalisé par Tim Burton. Basé sur le livre de Roald Dahl, ce film met en scène Johnny Depp dans le rôle emblématique de Willy Wonka. Suivez Charlie Bucket dans cette aventure sucrée et imaginative.', 'https://img.fruugo.com/product/2/70/14509702_max.jpg', 'https://www.youtube.com/watch?v=xjZihSC42HI', 1, 2, 17)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Aladdin', '2019-05-08', 'Retrouvez l\'un des contes classiques des Mille et Une Nuits avec la version live-action de Aladdin, réalisée par Guy Ritchie. Vivez les aventures d\'Aladdin, Jasmine et du génie dans cette adaptation magique et visuellement époustouflante.', 'https://images-1.rakuten.tv/storage/global-movie/translation/artwork/6f0804c8-94bf-446c-b862-8e8bfe3001e9-aladdin-2019-1611326615.jpeg', 'https://www.youtube.com/watch?v=IrzzGm3AmLg', 1, 2, 18)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Everything is Alive', '2023-09-01', 'Slowdive \'everything is alive\' Opaque Gold Vinyl w/ Limited Edition artwork. Vinyl images by Anna Powell Denton', 'https://www.slowdiveofficial.com/wp-content/uploads/2023/09/EUROPEAN-UK-TOUR-2024-1.png', 'https://www.youtube.com/watch?v=Zpkymhh70U4', 1, 3, 20)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Ugly', '1995-10-10', 'Ugly est le deuxième album studio du groupe de metal alternatif new-yorkais, Life of Agony. Il est sorti le 10 octobre 1995 sur le label Roadrunner Records et a été produit par Steve Thompson. ', 'https://upload.wikimedia.org/wikipedia/en/thumb/e/ef/Life_of_Agony-Ugly.jpg/220px-Life_of_Agony-Ugly.jpg', 'https://www.youtube.com/watch?v=RhrbN5gIS34&list=PLLy1F0NPv5gpfwX1_rz5TXg6VynbCiBN1', 1, 3, 21)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Take Me Home', '2012-11-09', 'Take Me Home est le deuxième album studio du boys band anglo-irlandais One Direction, sorti le 9 novembre 2012 sous le label de Sony Music Entertainment.', 'https://m.media-amazon.com/images/I/61vhVfkE0ZL._UF1000,1000_QL80_.jpg', 'https://www.youtube.com/watch?v=3b_1Ghiuovo', 1, 3, 22)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Four', '2014-11-17', 'Four est le quatrième album studio du boys band anglo-irlandais One Direction, sorti le 17 novembre 2014 par Columbia Records et Syco Musique. Il se nomme Four car c\'est le quatrième album du groupe depuis X Factor.', 'https://m.media-amazon.com/images/I/81jKxoq-KcL._UF1000,1000_QL80_.jpg', 'https://www.youtube.com/watch?v=bnc_SiQXS28', 1, 3, 22)");
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('Javelin', '2023-10-06','Javelin est le dixième album studio du musicien américain Sufjan Stevens. Il est sorti le 6 octobre 2023 via Asthmatic Kitty. Il a été largement salué par la critique et a été nommé l\'un des meilleurs albums de 2023 par de nombreuses publications.', 'https://modulor-records.com/wp-content/uploads/0729920165896.jpg', 'https://www.youtube.com/watch?v=LqLflZ3EOQ0', 1, 3, 24)");
   
    $pdo->exec("INSERT INTO medias (titre, published_date, description_media, image_couverture, lien_extrait, disponible, id_categorie, id_auteur) VALUES 
    ('let\'s start Here', '2023-01-27', 'Commençons ici est le cinquième album studio du musicien américain Lil Yachty, sorti le 27 janvier 2023 via Motown Records et Quality Control Music. Il s\'agit de son premier album studio depuis Lil Boat 3 et fait suite à sa mixtape 2021 Michigan Boy Boat.', 'https://preview.redd.it/alternate-lets-start-here-album-cover-by-me-v0-o0c3ws3tqnra1.jpg?width=640&crop=smart&auto=webp&s=7f0f2ce0e3f4fd7a84b00ee238205f0cf22ce327', 'https://www.youtube.com/playlist?list=PLxA687tYuMWjAPWGQLKs5fHMGz_mvRlTz', 1, 3, 25)");



    if (is_file(DB_DUMP_PATH) && is_readable(DB_DUMP_PATH)) {
        $sql = file_get_contents(DB_DUMP_PATH);
        $statement = $pdo->prepare($sql);
        $statement->execute();
    } else {
        echo DB_DUMP_PATH . ' file does not exist';
    }
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
