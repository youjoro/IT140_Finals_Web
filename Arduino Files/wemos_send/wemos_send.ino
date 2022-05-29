//needed libraries 
#include <ESP8266WiFi.h>
#include<ESP8266HTTPClient.h>
#include "DHT.h"

//Setting up digital pins for the wemos
#define DHTPIN D9
#define DHTTYPE DHT11

//Variables to start the wemos connection
DHT dht(DHTPIN, DHTTYPE);
const char* ssid = "HUAWEI-2abb";//enter SSID of your network
const char* password = "39ec4bba";//enter the password of your network
const char* host = "192.168.100.18";//enter ip address of your pc
String temp="",hum="";


void setup() {
Serial.begin(9600);
Serial.print("Connecting to ");
Serial.println(ssid);

WiFi.mode(WIFI_STA);
WiFi.begin(ssid, password);

while (WiFi.status() != WL_CONNECTED) {
delay(1000);
Serial.print(".");
}
Serial.println("WiFi connected");
Serial.println("IP address: ");
Serial.println(WiFi.localIP());
}

void loop() {
    float h = dht.readHumidity();
    float t = dht.readTemperature();
 
    Serial.print("{\"humidity\": ");
    Serial.print(h);
    Serial.print(", \"temp\": ");
    Serial.print(t);
    Serial.print("}\n");
    temp=String(t);
    hum=String(h);
    delay(2000);


  if(WiFi.status()== WL_CONNECTED){
    
      if(WiFi.status()== WL_CONNECTED){
         HTTPClient http;
         http.begin("http://192.168.100.18//IT140_Finals_Web/restAPI/log_data.php?ipsrc=1&temp="+ temp + "&humidity=" + hum); //add here the sensors
         http.addHeader("Content-Type", "text/plain");
         http.GET();
         String res = http.getString();
         delay(1000);   
      }  
      else{
       Serial.println("Error in WiFi connection");
      }
  }
}
