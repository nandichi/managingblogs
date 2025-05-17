-- Creëer database als deze nog niet bestaat
CREATE DATABASE IF NOT EXISTS managingblogs;
USE managingblogs;

-- Verwijder bestaande tabellen om schoon te beginnen
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS categories;

-- Tabel voor categorieën
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel voor gebruikers
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255) DEFAULT NULL,
    is_admin BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel voor blogposts
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    category_id INT NOT NULL,
    featured_image VARCHAR(255),
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel voor reacties
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Voorbeelddata invoegen
-- Categorieën
INSERT INTO categories (name) VALUES 
('Nieuws'),
('Wedstrijdverslagen'),
('Analyse'),
('Transfers'),
('Interviews');

-- Gebruikers (wachtwoord: "welkom123" voor beide gebruikers)
INSERT INTO users (username, email, password_hash, is_admin) VALUES
('admin', 'admin@managingblogs.nl', '$2y$10$O8PV5AJVU1xnPCN6HZCud.MzUc/HhZ1v3lJd8gJd9LgMstwdwq3vy', 1),
('gebruiker', 'gebruiker@managingblogs.nl', '$2y$10$O8PV5AJVU1xnPCN6HZCud.MzUc/HhZ1v3lJd8gJd9LgMstwdwq3vy', 0);

-- Blogposts
INSERT INTO posts (title, content, author_id, category_id, featured_image) VALUES
('Benzema keert terug naar Real Madrid als teamambassadeur', 'Real Madrid heeft aangekondigd dat Karim Benzema zal terugkeren naar de club als officiële teamambassadeur. De Franse spits, die vorig seizoen naar Saudi-Arabië vertrok, zal een ceremoniële rol vervullen en de club vertegenwoordigen bij verschillende evenementen.\n\nBenzema speelde 14 seizoenen voor Los Blancos en won vijf Champions League-titels.', 1, 1, 'uploads/benzema.jpg'),
('WEDSTRIJDVERSLAG: Real Madrid 3-0 Barcelona', 'Real Madrid versloeg rivaal Barcelona met 3-0 in een indrukwekkende El Clásico. Vinicius Jr. opende de score in de 23e minuut met een prachtige solo-actie, gevolgd door doelpunten van Rodrygo en Bellingham in de tweede helft.\n\nDe overwinning verstevigt Madrids positie aan de top van La Liga.', 1, 2, 'uploads/clasico.jpg'),
('Analyse: Hoe Ancelotti het middenveld heeft getransformeerd', 'Carlo Ancelotti heeft het middenveld van Real Madrid volledig veranderd na het vertrek van Casemiro, Kroos en Modric. Met jonge talenten als Camavinga, Tchouaméni en de ervaren Valverde heeft hij een nieuwe dynamiek gecreëerd.\n\nIn deze analyse bekijken we de statistieken en tactieken die deze transformatie mogelijk hebben gemaakt.', 2, 3, 'uploads/midfield.jpg'),
('EXCLUSIEF: Real Madrid toont interesse in Nederlandse verdediger', 'Volgens bronnen dicht bij de club heeft Real Madrid interesse getoond in een opkomende Nederlandse verdediger. De 21-jarige speler heeft indruk gemaakt in de Eredivisie en wordt gezien als een potentiële versterking voor de toekomst.\n\nMadrid zou al contact hebben opgenomen met zijn vertegenwoordigers.', 1, 4, 'uploads/transfer.jpg'),
('Interview met Nacho: "Madrid zit in mijn hart"', 'In een exclusief interview sprak clublegende Nacho over zijn carrière bij Real Madrid. "Deze club zit in mijn hart en ik kan me geen leven voorstellen zonder Real Madrid," vertelde de verdediger.\n\nHij besprak ook de overgang van de oude garde naar de nieuwe generatie spelers en zijn rol als teamcaptain.', 2, 5, 'uploads/nacho.jpg');

-- Reacties
INSERT INTO comments (post_id, user_id, content) VALUES
(1, 2, 'Geweldig nieuws! Benzema is een echte legende van de club.'),
(1, 1, 'Een perfecte rol voor hem na zo\'n geweldige carrière bij Madrid.'),
(2, 2, 'Wat een wedstrijd! Vinicius was ongelooflijk!'),
(2, 1, 'Barcelona had geen antwoord op onze aanval. Hala Madrid!'),
(3, 2, 'Ancelotti bewijst weer waarom hij een van de beste coaches ter wereld is.'),
(3, 1, 'Interessante analyse. Ik denk dat Valverde de sleutel is tot dit succes.'),
(4, 2, 'Ik hoop dat we hem halen, we hebben versterking nodig in de verdediging.'),
(4, 1, 'Spannend! Wie zou het kunnen zijn?'),
(5, 2, 'Nacho is het perfecte voorbeeld van loyaliteit aan een club.'),
(5, 1, 'Hij verdient meer erkenning voor alles wat hij voor Madrid heeft gedaan.'); 