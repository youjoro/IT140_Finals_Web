from asyncio.windows_events import NULL
import serial
import time
import datetime
import requests


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
def send_data():
    data_received = read_userOUTPUT()
    data_received = data_received.split()
    print(data)
    data["temp"] = data_received[0]
    data["moisture"] = data_received[1]
    data["Humidity"] = data_received[2]
    data["date"] = datetime.datetime.now()

    r = requests.get("http://192.168.100.18C/IT140_Finals_Web/restAPI/log_data.php", params=data)
    data.clear()
    return

#loops the python scrips so that unless the read output from the serial port is empty
#the program will not send the data to the php file
data_received = read_userOUTPUT()
while data_received == '':
    data_received = read_userOUTPUT()
    if (data_received != ''):
        send_data(data_received)

    
    