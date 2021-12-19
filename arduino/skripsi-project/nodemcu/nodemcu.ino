#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

// Connection stuffs
const char* ssid = "Alberthome_ext";
const char* pass = "basketball29";

// Delay Configuration
unsigned long lastTime = 0;
unsigned long timerDelay = 28000;

// Object Declaration
HTTPClient http;
WiFiClient client;

// Relay
#define relay_ph_up D1
#define relay_ph_down D2
#define relay_ppm D3

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
         
        // add function to send data here
        while (Serial.available()>0){
          data+= char(Serial.read());
        }
         //trim data; //for erase the spacing
        data.trim();
//         send data to database
//  Serial.println(data);
        sendData(data);
     }
     lastTime = millis();
  }
}

void sendData(String data){
  
//   Start HTTP Connection
//  if (http.begin(client, "http://192.168.1.13/SkripsiHidroponik/arduino/phpfile/data.php?"+data)){
  // Start connection and send HTTP header
  if (http.begin(client, "http://192.168.100.125/SkripsiHidroponik/arduino/phpfile/data.php?"+data)){
   
    int httpCode = http.GET();
     if (httpCode > 0){
      Serial.printf("HTTP code: %d\n", httpCode);

      // file found at server
      if (httpCode == HTTP_CODE_OK || HTTP_CODE_MOVED_PERMANENTLY){
        String payload = http.getString();
        Serial.println(payload);

        float value_ph = 0;
        int value_pm;
        String code_water_value_raw;
        int water_value;
        String code_ph_raw, code_pm_raw, code_ph, code_pm;
        String code;
        String response;
        code = payload.substring(payload.indexOf("*")+1);
        Serial.println(code);
        code_ph_raw = code.substring(0,code.indexOf(" "));
        code_pm_raw = code.substring(code.indexOf(" ")+1);
  
        code_water_value_raw = payload.substring(0,payload.indexOf("*"));
        water_value =  code_water_value_raw.toInt();
//        Serial.println("RAW VALUE");
//        Serial.println("nilai air: " + code_water_value_raw);
//        Serial.println("ppm: " + code_pm_raw);
//        Serial.println("ph: " + code_ph_raw);
        value_ph = code_ph_raw.substring(code_ph_raw.indexOf("_")+1).toFloat();
        value_pm = code_pm_raw.substring(code_pm_raw.indexOf("_")+1).toInt();
//        Serial.println("ph and ppm value");
//        Serial.println("value ph: " +String(value_ph));
//        Serial.println("value pm: "+String(value_pm));
//        Serial.println("response code");
        code_ph =  code_ph_raw.substring(0,code_ph_raw.indexOf("_"));
        code_pm = code_pm_raw.substring(0,code_pm_raw.indexOf("_"));
//        Serial.println("code ph: " +code_ph);
//        Serial.println("code pm: "+code_pm);
        response = code_ph+code_pm;
        Serial.println("response:" + response);
        
        if (response == "pd"){
            setPinRate(relay_ph_down, HIGH);
            delay(2000);
            Serial.println("pd OK!");
            setPinRate(relay_ph_down, LOW);
        }
        else if(response == "pu"){
            setPinRate(relay_ph_up, HIGH);
            delay(2000);
            setPinRate(relay_ph_up, LOW);
            Serial.println("pu OK!");
        }
        else if(response == "pm"){
          if (value_pm ==0){
            value_pm = value_ph;
          }
           Serial.println("water value: " + String(water_value));
           Serial.println("ppm value: " + String(value_pm));
           
            setPinRate(relay_ppm, HIGH);
            delay(CalDelay(value_pm, water_value));
            
            Serial.println(CalDelay(value_pm, water_value));
            setPinRate(relay_ppm, LOW);
          
            Serial.println("pm OK!");
        }
        else if(response == "pdpm"){
            setPinRate(relay_ph_down, HIGH);
            setPinRate(relay_ppm, HIGH);
            delay(2000);
            setPinRate(relay_ph_down, LOW);
            setPinRate(relay_ppm, LOW);
            Serial.println("pdpm OK!");
        }
        else if(response == "pupm" ){
            setPinRate(relay_ph_up, HIGH);
            setPinRate(relay_ppm, HIGH);
            delay(2000);
            setPinRate(relay_ph_up, LOW);
            setPinRate(relay_ppm, LOW);
            Serial.println("pupm OK!");
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

int CalDelay(int diff, int banyak_air){
  float perbedaan_air;
  int waktu_jeda;
  float ml_yang_diperlukan;
  
  perbedaan_air = banyak_air/ 1000;
  ml_yang_diperlukan = diff/5.8*5;
  waktu_jeda = 2.5* ml_yang_diperlukan/5* 1000*perbedaan_air;
  return waktu_jeda;
}

void ppm_pump_on(){
    setPinRate(relay_ppm, HIGH);
}

void ppm_pump_off(){
   setPinRate(relay_ppm, LOW);
}
