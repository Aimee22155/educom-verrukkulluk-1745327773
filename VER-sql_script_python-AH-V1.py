import mysql.connector
import sqlalchemy as SA

# Verbinden met MySQL server
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password=""
)
mycursor = mydb.cursor()

# Database aanmaken indien nodig
mycursor.execute("SHOW DATABASES LIKE 'recepten'")
if not mycursor.fetchone():
    mycursor.execute("CREATE DATABASE recepten")
    print("Database 'recepten' succesvol aangemaakt.")
else:
    print("Database 'recepten' bestaat al.")

# SQLAlchemy engine
engine = SA.create_engine("mysql+pymysql://root@localhost/recepten?charset=utf8mb4")

# Tabellen aanmaken
with engine.connect() as conn:
    # keuken_type
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS keuken_type (
            id INT AUTO_INCREMENT PRIMARY KEY,
            record_type ENUM('K', 'T') NOT NULL,
            omschrijving TEXT NOT NULL
        );
    '''))

    # user
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_name VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL,
            afbeelding TEXT
        );
    '''))

    # artikel
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS artikel (
            id INT AUTO_INCREMENT PRIMARY KEY,
            naam VARCHAR(100) NOT NULL,
            omschrijving TEXT,
            eenheid VARCHAR(50),
            prijs DECIMAL(10,2) NOT NULL,
            verpakking VARCHAR(100)
        );
    '''))

    # gerechten
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS gerechten (
            id INT AUTO_INCREMENT PRIMARY KEY,
            keuken_id INT NOT NULL,
            type_id INT NOT NULL,
            user_id INT NOT NULL,
            datum_toegevoegd DATETIME NOT NULL,
            titel VARCHAR(100) NOT NULL,
            korte_omschrijving TEXT,
            lange_omschrijving TEXT,
            afbeelding TEXT
        );
    '''))

    # ingredient
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS ingredient (
            id INT AUTO_INCREMENT PRIMARY KEY,
            gerecht_id INT NOT NULL,
            artikel_id INT NOT NULL,
            aantal FLOAT NOT NULL
        );
    '''))
    
    # gerecht_info
    conn.execute(SA.text('''
        CREATE TABLE IF NOT EXISTS gerecht_info (
            id INT AUTO_INCREMENT PRIMARY KEY,
            record_type ENUM('O', 'B', 'W', 'F') NOT NULL,
            gerecht_id INT NOT NULL,
            user_id INT NOT NULL,
            datum DATE NOT NULL,
            nummeriekveld INT,
            tekstveld TEXT
        );
    '''))

print("Alle tabellen zijn aangemaakt.")
