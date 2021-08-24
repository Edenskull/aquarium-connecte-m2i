import mysql.connector
import time
import sys
import datetime
import random


id_aquarium = 1


def push_data():
    temperature = random.randint(19, 24)
    ph = random.randint(0, 14)
    humidite = random.randint(0, 100)
    try:
        cnx = mysql.connector.connect(
            host="sql4.freemysqlhosting.net",
            user="sql4432430",
            password="vakT5EI9ft",
            database="sql4432430")
        cur = cnx.cursor()
    except mysql.connector.Error as err:
        print(err)
        sys.exit(err)
    query = (
        "INSERT INTO data (ph, temperature, humidite) VALUES (%s, %s, %s)"
    )
    try:
        cur.execute(query, [ph, temperature, humidite])
    except mysql.connector.Error as err:
        print(err)
        cur.close()
        cnx.close()
        sys.exit(err)
    id_data = cur.getlastrowid()
    query = (
        "INSERT INTO `aquarium-data` (id_aquarium, id_data) VALUES (%s, %s)"
    )
    try:
        cur.execute(query, [id_aquarium, id_data])
    except mysql.connector.Error as err:
        print(err)
        cur.close()
        cnx.close()
        sys.exit(err)
    cnx.commit()
    cur.close()
    cnx.close()


while True:
    time.sleep(5)
    push_data()
    
