DROP TABLE IF EXISTS quotes;
DROP TABLE IF EXISTS authors;
DROP TABLE IF EXISTS categories;

CREATE TABLE authors (
    id SERIAL PRIMARY KEY,
    author VARCHAR(255) NOT NULL
);

CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    category VARCHAR(255) NOT NULL
);

CREATE TABLE quotes (
    id SERIAL PRIMARY KEY,
    quote TEXT NOT NULL,
    author_id INT NOT NULL REFERENCES authors(id),
    category_id INT NOT NULL REFERENCES categories(id)
);

-- Authors (7 authors, id 5 = Winston Churchill)
INSERT INTO authors (author) VALUES
('Albert Einstein'),
('Mark Twain'),
('Oscar Wilde'),
('Maya Angelou'),
('Winston Churchill'),
('Mahatma Gandhi'),
('Martin Luther King Jr.');

-- Categories (7 categories, id 4 = Wisdom)
INSERT INTO categories (category) VALUES
('Inspiration'),
('Life'),
('Humor'),
('Wisdom'),
('Love'),
('Success'),
('Leadership');

-- Quotes (27 total)
INSERT INTO quotes (quote, author_id, category_id) VALUES
('Imagination is more important than knowledge.', 1, 4),
('Life is what happens when you are busy making other plans.', 1, 2),
('The secret of getting ahead is getting started.', 2, 1),
('If you tell the truth, you do not have to remember anything.', 2, 4),
('Be yourself; everyone else is already taken.', 3, 2),
('To live is the rarest thing in the world. Most people exist, that is all.', 3, 2),
('There is no greater agony than bearing an untold story inside you.', 4, 1),
('We delight in the beauty of the butterfly, but rarely admit the changes it has gone through to achieve that beauty.', 4, 2),
('Success is not final, failure is not fatal: it is the courage to continue that counts.', 5, 4),
('The best time to plant a tree was 20 years ago. The second best time is now.', 6, 1),
('The pessimist sees difficulty in every opportunity. The optimist sees opportunity in every difficulty.', 5, 4),
('Be the change that you wish to see in the world.', 6, 1),
('In the end, it is not the years in your life that count. It is the life in your years.', 1, 2),
('Darkness cannot drive out darkness; only light can do that. Hate cannot drive out hate; only love can do that.', 7, 1),
('The time is always right to do what is right.', 7, 7),
('Love is the only force capable of transforming an enemy into a friend.', 7, 5),
('An eye for an eye only ends up making the whole world blind.', 6, 4),
('Keep your face always toward the sunshine and shadows will fall behind you.', 4, 1),
('I have not failed. I have just found 10,000 ways that will not work.', 1, 6),
('Get your facts first, then you can distort them as you please.', 2, 3),
('Experience is simply the name we give our mistakes.', 3, 4),
('To love oneself is the beginning of a lifelong romance.', 3, 5),
('You will face many defeats in life, but never let yourself be defeated.', 4, 1),
('We make a living by what we get, but we make a life by what we give.', 5, 2),
('The future belongs to those who believe in the beauty of their dreams.', 6, 1),
('Courage is what it takes to stand up and speak; courage is also what it takes to sit down and listen.', 5, 7),
('Always do right. This will gratify some people and astonish the rest.', 2, 3);
