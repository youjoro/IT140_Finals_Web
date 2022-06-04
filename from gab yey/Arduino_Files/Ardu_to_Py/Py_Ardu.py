import tkinter as tk
from tkinter import ttk
from time import sleep
from datetime import datetime
import threading
import requests
import serial
import serial.tools.list_ports


class Application:
    def __init__(self):
        # Initialize Program
        self.program = tk.Tk()
        self.program.title("Arduino Thingy")

        self.program_width = 640
        self.program_height = 480

        screen_w = self.program.winfo_screenwidth()
        screen_h = self.program.winfo_screenheight()

        offset_w = (screen_w - self.program_width) // 2
        offset_h = (screen_h - self.program_height) // 2

        self.program.geometry(f"{self.program_width}x{self.program_height}+{offset_w}+{offset_h}")
        self.program.resizable(0, 0)

        # Global Button Size
        button_width = 150
        button_height = 50

        # UI Elements

        self.clear_button = tk.Button(self.program, text="Clear", command=self.clear_text)
        self.clear_button.place(x=485, y=10, width=button_width, height=button_height)

        self.text_box = tk.Text(self.program, borderwidth=3, relief=tk.SUNKEN)
        self.text_box.place(x=3, y=70, width=540, height=407)
        self.text_box.config(state=tk.DISABLED)
        
        self.temperature_bar = ttk.Progressbar(self.program, orient="vertical", length=405)
        self.temperature_bar['value'] = 50
        self.temperature_bar.place(x=550, y=70)

        self.humidity_bar = ttk.Progressbar(self.program, orient="vertical", length=405)
        self.humidity_bar['value'] = 50
        self.humidity_bar.place(x=580, y=70)

        self.moisture_bar = ttk.Progressbar(self.program, orient="vertical", length=405, maximum=2000)
        self.moisture_bar['value'] = 50
        self.moisture_bar.place(x=610, y=70)

        # Arduino Variables
        self.has_error=0
        self.id = 1234
        self.serial_send = serial.Serial('COM3', 9600, timeout=1)
        self.verify = None
        self.port = None

        # Program Start
        
        threading.Thread(target=self.run_and_verify, daemon=True).start()
        threading.Thread(target=self.ping_pong, daemon=True).start()
        self.program.mainloop()

    def update_bar(self, data):
        data = data.split()
        self.temperature_bar['value'] = float(data[0])
        self.moisture_bar['value'] = float(data[2])
        self.humidity_bar['value'] = float(data[1])

    def clear_text(self):
        self.text_box.config(state=tk.NORMAL)
        self.text_box.delete("0.1", tk.END)
        self.text_box.config(state=tk.DISABLED)

    def write_text(self, text: str) -> None:
        self.text_box.config(state=tk.NORMAL)
        self.text_box.insert(tk.END, text + "\n")
        self.text_box.config(state=tk.DISABLED)

    def run_and_verify(self) -> None:
        self.verify = requests.get('http://localhost/IT140_Finals_Web/Arduino_Files/verify_device.php?', params={'id': self.id}).text.split('=')[1]
        self.write_text("" if self.verify == '1' else "")
        self.write_text(self.verify)

        for port in serial.tools.list_ports.comports():
            self.port = str(port)

            if 1 in [1 for c in ['Arduino', 'USB-SERIAL'] if c in self.port]:
                self.port = self.port.split(' ')[0]

        if self.port is not None and self.verify == "1":
            try:
                self.serial_send = serial.Serial(self.port, 9600, timeout=1)
                self.write_text("Start Successful!")
                self.write_text(f"Port: {self.port}")
                self.has_error=0
                return
            except Exception:
                self.write_text("No sendo")
                self.write_text(f"Port: {self.port}")
                self.has_error=1
                sleep(5)
                if self.has_error:
                    self.run_and_verify()

        else:
            self.write_text("No Ports")
            self.write_text(f"Port: {self.port}")
            self.write_text("Reconnecting...")
            self.has_error=1
            sleep(5)
            if self.has_error:
                self.run_and_verify()
            

    @staticmethod
    def php_pass_data(data):
        data = data.split()
        data = {
            "date": datetime.timestamp(datetime.now()),
            "id": data[3],
            "temp": data[0],
            "moisture": data[1],
            "humidity": data[2],
        }
        requests.get('http://localhost/IT140_Finals_Web/restAPI/log_data.php?', params=data)

    def ping_pong(self):
        while True:
            try:
                self.serial_send.write('H'.encode())
                self.serial_send.flushInput()

                if data_received := self.serial_send.readline().decode():
                    self.php_pass_data(data_received)
                    self.write_text(data_received)
                    self.update_bar(data_received)
                    
                    

                sleep(0.1)
                

            except Exception:
                self.write_text("No sendo.")
                self.write_text(f"Port: {self.port}")
                
                self.has_error=1
                if self.has_error:
                    self.run_and_verify()
                
                pass


Application()
