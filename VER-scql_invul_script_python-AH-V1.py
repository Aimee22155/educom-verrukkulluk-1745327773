import sqlalchemy as SA
from datetime import datetime

# Verbind met de database
engine = SA.create_engine("mysql+pymysql://root@localhost/recepten?charset=utf8mb4")
conn = engine.connect()


# ===== USER TOEVOEGEN =====
try:
    conn.execute(SA.text(""" 
        INSERT INTO user (user_name, password, email, afbeelding)
        VALUES ('chef_tom', 'wachtwoordvantom', 'tom@example.com', 'tom.jpg')
    """))
    user_id = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()
    print(f"Gebruiker toegevoegd met ID: {user_id}")
except Exception as e:
    print(f"Fout bij toevoegen van gebruiker: {e}")

# ===== KEUKEN_TYPE TOEVOEGEN =====
try:
    conn.execute(SA.text("INSERT INTO keuken_type (record_type, omschrijving) VALUES ('K', 'Italiaans')"))
    keuken_id_italiaans = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text("INSERT INTO keuken_type (record_type, omschrijving) VALUES ('K', 'Mexicaans')"))
    keuken_id_mexicaans = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text("INSERT INTO keuken_type (record_type, omschrijving) VALUES ('K', 'Nederlands')"))
    keuken_id_nederlands = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text("INSERT INTO keuken_type (record_type, omschrijving) VALUES ('T', 'Vegetarisch')"))
    type_id_vegetarisch = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text("INSERT INTO keuken_type (record_type, omschrijving) VALUES ('T', 'Vlees')"))
    type_id_vlees = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text("INSERT INTO keuken_type (record_type, omschrijving) VALUES ('T', 'Vegan')"))
    type_id_vegan = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    print("Keuken types succesvol toegevoegd!")
except Exception as e:
    print(f"Fout bij toevoegen van keuken types: {e}")

