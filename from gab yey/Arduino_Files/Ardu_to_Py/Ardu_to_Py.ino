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

String temp_send,hum_send,soil_send,device_id="1234";

//for RTOS
TaskHandle_t handler_dht;
TaskHandle_t handler_soil;
//TaskHandle_t handler_check;


//for checking status
int verified_device=1;
byte incoming_data;

void setup(){
 Serial.begin(9600);
 dht.begin();

 //PINS FOR LEDS
 //3-RED 4-GREEN
 pinMode(3,OUTPUT);
 pinMode(4,OUTPUT);

 //TASKS FOR RTOS
 xTaskCreate(check_status, "Task1", 100, (void*)&verified_device, 3, NULL);
 xTaskCreate(get_soil, "Soil_task", 100, NULL, 1, &handler_soil);
 xTaskCreate(get_dht, "DHT_Task", 500, NULL, 2, &handler_dht);
 
}


void loop()
{
}


static void check_status(void* pvParameters)
{
  while(1){
    incoming_data = Serial.read();
    delay(1000);
    if (incoming_data =='H'){
      verified_device=1;
    }
    
    if(verified_device==1){
      vTaskResume(handler_dht);
      vTaskResume(handler_soil);
      vTaskDelay(4000/portTICK_PERIOD_MS); 
      digitalWrite(3,LOW);
      digitalWrite(4,HIGH);
    }else{
      vTaskSuspend(handler_dht);
      vTaskSuspend(handler_soil);
      digitalWrite(3,HIGH);
      digitalWrite(4,LOW);
    }
    


  }
  vTaskDelay(1000/portTICK_PERIOD_MS); 
}

static void get_soil(void* pvParameters)
{
   while(1){
    float soil = analogRead(A0);
    soil_send = soil;

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
    float hum = dht.readHumidity(); //Reading the humidity and storing in hum
    float temp = dht.readTemperature(); //Reading the temperature as Celsius

    //temp_send = temp;
    //hum_send = hum;

    //printing the data to serial
    Serial.print(temp);
    Serial.print(" ");
    Serial.print(hum);
    Serial.print(" ");
    vTaskDelay(5000/portTICK_PERIOD_MS);
  }
   
}
