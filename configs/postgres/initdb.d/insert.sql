INSERT INTO users(name, email, password, profile_resource_id) VALUES ( 'hoge', 'hoge@example.com', 'hoge', '1');
INSERT INTO users(name, email, password, profile_resource_id) VALUES ('fuga', 'fuga@example.com', 'fuga', '2');
INSERT INTO articles(user_id, thumbnail_image_id, title, body) VALUES (1, 1, 'ラーメン食べたい', 'うどんが正義');
INSERT INTO articles(user_id, thumbnail_image_id, title, body) VALUES (1, 2, 'やっぱりそば', '屋台の焼きそばはうまい');

INSERT INTO tags (name) VALUES
    ('総合'),
    ('テクノロジー'),
    ('モバイル'),
    ('アプリ'),
    ('エンタメ'),
    ('ビューティー'),
    ('ファッション'),
    ('ライフスタイル'),
    ('ビジネス'),
    ('グルメ'),
    ('スポーツ');
