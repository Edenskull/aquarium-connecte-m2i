import mysql.connector
import RPi.GPIO as GPIO
import time
import sys
import datetime


aquarium_id = 1


def reset_food_giver():
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
    today = datetime.datetime.now()
    query = (
        "UPDATE food F, `aquarium-config` AC SET F.status = 0, F.last_given_food = %s WHERE F.id = AC.id_foreign AND AC.id_aquarium = %s"
    )
    try:
        cur.execute(query, [today, aquarium_id])
    except mysql.connector.Error as err:
        print(err)
        cur.close()
        cnx.close()
        sys.exit(err)
    cnx.commit()
    cur.close()
    cnx.close()


def check_food_giver():
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
        "SELECT status FROM food F, `aquarium-config` AC WHERE F.id = AC.id_foreign AND AC.id_aquarium = %s"
    )
    try:
        cur.execute(query, [aquarium_id])
    except mysql.connector.Error as err:
        print(err)
        cur.close()
        cnx.close()
        sys.exit(err)
    result = cur.fetchone()
    cur.close()
    cnx.close()
    return result[0]


# Set function to calculate percent from angle
def setAngle(angle):
    if angle > 180 or angle < 0:
        return False
    start = 4
    end = 12.5
    ratio = (end - start) / 180  # Calcul ratio from angle to percent
    angle_as_percent = angle * ratio
    return start + angle_as_percent


while True:
    time.sleep(5)
    status = check_food_giver()
    if status == 1:
        GPIO.setmode(GPIO.BOARD)  # Use Board numerotation mode
        GPIO.setwarnings(False)  # Disable warnings

        # Use pin 12 for PWM signal
        pwm_gpio = 11
        frequence = 50
        GPIO.setup(pwm_gpio, GPIO.OUT)
        pwm = GPIO.PWM(pwm_gpio, frequence)

        # Init at 0°
        pwm.start(0)
        print("Waiting for 2 seconds")
        time.sleep(2)

        # Duty cycle
        duty = 2

        # Loop for duty values from 2 to 12 (0 to 180 degrees)
        while duty <= 12:
            pwm.ChangeDutyCycle(duty)
            time.sleep(10)
            duty = duty + 6
        # Wait for 2 seconds

        time.sleep(2)

        # Go at 90°
        # pwm.ChangeDutyCycle(setAngle(90))
        # time.sleep(2)
        print("Turning back to 90 degrees for 2 seconds")
        pwm.ChangeDutyCycle(7)
        time.sleep(2)

        # Turn back to 0 degree
        print("Turning back to 0 degrees")
        pwm.ChangeDutyCycle(2)
        time.sleep(0.5)
        pwm.ChangeDutyCycle(0)

        # Finish at 180°
        # pwm.ChangeDutyCycle(setAngle(180))
        # time.sleep(1)
        # Close GPIO & cleanup
        pwm.stop()
        GPIO.cleanup()

        #  Run update for status
        reset_food_giver()

        #  Quit script
        print(" Quit")
