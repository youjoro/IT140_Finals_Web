import tkinter as tk
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
        self.start_button = tk.Button(self.program, text="Start", command=self.on_start)
        self.start_button.place(x=5, y=10, width=button_width, height=button_height)

        self.connect_button = tk.Button(self.program, text="Connect", command=self.on_connect)
        self.connect_button.place(x=165, y=10, width=button_width, height=button_height)

        self.verify_button = tk.Button(self.program, text="Verify", command=self.on_verify)
        self.verify_button.place(x=325, y=10, width=button_width, height=button_height)

        self.clear_button = tk.Button(self.program, text="Clear", command=self.clear_text)
        self.clear_button.place(x=485, y=10, width=button_width, height=button_height)

        self.text_box = tk.Text(self.program, borderwidth=3, relief=tk.SUNKEN)
        self.text_box.place(x=3, y=70, width=self.program_width - 6, height=407)
        self.text_box.config(state=tk.DISABLED)

        # Arduino Variables
        self.id = 1512
        self.serial_send = None
        self.verify = None

        # Program Start
        self.program.mainloop()

    def clear_text(self):
        self.text_box.config(state=tk.NORMAL)
        self.text_box.delete("0.1", tk.END)
        self.text_box.config(state=tk.DISABLED)

    def write_text(self, text: str) -> None:
        self.text_box.config(state=tk.NORMAL)
        self.text_box.insert(tk.END, text + "\n")
        self.text_box.config(state=tk.DISABLED)

    def on_start(self) -> None:
        for port in serial.tools.list_ports.comports():
            port = str(port)

            if 1 in [1 for c in ['Arduino', 'USB-SERIAL'] if c in port]:
                port = port.split(' ')[0]

        if port != 'none' and self.verify == '1':
            self.serial_send = serial.Serial(port, 9600, timeout=1)
            self.write_text("Start Successful!")
            self.write_text(f"Port: {port}")
            self.write_text(f"Verify: {self.verify}")
            return

        self.write_text("Something went wrong.")
        self.write_text(f"Port: {port}")
        self.write_text(f"Verify: {self.verify}")

    @staticmethod
    def php_pass_data(data):
        data2 = data.rstrip().split()
        data={}
        data["temp"] = data2[0]
        data["moisture"] = data2[1]
        data["humidity"] = data2[2]
        data["date"] = datetime.timestamp(datetime.now())
        data["id"] = data2[3]
        requests.get('http://localhost/IT140_Finals_Web/restAPI/log_data.php?', params=data)

    def ping_pong(self):
        while True:
            
            self.serial_send.write("H".encode())
            self.serial_send.flushInput()

            if data_received := self.serial_send.readline().decode():
                self.php_pass_data(data_received)
                self.write_text(data_received)

            sleep(0.1)

            

    def on_connect(self) -> None:
        threading.Thread(target=self.ping_pong, daemon=True).start()

    def on_verify(self) -> None:
        self.verify = requests.get('http://localhost//IT140_Finals_Web/Arduino_Files/verify_device.php?', params={'id': self.id}).text.split('=')[1]
        
        if (self.verify=='1'):
            self.write_text("Verified")
        else:
            self.write_text("Not Verified")


Application()
