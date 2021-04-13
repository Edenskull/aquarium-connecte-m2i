import datetime
import argparse
import sys
import os

VERSION = "0.0.1"


def run(temp, ph, hum, path):
    now = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    with open(path, 'a') as fp:
        fp.write(";".join(line) + "\n")
    pass


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description="Push data to csv file every minute.")
    parser.add_argument("-p", "--path", type=str, help="path of the file you want to push")
    parser.add_argument("--temperature", type=float, help="value retrieve for temperature")
    parser.add_argument("--ph", type=float, help="value retrieve for ph")
    parser.add_argument("--humidite", type=float, help="value retrieve for humidite")
    parser.add_argument("-v", "--version", action="store_true", help="show version of the script")
    args = parser.parse_args()
    if args.version:
        print("Data pusher Version : " + VERSION)
    else:
        if args.path:
            run(args.temperature, args.ph, args.humidite, args.path)
        else:
            sys.exit("Path is not provided")
    sys.exit()
