#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

// Connection stuffs
const char* ssid = "Hello World";
const char* pass = "88888888";

// Delay Configuration
unsigned long lastTime = 0;
unsigned long timerDelay = 10000;

// Object Declaration
HTTPClient http;
WiFiClient client;

// Relay
#define relay_ph_up D0
#define relay_ph_down D1
#define relay_ppm D2

// Variables
String data;
int incomingByte = 0;

void setup() {
  Serial.begin(115200);
  Serial.println("");
  Serial.print("Connecting to ");
  Serial.println(ssid);

  // init relay
  pinMode(relay_ph_up, OUTPUT);
  pinMode(relay_ph_down, OUTPUT);
  pinMode(relay_ppm, OUTPUT);
  setPinRate(relay_ph_up, LOW);
  setPinRate(relay_ph_down, LOW);
  setPinRate(relay_ppm, LOW);

  // check is arduino connected to internet
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid,pass);

  while (WiFi.status() != WL_CONNECTED){
    delay (600);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("Succesfully connected to internet...");
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
         trim data //for erase the spacing
        data.trim();
        // send data to database
        sendData();
     }
     lastTime = millis();
  }
}

void sendData(){
  
//   Start HTTP Connection
  if (http.begin(client, "http://192.168.1.13/SkripsiHidroponik/arduino/phpfile/data.php?"+data)){
    // Start connection and send HTTP header
    int httpCode = http.GET();
     if (httpCode > 0){
      Serial.printf("HTTP code: %d\n", httpCode);

      // file found at server
      if (httpCode == HTTP_CODE_OK || HTTP_CODE_MOVED_PERMANENTLY){
        String payload = http.getString();
        Serial.println(payload);

        if (payload == "add pH down"){
            setPinRate(relay_ph_down, HIGH);
            delay(2000);
            setPinRate(relay_ph_down, LOW);
        }
        else if(payload == "add pH up"){
            setPinRate(relay_ph_up, HIGH);
            delay(2000);
            setPinRate(relay_ph_up, LOW);
        }
        else if(payload == "add ppm"){
            setPinRate(relay_ppm, HIGH);
            delay(2000);
            setPinRate(relay_ppm, LOW);
        }
        else if(payload == "add pH downadd ppm"){
            setPinRate(relay_ph_down, HIGH);
            setPinRate(relay_ppm, HIGH);
            delay(2000);
            setPinRate(relay_ph_down, LOW);
            setPinRate(relay_ppm, LOW);
        }
        else if(payload == "add pH upadd ppm"){
            setPinRate(relay_ph_up, HIGH);
            setPinRate(relay_ppm, HIGH);
            delay(2000);
            setPinRate(relay_ph_up, LOW);
            setPinRate(relay_ppm, LOW);
        }
      }
    }else{
      Serial.printf("HTTP connection failed, error: %s\n", http.errorToString);
    }
    http.end();
  }else{
   Serial.printf("HTTP  unable to connect\n") ;
  }  
 }

void setPinRate(int pin, bool state){
  digitalWrite(pin,!state);
}
