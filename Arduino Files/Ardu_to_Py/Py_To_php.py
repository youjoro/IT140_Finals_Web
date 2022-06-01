from asyncio.windows_events import NULL
from posixpath import split

import sys
import serial.tools.list_ports
import serial
import time
import datetime
import requests
from datetime import datetime

data={}

#finding the com port for the arduino automatically
def find_ardu():
    commPort ='none'
    numConnection = serial.tools.list_ports.comports()
    
    for i in range(len(numConnection)):
        ports = numConnection[i]
        strPort = str(ports)

        #finds the arduino based on the name
        if 'Arduino' in strPort or 'USB-SERIAL' in strPort:
            splitPort = strPort.split(' ')
            commPort = (splitPort[0])
    
    return commPort


#retrieving of data from php
def php_retrieve():
    id = {'id':1234}
    r = requests.get('http://localhost/IT140_Finals_Web/restAPI/verify_user.php?',params=id)
    print(sys.argv[0])


#send message to arduino for M2M purposes
def send_userINPUT(send_input):
    serial_send.write(send_input)
    serial_send.flushInput()
    time.sleep(0.1)
    

#receives data from serial comm
def read_userOUTPUT():
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

#starts to find available com ports and
#tries to find the arduino one
get_port = find_ardu()

if get_port!='none':
    print(get_port)
    # starts connection to the serialport
    serial_send = serial.Serial(get_port, 9600, timeout=1)
    
    while True:
        send_userINPUT(b'H')
        data_received = read_userOUTPUT()
        if (data_received != ''):
            send_data(data_received)
        
else:
    print("no ardu")





    

    
    
