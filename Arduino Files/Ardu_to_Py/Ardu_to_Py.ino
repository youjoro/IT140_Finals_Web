//Needed libraries
#include <Arduino_FreeRTOS.h>
#include "DHT.h"

//setting up DHT and the pin used
#define DHTPIN 9
#define DHTTYPE DHT11

//delays
unsigned long previousMillis = 0UL;
unsigned long interval = 5000UL;

DHT dht(DHTPIN, DHTTYPE);

//for testing purposes since i dont have a dht
byte pickedIndex;
float temp_values[5]={32.10, 33.51, 34.12, 31.20, 35.19};
float hum_values[5]={40.10, 43.51, 54.12, 61.20, 45.19};
float soil_values[5]={57.10, 45.51, 75.12, 41.20, 53.19};
String temp_send,hum_send,soil_send,device_id="1234";


void setup(){
 Serial.begin(9600);
 dht.begin();
 xTaskCreate(MyThread1, "Task1", 100, NULL, 1, NULL);
 xTaskCreate(get_soil, "Soil_task", 100, NULL, 2, NULL);
 xTaskCreate(get_dht, "DHT_Task", 100, NULL, 3, NULL);
 
}


void loop()
{
}


static void MyThread1(void* pvParameters)
{
  while(1){
    

  }
}

static void get_soil(void* pvParameters)
{
   while(1){
    //float hum = dht.readHumidity(); //retrieve data from soil sensor

    
    //adding dummy values for testing
    pickedIndex = random(5);     
    soil_send = soil_values[pickedIndex];

    //printing the data to serial
    Serial.print(soil_send);
    Serial.print(" ");
    Serial.print(device_id);
    Serial.println(" ");
    vTaskDelay(5000/portTICK_PERIOD_MS);
   }
  
}

static void get_dht(void* pvParameters)
{
  while(1){
    //float hum = dht.readHumidity(); //Reading the humidity and storing in hum
    //float temp = dht.readTemperature(); //Reading the temperature as Celsius

    //using dummy values for testing
    pickedIndex = random(5);     
    temp_send = temp_values[pickedIndex];
    pickedIndex = random(5);     
    hum_send = hum_values[pickedIndex];
    

    //printing the data to serial
    Serial.print(temp_send);
    Serial.print(" ");
    Serial.print(hum_send);
    Serial.print(" ");
    vTaskDelay(5000/portTICK_PERIOD_MS);
  }
   
}
