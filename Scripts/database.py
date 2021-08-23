import mysql.connector
import RPi.GPIO as GPIO
import time
import sys
import datetime
import random

def run():
    temp = random.randint(19,24)
    try:
        print("1")
        cnx = mysql.connector.connect(
            host="sql4.freemysqlhosting.net",
            user="sql4432430",
            password="vakT5EI9ft",
            database="sql4432430")
        cur = cnx.cursor()
    except mysql.connector.Error as err:
        print(err)
        sys.exit(err)
    today = datetime.datetime.now()
    print("1")
    query = (
        "UPDATE data D SET D.temperature = %s WHERE D.id = 1"
    )
    try:
        cur.execute(query, [temp])
    except mysql.connector.Error as err:
        print(err)
        cur.close()
        cnx.close()
        sys.exit(err)
    cnx.commit()
    cur.close()
    cnx.close()
    print("2")

while (True):
    time.sleep(5)
    run()
    
