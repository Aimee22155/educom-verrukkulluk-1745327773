import sqlalchemy as SA
from datetime import datetime

# Verbind met de database
try:
    engine = SA.create_engine("mysql+pymysql://root@localhost/recepten?charset=utf8mb4")
    conn = engine.connect()
    print("Verbinding geslaagd!")
except Exception as e:
    print(f"Verbinding mislukt: {e}")
    exit()

# === RESET AUTO_INCREMENT EN VERWIJDER GEGEVENS IN DE USER TABEL ===
try:
    conn.execute(SA.text("TRUNCATE TABLE user"))
    conn.execute(SA.text("ALTER TABLE user AUTO_INCREMENT = 1"))
    print("Tabel 'user' is gewist en de auto_increment is gereset naar 1.")
except Exception as e:
    print(f"Fout bij het resetten van de 'user' tabel: {e}")

# ===== DUMMY DATA TOEVOEGEN =====
try:
    with engine.begin() as conn:  
        # === USER TOEVOEGEN ===
        conn.execute(SA.text(""" 
            INSERT INTO user (user_name, password, email, afbeelding)
            VALUES ('chef_tom', 'wachtwoordvantom', 'tom@example.com', 'tom.jpg')
        """))
        user_id = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        # === KEUKEN_TYPE TOEVOEGEN ===
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

        # === ARTIKELEN TOEVOEGEN ===
        artikel_ids = {}
        artikelen = [
            ('Spaghetti', 'Gedroogde pasta', 'gram', 1.99, 'Zak 500g'),
            ('Tomatensaus', 'Tomatensaus voor pasta', 'ml', 2.49, 'Fles 500ml'),
            ('Vegetarisch gehakt', 'Plantaardig gehakt', 'gram', 3.99, 'Beker 300g'),
            ('Ui', 'Gele ui', 'stuk', 0.25, 'Los'),
            ('Knoflook', 'Teentje knoflook', 'stuk', 0.10, 'Los'),
            ('Kruidenmix', 'Italiaanse kruiden', 'theelepel', 0.05, 'Strooi'),
            ('Nacho chips', 'Tortilla chips', 'zak', 1.49, 'Zak 200g'),
            ('Gehakt', 'Rundergehakt', 'gram', 2.99, 'Bakje 250g'),
            ('Kaas', 'Geraspte kaas', 'gram', 1.59, 'Zakje 150g'),
            ('Lasagnebladen', 'Pasta voor lasagne', 'gram', 1.49, 'Doos 250g'),
            ('Bechamelsaus', 'Witte saus', 'ml', 1.89, 'Fles 400ml'),
            ('Brood', 'Volkoren boterham', 'snede', 0.20, 'Los'),
            ('Hagelslag', 'Pure chocolade hagelslag', 'gram', 0.05, 'Zak 200g'),
            ('Boter', 'Plantaardige margarine', 'gram', 0.03, 'Wikkel')
        ]
        for naam, omschr, eenheid, prijs, verp in artikelen:
            conn.execute(SA.text(""" 
                INSERT INTO artikel (naam, omschrijving, eenheid, prijs, verpakking)
                VALUES (:naam, :omschr, :eenheid, :prijs, :verpakking)
            """), {
                "naam": naam,
                "omschr": omschr,
                "eenheid": eenheid,
                "prijs": prijs,
                "verpakking": verp
            })
            artikel_ids[naam] = conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        # === GERECHTEN EN INGREDIËNTEN TOEVOEGEN ===
        def voeg_gerecht_toe(keuken_id, type_id, titel, kort, lang, afbeelding):
            conn.execute(SA.text("""
                INSERT INTO gerechten (keuken_id, type_id, user_id, datum_toegevoegd, titel, korte_omschrijving, lange_omschrijving, afbeelding)
                VALUES (:keuken_id, :type_id, :user_id, :datum, :titel, :kort, :lang, :afbeelding)
            """), {
                "keuken_id": keuken_id,
                "type_id": type_id,
                "user_id": user_id,
                "datum": datetime.now(),
                "titel": titel,
                "kort": kort,
                "lang": lang,
                "afbeelding": afbeelding
            })
            return conn.execute(SA.text("SELECT LAST_INSERT_ID()")).scalar()

        gerecht_ids = {}
        gerecht_ids['Spaghetti Bolognese'] = voeg_gerecht_toe(
            keuken_id_italiaans, type_id_vegetarisch,
            "Spaghetti Bolognese", "Vegetarische Italiaanse pasta met gehaktsaus.",
            "Rijke tomatensaus met vegetarisch gehakt, ui, knoflook en kruiden. Geserveerd met spaghetti.", "spaghetti.jpg"
        )

        gerecht_ids['Nachos'] = voeg_gerecht_toe(
            keuken_id_mexicaans, type_id_vlees,
            "Nachos", "Mexicaanse ovenschotel met gehakt en kaas.",
            "Knapperige nacho chips met gekruid gehakt, kaas, jalapeño en verse guacamole.", "nacho.jpg"
        )

        gerecht_ids['Lasagne'] = voeg_gerecht_toe(
            keuken_id_italiaans, type_id_vlees,
            "Lasagne", "Laagjes pasta met saus en kaas.",
            "Laagjes pasta, bolognesesaus en bechamelsaus met gesmolten kaas bovenop.", "lasagne.jpg"
        )

        gerecht_ids['Boterham met hagelslag'] = voeg_gerecht_toe(
            keuken_id_nederlands, type_id_vegan,
            "Boterham met hagelslag", "Boterham met chocolade pure hagelslag.",
            "Volkoren boterham met plantaardige boter en pure hagelslag.", "boterham.jpg"
        )

        def voeg_ingredienten_toe(gerecht, items):
            conn.execute(SA.text(f"""
                INSERT INTO ingredient (gerecht_id, artikel_id, aantal)
                VALUES {','.join(f"({gerecht_ids[gerecht]}, {artikel_ids[artikel]}, {aantal})" for artikel, aantal in items)}
            """))

        voeg_ingredienten_toe('Spaghetti Bolognese', [
            ('Spaghetti', 100),
            ('Tomatensaus', 200),
            ('Vegetarisch gehakt', 150),
            ('Ui', 1),
            ('Knoflook', 2),
            ('Kruidenmix', 2)
        ])

        voeg_ingredienten_toe('Nachos', [
            ('Nacho chips', 1),
            ('Tomatensaus', 100)
        ])

        voeg_ingredienten_toe('Lasagne', [
            ('Lasagnebladen', 200),
            ('Gehakt', 150),
            ('Tomatensaus', 150),
            ('Bechamelsaus', 200),
            ('Kaas', 100)
        ])

        voeg_ingredienten_toe('Boterham met hagelslag', [
            ('Brood', 1),
            ('Boter', 10),
            ('Hagelslag', 20)
        ])

        # === GERECHTEN INFO TOEVOEGEN ===
        conn.execute(SA.text(""" 
            INSERT INTO gerecht_info (record_type, gerecht_id, user_id, datum, nummeriekveld, tekstveld)
            VALUES 
            ('O', :gerecht_id_1, :user_id_1, :datum, 5, 'Record O met tekst en waarde.'),
            ('B', :gerecht_id_2, :user_id_2, :datum, 3, 'Record B met tekst en waarde.'),
            ('W', :gerecht_id_3, :user_id_3, :datum, 7, 'Record W met tekst en waarde.'),
            ('F', :gerecht_id_4, :user_id_4, :datum, 7, 'Record F met tekst en waarde.')
        """), {
            "gerecht_id_1": gerecht_ids['Spaghetti Bolognese'],
            "user_id_1": user_id,
            "datum": datetime.now(),
            "gerecht_id_2": gerecht_ids['Nachos'],
            "user_id_2": user_id,
            "gerecht_id_3": gerecht_ids['Lasagne'],
            "user_id_3": user_id,
            "gerecht_id_4": gerecht_ids['Boterham met hagelslag'],
            "user_id_4": user_id
        })

        print("Voorbeelddata toegevoegd aan de 'gerecht_info' tabel!")

    print("Alle dummy data is succesvol toegevoegd!")
except Exception as e:
    print(f"Fout bij toevoegen van dummy data: {e}")
