--  --------------------------------------------------------
--
--  Insert Category value
--
INSERT INTO
    `categories`(`id`, `name`)
VALUES
    (1, 'Basketball Shoes'),
    (2, 'Running Shoes'),
    (3, 'Tennis Shoes'),
    (4, 'Trail Running Shoes'),
    (5, 'Walking Shoes');

-- --------------------------------------------------------
--
--  Insert Product value
--
--  NOTE: This is mockery database, we will use real database when we deploy
--
--
INSERT INTO
    `products`(
        `id`,
        `name`,
        `category_id`,
        `price`,
        `description`,
        `image`,
        `gender`
    )
VALUES
    (
        1,
        'Nike Air Zoom Pegasus 37',
        1,
        200,
        'Running shoe with cushioning',
        'pegasus.jpg',
        '1'
    ),
    (
        2,
        'Adidas Ultraboost',
        1,
        150,
        'Basketball shoe with cushioning',
        'ultraboost.jpg',
        '1'
    ),
    (
        3,
        'Asics Gel-Kayano 27',
        1,
        120,
        'Basketball shoe with cushioning',
        'gel-kayano.jpg',
        '1'
    ),
    (
        4,
        'New Balance Fresh Foam 1080v10',
        2,
        80,
        'Running shoe with foam',
        'fresh-foam.jpg',
        '1'
    ),
    (
        5,
        'Brooks Launch 5',
        2,
        100,
        'Running shoe with cushioning',
        'launch.jpg',
        '1'
    ),
    (
        6,
        'Nike Air Max 270',
        2,
        120,
        'Running shoe with cushioning',
        'air-max.jpg',
        '1'
    ),
    (
        7,
        'Asics Gel-Lyte 27',
        2,
        100,
        'Running shoe with cushioning',
        'gel-lyte.jpg',
        '1'
    ),
    (
        8,
        'New Balance Fresh Foam 990v10',
        3,
        90,
        'Running shoe with foam',
        'fresh-foam-tennis.jpg',
        '1'
    ),
    (
        9,
        'Adidas Stan Smith',
        3,
        80,
        'Tennis shoe',
        'stan-smith.jpg',
        '1'
    ),
    (
        10,
        'Nike Air Zoom Pegasus 38',
        1,
        220,
        'Running shoe with cushioning',
        'pegasus-38.jpg',
        '1'
    ),
    (
        11,
        'Puma Suede',
        2,
        130,
        'Basketball shoe with suede',
        'suede.jpg',
        '1'
    ),
    (
        12,
        'Asics Gel-Nimbus 29',
        2,
        110,
        'Basketball shoe with cushioning',
        'gel-nimbus.jpg',
        '1'
    ),
    (
        13,
        'New Balance Fresh Foam 890v10',
        3,
        70,
        'Running shoe with foam',
        'fresh-foam-890.jpg',
        '1'
    ),
    (
        14,
        'Brooks Launch 4',
        3,
        90,
        'Running shoe with cushioning',
        'launch-4.jpg',
        '1'
    ),
    (
        15,
        'Nike Air Max 270',
        3,
        130,
        'Running shoe with cushioning',
        'air-max-tennis.jpg',
        '1'
    ),
    (
        16,
        'Asics Gel-Kayano 28',
        3,
        100,
        'Tennis shoe with cushioning',
        'gel-kayano-28.jpg',
        '1'
    ),
    (
        17,
        'New Balance Fresh Foam 1190v10',
        4,
        100,
        'Running shoe with foam',
        'fresh-foam-1190.jpg',
        '1'
    ),
    (
        18,
        'Brooks Launch 6',
        4,
        110,
        'Running shoe with cushioning',
        'launch-6.jpg',
        '1'
    ),
    (
        19,
        'Nike Air Zoom Pegasus 39',
        4,
        230,
        'Running shoe with cushioning',
        'pegasus-39.jpg',
        '1'
    ),
    (
        20,
        'Puma Suede',
        5,
        90,
        'Walking shoe with suede',
        'suede-walking.jpg',
        '1'
    ),
    (
        21,
        'Asics Gel-Nimbus 29',
        5,
        120,
        'Walking shoe with cushioning',
        'gel-nimbus-29-walking.jpg',
        '1'
    ),
    (
        22,
        'New Balance Fresh Foam 895v10',
        5,
        60,
        'Walking shoe with foam',
        'fresh-foam-895.jpg',
        '1'
    ),
    (
        23,
        'Brooks Launch 7',
        5,
        80,
        'Walking shoe with cushioning',
        'launch-7.jpg',
        '1'
    ),
    (
        24,
        'Nike Air Max 270',
        5,
        150,
        'Walking shoe with cushioning',
        'air-max-270-walking.jpg',
        '1'
    );
