import mysql.connector
import argparse
import sys
import os

VERSION = "0.0.1"


def run(path):
    try:
        cnx = mysql.connector.connect(
            host="localhost",
            port="3306",
            user="root",
            password="",
            database="test")
        cur = cnx.cursor()
    except mysql.connector.Error as err:
        sys.exit(err)
    if os.path.exists(path):
        with open(path, "r") as fp:
            data = fp.read().splitlines()
        query = (
            "INSERT INTO inputraspberry (temperature, ph, humidite, timestamp) "
            "VALUES (%s, %s, %s, %s)"
        )
        try:
            for entry in data:
                cur.execute(query, entry.split(';'))
        except mysql.connector.Error as err:
            cur.close()
            cnx.close()
            sys.exit(err)
        cnx.commit()
    else:
        sys.exit("File path not found")
    cur.close()
    cnx.close()
    open(path, "w").close()


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description="Provide a data file to push to mysql database.")
    parser.add_argument("-p", "--path", type=str, help="path of the file you want to push")
    parser.add_argument("-v", "--version", action="store_true", help="show version of the script")
    args = parser.parse_args()
    if args.version:
        print("Data pusher Version : " + VERSION)
    else:
        if args.path:
            run(args.path)
        else:
            sys.exit("Path is not provided")
    sys.exit()
