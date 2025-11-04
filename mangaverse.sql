CREATE DATABASE mangaverse;

USE mangaverse;

CREATE TABLE manga (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genres VARCHAR(255) NOT NULL,
    status ENUM('Ongoing', 'Completed') NOT NULL,
    photo VARCHAR(255) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE chapters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    manga_id INT NOT NULL,
    chapter_number INT NOT NULL,
    chapter_title VARCHAR(255) NOT NULL,
    images_folder VARCHAR(255) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (manga_id) REFERENCES manga(id) ON DELETE CASCADE
);