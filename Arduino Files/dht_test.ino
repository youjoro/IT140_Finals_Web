#include <SPI.h>
#include <Ethernet.h>
#include "DHT.h"
#define DHTPIN 9
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
byte ip[] = {192, 168, 100, 19 }; //Enter the IP of ethernet shield
byte serv[] = {192, 168, 100, 18} ; //Enter the IPv4 address
EthernetClient cliente;

unsigned long previousMillis = 0UL;
unsigned long interval = 5000UL;

void setup() {
    Serial.begin(9600); //setting the baud rate at 9600
    Ethernet.begin(mac, ip);
    dht.begin();
}

void loop() {
    unsigned long currentMillis = millis();

    // using millis interval instead of delays
    if(currentMillis - previousMillis < interval) {
        return;
    }
    previousMillis = currentMillis;

    if (!cliente.connect(serv, 80)) {
        Serial.println("connection failed");
        return;
    }

    float hum = dht.readHumidity(); //Reading the humidity and storing in hum
    float temp = dht.readTemperature(); //Reading the temperature as Celsius and storing in temp
    float fah = dht.readTemperature(true); //reading the temperature in Fahrenheit
    float heat_index = dht.computeHeatIndex(fah, hum); //Reading the heat index in Fahrenheit
    float heat_indexC = dht.convertFtoC(heat_index); //Converting the heat index in Celsius

    Serial.println("connected");

    cliente.print("GET //IT140_Finals_Web/restAPI/log_data.php?"); //Connecting and Sending values to database
    cliente.print("&temp=");
    cliente.print(temp);
    cliente.print("&humidity=");
    cliente.print(hum);
    cliente.print("&heat_index=");
    cliente.println(heat_indexC);

    //Printing the values on the serial monitor
    Serial.print("Temperature= ");
    Serial.println(temp);
    Serial.print("Humidity= ");
    Serial.println(hum);
    Serial.print("Heat Index= ");
    Serial.println(heat_indexC);

    cliente.stop(); //Closing the connection

    return;
}
