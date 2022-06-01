from asyncio.windows_events import NULL

import serial
import time
import datetime
import requests
from datetime import datetime

#starts connection to the serialport
serial_send = serial.Serial('COM3', 9600, timeout=1)
data = {}

#receives data from serial comm
def read_userOUTPUT():
    serial_send.flushInput()
    msg = serial_send.readline()
    mensahe = msg.decode('utf-8')
    
    time.sleep(0.1)
    print (mensahe)
    return mensahe

#retrieving data from the serial port and reformats to be able to be sent to the php
def send_data(data_get):

    data_received = data_get.split()
    dt = datetime.now()
    print(data_get)
    data["temp"] = data_received[0]
    data["moisture"] = data_received[1]
    data["humidity"] = data_received[2]
    data["date"] = datetime.timestamp(dt)
    data["id"] = data_received[3]
    r = requests.get('http://localhost/IT140_Finals_Web/restAPI/log_data.php?', params=data)
    print(r.url)
    return

#loops the python scrips so that unless the read output from the serial port is empty
#the program will not send the data to the php file
data_received = read_userOUTPUT()
while True:
    data_received = read_userOUTPUT()

    if (data_received != ''):
        send_data(data_received)

    
    