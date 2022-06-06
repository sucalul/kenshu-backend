CREATE FUNCTION set_updated_at() RETURNS OPAQUE AS '
    begin
        new.updated_at := ''now'';
        return new;
    end;
' LANGUAGE plpgsql;

CREATE TABLE users
(
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_resource_id VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 更新時のトリガーを作成
CREATE TRIGGER update_tri_users BEFORE UPDATE ON users FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

CREATE TABLE articles
(
    id SERIAL NOT NULL PRIMARY KEY,
    user_id INT NOT NULL,
    thumbnail_image_id INT, -- nullable
    title VARCHAR(100) NOT NULL,
    body text NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) on DELETE CASCADE
);

-- 更新時のトリガーを作成
CREATE TRIGGER update_tri_articles BEFORE UPDATE ON articles FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

CREATE TABLE article_images
(
    id SERIAL NOT NULL PRIMARY KEY,
    article_id INT NOT NULL,
    resource_id VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles (id) on DELETE CASCADE
);

-- 更新時のトリガーを作成
CREATE TRIGGER update_tri_article_images BEFORE UPDATE ON article_images FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

CREATE TABLE tags
(
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 更新時のトリガーを作成
CREATE TRIGGER update_tri_tags BEFORE UPDATE ON tags FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

CREATE TABLE article_tags
(
    article_id INT NOT NULL,
    tag_id INT NOT NULL,
    FOREIGN KEY (article_id) REFERENCES articles (id) on DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags (id) on DELETE CASCADE,
    PRIMARY KEY(article_id, tag_id)
);

CREATE INDEX ON article_tags (tag_id);
