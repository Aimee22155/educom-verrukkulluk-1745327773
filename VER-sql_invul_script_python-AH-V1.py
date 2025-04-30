import sqlalchemy as SA
from datetime import datetime

# connect with database
engine = SA.create_engine("mysql+pymysql://root@localhost/verrukkulluk?charset=utf8mb4")
conn = engine.connect()

# === Reset auto_increment and remove data from user table ===
try:
    conn.execute(SA.text("TRUNCATE TABLE user"))
    conn.execute(SA.text("ALTER TABLE user AUTO_INCREMENT = 1"))
    print("Table 'user' has been deleted and auto_increment has been reset to 1.")
except Exception as e:
    print(f"Error resetting 'user' table: {e}")

# ===== Add dummy data =====
try:
    with engine.begin() as conn:  
        # === Add User ===
        conn.execute(SA.text(""" 
            INSERT INTO user (user_name, password, email, image)
            VALUES ('chef_tom', 'passwordoftom', 'tom@example.com', 'tom.jpg')
        """))
        user_id_tom = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        conn.execute(SA.text(""" 
            INSERT INTO user (user_name, password, email, image)
            VALUES ('chef_anna', 'passwordofanna', 'anna@example.com', 'anna.jpg')
        """))
        user_id_anna = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        conn.execute(SA.text(""" 
            INSERT INTO user (user_name, password, email, image)
            VALUES ('chef_klaas', 'passwordofklaas', 'klaas@example.com', 'klaas.jpg')
        """))
        user_id_klaas = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        # === Add kitchen_type ===
        conn.execute(SA.text("INSERT INTO kitchen_type (record_type, description) VALUES ('K', 'Italian')"))
        kitchen_id_italian = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        conn.execute(SA.text("INSERT INTO kitchen_type (record_type, description) VALUES ('K', 'Mexican')"))
        kitchen_id_mexican = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        conn.execute(SA.text("INSERT INTO kitchen_type (record_type, description) VALUES ('K', 'Dutch')"))
        kitchen_id_dutch = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        conn.execute(SA.text("INSERT INTO kitchen_type (record_type, description) VALUES ('T', 'Vegetarian')"))
        type_id_vegetarian = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        conn.execute(SA.text("INSERT INTO kitchen_type (record_type, description) VALUES ('T', 'Meat')"))
        type_id_meat = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        conn.execute(SA.text("INSERT INTO kitchen_type (record_type, description) VALUES ('T', 'Vegan')"))
        type_id_vegan = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        # === Add articles ===
        article_ids = {}
        articles = [
            ('Spaghetti', 'Dried pasta', 'gram', 1.99, 'Bag 500g'),
            ('Tomato sauce', 'Tomato sauce for pasta', 'ml', 2.49, 'Bottle 500ml'),
            ('Vegetarian minced meat', 'Plant-based minced meat', 'gram', 3.99, 'Tray 250g'),
            ('Onion', 'Yellow onion', 'piece', 0.25, 'Loose'),
            ('Garlic', 'Clove of garlic', 'piece', 0.10, 'Loose'),
            ('Herb mix', 'Italian herbs', 'teaspoon', 0.05, 'Bottle 50g'),
            ('Nacho chips', 'Tortilla chips', 'bag', 1.49, 'Bag 200g'),
            ('Minced meat', 'Beef minced meat', 'gram', 2.99, 'Tray 250g'),
            ('Cheese', 'Grated cheese', 'gram', 1.59, 'Bag 150g'),
            ('Lasagna sheets', 'Pasta for lasagna', 'gram', 1.49, 'Box 250g'),
            ('Bechamel sauce', 'White sauce', 'ml', 1.89, 'Bottle 200ml'),
            ('Bread', 'Whole wheat sandwich', 'slice', 0.20, 'Loose'),
            ('Chocolate sprinkles', 'Dark chocolate sprinkles', 'gram', 0.05, 'Box 200g'),
            ('Butter', 'Plant-based margarine', 'gram', 0.30, 'Piece 25g'),
        ]
        for name, description, unit, price, pack in articles:
            conn.execute(SA.text(""" 
                INSERT INTO article (name, description, unit, price, packaging)
                VALUES (:name, :description, :unit, :price, :packaging)
            """), {
                "name": name,
                "description": description,
                "unit": unit,
                "price": price,
                "packaging": pack
            })
            article_ids[name] = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        # === Add dishes and ingredients ===
        def add_dish(kitchen_id, type_id, user_id, title, short_description, long_description, image):
            conn.execute(SA.text("""
                INSERT INTO dishes (kitchen_id, type_id, user_id, date_added, title, short_description, long_description, image)
                VALUES (:kitchen_id, :type_id, :user_id, :date, :title, :short_description, :long_description, :image)
            """), {
                "kitchen_id": kitchen_id,
                "type_id": type_id,
                "user_id": user_id,
                "date": datetime.now(),
                "title": title,
                "short_description": short_description,
                "long_description": long_description,
                "image": image
            })
            return conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        dish_ids = {}
        dish_ids['Spaghetti Bolognese'] = add_dish(
            kitchen_id_italian, type_id_vegetarian, user_id_tom,
            "Spaghetti Bolognese", "Vegetarian Italian pasta with minced sauce.",
            "Rich tomato sauce with vegetarian minced meat, onion, garlic, and herbs. Served with spaghetti.", "spaghetti.jpg"
        )

        dish_ids['Nachos'] = add_dish(
            kitchen_id_mexican, type_id_meat, user_id_anna,
            "Nachos", "Mexican oven dish with minced meat and cheese.",
            "Crispy nacho chips with seasoned minced meat, cheese, jalapeño, and fresh guacamole.", "nacho.jpg"
        )

        dish_ids['Lasagna'] = add_dish(
            kitchen_id_italian, type_id_meat, user_id_klaas,
            "Lasagna", "Layers of pasta with sauce and cheese.",
            "Layers of pasta, bolognese sauce, and bechamel sauce with melted cheese on top.", "lasagna.jpg"
        )

        dish_ids['Sandwich with chocolate sprinkles'] = add_dish(
            kitchen_id_dutch, type_id_vegan, user_id_anna,
            "Sandwich with chocolate sprinkles", "Sandwich with dark chocolate sprinkles.",
            "Whole wheat sandwich with plant-based butter and dark chocolate sprinkles.", "sandwich.jpg"
        )

        def add_ingredients(dish, items):
            conn.execute(SA.text(f"""
                INSERT INTO ingredient (dish_id, article_id, quantity)
                VALUES {','.join(f"({dish_ids[dish]}, {article_ids[article]}, {quantity})" for article, quantity in items)}
            """))

        add_ingredients('Spaghetti Bolognese', [
            ('Spaghetti', 100),
            ('Tomato sauce', 200),
            ('Vegetarian minced meat', 150),
            ('Onion', 1),
            ('Garlic', 2),
            ('Herb mix', 2)
        ])

        add_ingredients('Nachos', [
            ('Nacho chips', 1),
            ('Tomato sauce', 100)
        ])

        add_ingredients('Lasagna', [
            ('Lasagna sheets', 200),
            ('Minced meat', 150),
            ('Tomato sauce', 150),
            ('Bechamel sauce', 200),
            ('Cheese', 100)
        ])

        add_ingredients('Sandwich with chocolate sprinkles', [
            ('Bread', 1),
            ('Butter', 10),
            ('Chocolate sprinkles', 20)
        ])

        # === Add dish info ===
        conn.execute(SA.text(""" 
            INSERT INTO dish_info (record_type, dish_id, user_id, date, numberfield, textfield)
            VALUES 
            ('C', :dish_id_1, :user_id_1, :date, 5, 'Record C with text and value.'),
            ('P', :dish_id_2, :user_id_2, :date, 3, 'Record P with text and value.'),
            ('R', :dish_id_3, :user_id_3, :date, 7, 'Record R with text and value.'),
            ('F', :dish_id_4, :user_id_2, :date, 7, 'Record F with text and value.')
        """), {
            "dish_id_1": dish_ids['Spaghetti Bolognese'],
            "user_id_1": user_id_tom,
            "dish_id_2": dish_ids['Nachos'],
            "user_id_2": user_id_anna,
            "dish_id_3": dish_ids['Lasagna'],
            "user_id_3": user_id_klaas,
            "dish_id_4": dish_ids['Sandwich with chocolate sprinkles'],
            "user_id_2": user_id_anna,
            "date": datetime.now()
        })

        print("Sample data added to the 'dish_info' table!")

    print("All dummy data has been successfully added!")
except Exception as e:
    print(f"Error adding dummy data: {e}")