# ===== ARTIKELEN TOEVOEGEN =====
try:
    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Spaghetti', 'Gedroogde pasta', 'gram', 1.99, 'Zak 500g')
    """))
    artikel_id_spaghetti = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Tomatensaus', 'Tomatensaus voor pasta', 'ml', 2.49, 'Fles 500ml')
    """))
    artikel_id_tomatensaus = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Vegetarisch gehakt', 'Plantaardig gehakt', 'gram', 3.99, 'Beker 300g')
    """))
    artikel_id_vegehakt = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Ui', 'Gele ui', 'stuk', 0.25, 'Los')
    """))
    artikel_id_ui = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Knoflook', 'Teentje knoflook', 'stuk', 0.10, 'Los')
    """))
    artikel_id_knoflook = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Kruidenmix', 'Italiaanse kruiden', 'theelepel', 0.05, 'Strooi')
    """))
    artikel_id_kruidenmix = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Nacho chips', 'Tortilla chips', 'zak', 1.49, 'Zak 200g')
    """))
    artikel_id_nacho = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Gehakt', 'Rundergehakt', 'gram', 2.99, 'Bakje 250g')
    """))
    artikel_id_gehakt = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Kaas', 'Geraspte kaas', 'gram', 1.59, 'Zakje 150g')
    """))
    artikel_id_kaas = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Lasagnebladen', 'Pasta voor lasagne', 'gram', 1.49, 'Doos 250g')
    """))
    artikel_id_lasagnebladen = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Bechamelsaus', 'Witte saus', 'ml', 1.89, 'Fles 400ml')
    """))
    artikel_id_bechamel = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Brood', 'Volkoren boterham', 'snede', 0.20, 'Los')
    """))
    artikel_id_brood = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Hagelslag', 'Pure chocolade hagelslag', 'gram', 0.05, 'Zak 200g')
    """))
    artikel_id_hagelslag = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(""" 
        INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
        VALUES ('Boter', 'Plantaardige margarine', 'gram', 0.03, 'Wikkel')
    """))
    artikel_id_boter = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    print("Artikelen succesvol toegevoegd!")
except Exception as e:
    print(f"Fout bij toevoegen van artikelen: {e}")

# ===== GERECHTEN TOEVOEGEN =====
gerecht_ids = {}

try:
    conn.execute(SA.text(f"""
        INSERT INTO gerechten (keuken_id, type_id, user_id, datum_toegevoegd, titel, korte_omschrijving, lange_omschrijving, afbeelding)
        VALUES ({keuken_id_italiaans}, {type_id_vegetarisch}, {user_id}, '{datetime.now()}', 
        'Spaghetti Bolognese', 'Vegetarische Italiaanse pasta met gehaktsaus.', 
        'Rijke tomatensaus met vegetarisch gehakt, ui, knoflook en kruiden. Geserveerd met spaghetti.', 'spaghetti.jpg')
    """))
    gerecht_ids['Spaghetti Bolognese'] = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(f"""
        INSERT INTO gerechten (keuken_id, type_id, user_id, datum_toegevoegd, titel, korte_omschrijving, lange_omschrijving, afbeelding)
        VALUES ({keuken_id_mexicaans}, {type_id_vlees}, {user_id}, '{datetime.now()}', 
        'Nachos', 'Mexicaanse ovenschotel met gehakt en kaas.', 
        'Knapperige nacho chips met gekruid gehakt, kaas, jalapeño en verse guacamole.', 'nacho.jpg')
    """))
    gerecht_ids['Nachos'] = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(f"""
        INSERT INTO gerechten (keuken_id, type_id, user_id, datum_toegevoegd, titel, korte_omschrijving, lange_omschrijving, afbeelding)
        VALUES ({keuken_id_italiaans}, {type_id_vlees}, {user_id}, '{datetime.now()}', 
        'Lasagne', 'Laagjes pasta met saus en kaas.', 
        'Laagjes pasta, bolognesesaus en bechamelsaus met gesmolten kaas bovenop.', 'lasagne.jpg')
    """))
    gerecht_ids['Lasagne'] = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    conn.execute(SA.text(f"""
        INSERT INTO gerechten (keuken_id, type_id, user_id, datum_toegevoegd, titel, korte_omschrijving, lange_omschrijving, afbeelding)
        VALUES ({keuken_id_nederlands}, {type_id_vegan}, {user_id}, '{datetime.now()}', 
        'Boterham met hagelslag', 'Boterham met chocolade pure hagelslag.', 
        'Volkoren boterham met plantaardige boter en pure hagelslag.', 'boterham.jpg')
    """))
    gerecht_ids['Boterham met hagelslag'] = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

    print("Gerechten succesvol toegevoegd!")
except Exception as e:
    print(f"Fout bij toevoegen van gerechten: {e}")

# ===== INGREDIËNTEN TOEVOEGEN =====
# Voeg ingrediënten toe aan gerechten
try:
    # Spaghetti Bolognese
    conn.execute(SA.text(f"""
        INSERT INTO ingredient (gerecht_id, artikel_id, aantal)
        VALUES
        ({gerecht_ids['Spaghetti Bolognese']}, {artikel_id_spaghetti}, 100),
        ({gerecht_ids['Spaghetti Bolognese']}, {artikel_id_tomatensaus}, 200),
        ({gerecht_ids['Spaghetti Bolognese']}, {artikel_id_vegehakt}, 150),
        ({gerecht_ids['Spaghetti Bolognese']}, {artikel_id_ui}, 1),
        ({gerecht_ids['Spaghetti Bolognese']}, {artikel_id_knoflook}, 2),
        ({gerecht_ids['Spaghetti Bolognese']}, {artikel_id_kruidenmix}, 2)
    """))

    # Nachos
    conn.execute(SA.text(f"""
        INSERT INTO ingredient (gerecht_id, artikel_id, aantal)
        VALUES
        ({gerecht_ids['Nachos']}, {artikel_id_nacho}, 1),
        ({gerecht_ids['Nachos']}, {artikel_id_tomatensaus}, 100)
    """))

    # Lasagne
    conn.execute(SA.text(f"""
        INSERT INTO ingredient (gerecht_id, artikel_id, aantal)
        VALUES
        ({gerecht_ids['Lasagne']}, {artikel_id_lasagnebladen}, 200),
        ({gerecht_ids['Lasagne']}, {artikel_id_gehakt}, 150),
        ({gerecht_ids['Lasagne']}, {artikel_id_tomatensaus}, 150),
        ({gerecht_ids['Lasagne']}, {artikel_id_bechamel}, 200),
        ({gerecht_ids['Lasagne']}, {artikel_id_kaas}, 100)
    """))

    # Boterham met hagelslag
    conn.execute(SA.text(f"""
        INSERT INTO ingredient (gerecht_id, artikel_id, aantal)
        VALUES
        ({gerecht_ids['Boterham met hagelslag']}, {artikel_id_brood}, 1),
        ({gerecht_ids['Boterham met hagelslag']}, {artikel_id_boter}, 10),
        ({gerecht_ids['Boterham met hagelslag']}, {artikel_id_hagelslag}, 20)
    """))

    print("Ingrediënten succesvol toegevoegd!")
except Exception as e:
    print(f"Fout bij toevoegen van ingrediënten: {e}")

print("Alle dummy data is succesvol toegevoegd!")
