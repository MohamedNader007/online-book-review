CREATE DATABASE IF NOT EXISTS book_reviews;
USE book_reviews;

DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS starred_books;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    cover_image VARCHAR(255),
    category VARCHAR(50) NOT NULL,
    amazon_link VARCHAR(255) NOT NULL
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    rating INT NOT NULL,
    review_text TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

CREATE TABLE starred_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    UNIQUE(user_id, book_id)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin and user with hashed passwords
-- admin: admin123 -> pre-hashed
-- john: john123 -> pre-hashed
INSERT INTO users (username, email, password_hash, role) VALUES 
('admin', 'admin@example.com','$2y$10$AxSxfw5mI0yZRcswog9cBOfMXUe9SfrzZKBfr34wWy5wraN/.X4ya', 'admin');
-- Sample books with Amazon links (replace amazon.com links as desired)
INSERT INTO books (title, author, description, cover_image, category, amazon_link)
VALUES
('The Great Gatsby', 'F. Scott Fitzgerald', 'A classic novel of the Jazz Age.', 'imgs/the great gatsby.jpg', 'Fiction', 'https://www.amazon.com/dp/0743273567'),
('To Kill a Mockingbird', 'Harper Lee', 'A story of racial injustice in the American South.', 'imgs/to kill a mocking bird.jpg', 'Fiction', 'https://www.amazon.com/dp/0061120081'),
('Dune', 'Frank Herbert', 'Epic science fiction on the desert planet Arrakis.', 'imgs/dune.jpg', 'Sci-Fi', 'https://www.amazon.com/dp/0441013597'),
('1984', 'George Orwell', 'A dystopian future under total surveillance.', 'imgs/1984.jpg', 'Sci-Fi', 'https://www.amazon.com/dp/0451524934'),
('Pride and Prejudice', 'Jane Austen', 'Romantic story in 19th-century England.', 'imgs/pride.jpg', 'Fiction', 'https://www.amazon.com/dp/1503290565'),
('The Hobbit', 'J.R.R. Tolkien', 'A fantasy adventure in Middle-earth.', 'imgs/hobbit.jpg', 'Fantasy', 'https://www.amazon.com/dp/054792822X'),
('Sapiens', 'Yuval Noah Harari', 'A brief history of humankind.', 'imgs/sapiens.jpg', 'Non-Fiction', 'https://www.amazon.com/dp/0062316095'),
('قصة حياة بشمهندسة سارة', 'Sara Said', 'الكتاب دا بيحكي قصة حياة بشمهندسة سارة ', 'imgs/moon.jpg', 'Biography', 'https://www.amazon.com/dp/0062316095'),
('The Da Vinci Code', 'Dan Brown', 'A mystery thriller about art and religion.', 'imgs/davinci.jpg', 'Mystery', 'https://www.amazon.com/dp/0307474275');



