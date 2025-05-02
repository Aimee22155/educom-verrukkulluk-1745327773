import mysql.connector
import sqlalchemy as SA

# Connect to MySQL server
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password=""
)
mycursor = mydb.cursor()

# Create database if it doesn't exist
mycursor.execute("SHOW DATABASES LIKE 'verrukkulluk'")
if not mycursor.fetchone():
    mycursor.execute("CREATE DATABASE verrukkulluk")
    print("Database 'verrukkulluk' successfully created.")
else:
    print("Database 'verrukkulluk' already exists.")

# SQLAlchemy engine
engine = SA.create_engine("mysql+pymysql://root@localhost/verrukkulluk?charset=utf8mb4")

# Create tables
with engine.connect() as conn:
    # kitchen_type
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS kitchen_type (
            id INT AUTO_INCREMENT PRIMARY KEY,
            record_type ENUM('K', 'T') NOT NULL,
            description TEXT NOT NULL
        );
    '''))

    # user
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_name VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL,
            image TEXT
        );
    '''))

    # article
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS article (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            unit VARCHAR(50),
            price DECIMAL(10,2) NOT NULL,
            packaging VARCHAR(100),
            calories INT
        );
    '''))

    # dishes
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS dishes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            kitchen_id INT NOT NULL,
            type_id INT NOT NULL,
            user_id INT NOT NULL,
            date_added DATETIME NOT NULL,
            title VARCHAR(100) NOT NULL,
            short_description TEXT,
            long_description TEXT,
            image TEXT
        );
    '''))

    # ingredient
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS ingredient (
            id INT AUTO_INCREMENT PRIMARY KEY,
            dish_id INT NOT NULL,
            article_id INT NOT NULL,
            quantity FLOAT NOT NULL
        );
    '''))

    # dish_info
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS dish_info (
            id INT AUTO_INCREMENT PRIMARY KEY,
            record_type ENUM('C', 'P', 'R', 'F') NOT NULL,
            dish_id INT NOT NULL,
            user_id INT,
            date DATE NOT NULL,
            numberfield INT,
            textfield TEXT
        );
    '''))

print("All tables have been created successfully.")
