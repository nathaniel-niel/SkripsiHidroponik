#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>


 // MARK: - Data sensor variables
 int batasan_ph, batasan_ppm, batasan_air;

// MARK: - Connection sttufs

const char* ssid = "yourWifiName";
const char* pass = "yourWifiPassword";


// MARK: - Delay
unsigned long lastTime = 0;
unsigned long timerDelay = 10000;

// MARK: - Object

 HTTPClient http;
 WiFiClient client;

 // MARK: - Initial Function from ARduino
 
void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  Serial.println("");
  Serial.print("Connecting to ");
  Serial.println(ssid);

  // check is arduino connected to internet
  WiFi.begin(ssid,pass);
  

  while (WiFi.status() != WL_CONNECTED){
    delay (600);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("Your arduino succesfully connected to internet...");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

}

void loop() {
  // put your main code here, to run repeatedly:

  if (millis() - lastTime > timerDelay){
    if (WiFi.status() == WL_CONNECTED){

      
//      Serial.print("actual arduino run time: ");
//      Serial.println(millis());
      sendData();

    }
    lastTime = millis();
  }
}


// MARK: - Send data to server

void sendData(){

  // Make random sensor input (dummy data)
    batasan_ph = getpHsesorData();
    batasan_ppm = getPpmSensorData();
    batasan_air = getWaterLevelSensorData();

  String data = (String)"?batasan_ph="+batasan_ph+"&batasan_ppm="+batasan_ppm+"&batasan_air="+batasan_air;
   
    // Start HTTP Connection
  if (http.begin(client, "http://192.168.100.125/php/data.php?batasan_ph="+String(batasan_ph)+"&batasan_ppm="+String(batasan_ppm)+"&batasan_air="+String(batasan_air))){
    
    // start connection and send HTTP Header
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

 // MARK: - Get data from sensor

 int getpHsesorData(){
  // dummy data
    return random(0,14);
 }

 int getPpmSensorData(){
  // dummy data
    return  random (900,1500);
 }

 int getWaterLevelSensorData(){
  // dummy data
    return random (50, 300);
 }
