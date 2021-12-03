#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

// Connection stuffs
const char* ssid = "Niel's Iphone";
const char* pass = "niel1234";

// Delay Configuration
unsigned long lastTime = 0;
unsigned long timerDelay = 1000;

// Object Declaration
HTTPClient http;
WiFiClient client;

// Variables
String data;
int incomingByte = 0;

void setup() {
  Serial.begin(115200);
  Serial.println("");
  Serial.print("Connecting to ");
  Serial.println(ssid);

  // check is arduino connected to internet
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid,pass);

  while (WiFi.status() != WL_CONNECTED){
    delay (600);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("Your arduino succesfully connected to internet...");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  WiFi.setAutoReconnect(true);
  WiFi.persistent(true);
  
  
  
}

void loop() {
   String data = "";
   if (millis() - lastTime > timerDelay){
      if (WiFi.status() == WL_CONNECTED){
         
        // add functio to send data here
        while (Serial.available()>0){
         data+= char(Serial.read());
         
        
          
         
        }
        data.trim();
         Serial.println("data dari sensor: "+ data);
        

     }
     lastTime = millis();
  }

}

void sendData(String data){
  

//   Start HTTP Connection
  if (http.begin(client, "http://172.20.10.9/SkripsiHidroponik/arduino/phpfile/data.php?"+data)){

    // Start connection and send HTTP header
    int httpCode = http.GET();
     if (httpCode > 0){
      Serial.printf("HTTP code: %d\n", httpCode);

      // file found at server
      if (httpCode == HTTP_CODE_OK || HTTP_CODE_MOVED_PERMANENTLY){
        String payload = http.getString();
        Serial.println(payload);
      }
    }
    else{
      Serial.printf("HTTP connection failed, error: %s\n", http.errorToString);
    }
    http.end();
  }
  else{
   Serial.printf("HTTP  unable to connect\n") ;
  }  
    
 }
    
