#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

// Connection stuffs
const char* ssid = "Hello World";
const char* pass = "88888888";

// Delay Configuration
unsigned long lastTime = 0;
unsigned long timerDelay = 6000;

// Object Declaration
HTTPClient http;
WiFiClient client;

// Relay
#define relay_ph_up D0
#define relay_ph_down D2
#define relay_ppm D1

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
  if (http.begin(client, "http://192.168.1.15/SkripsiHidroponik/arduino/phpfile/data.php?"+data)){
   
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
        water_value =  code_water_value_raw.toFloat();
        value_ph = code_ph_raw.substring(code_ph_raw.indexOf("_")+1).toFloat();
        value_pm = code_pm_raw.substring(code_pm_raw.indexOf("_")+1).toInt();
        code_ph =  code_ph_raw.substring(0,code_ph_raw.indexOf("_"));
        code_pm = code_pm_raw.substring(0,code_pm_raw.indexOf("_"));
        response = code_ph+code_pm;
        Serial.println("response:" + response);
        
        if (response == "pd"){
            setPinRate(relay_ph_down, HIGH);
            delay(CalDelay_pd(value_ph, water_value));
            Serial.println("pd OK!");
            setPinRate(relay_ph_down, LOW);
        }
        else if(response == "pu"){
            setPinRate(relay_ph_up, HIGH);
            delay(CalDelay_pu(value_ph, water_value));
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
            delay(CalDelay_ppm(value_pm, water_value));
            setPinRate(relay_ppm, LOW);
            Serial.println("pm OK!");
        }
        else if(response == "pdpm"){
            pd_run(CalDelay_pu(value_ph, water_value));
            pm_run(CalDelay_ppm(value_pm, water_value));
            Serial.println("pdpm OK!");
        }
        else if(response == "pupm" ){
             pu_run(CalDelay_pu(value_ph, water_value));
             pm_run(CalDelay_ppm(value_pm, water_value));
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

int CalDelay_ppm(int diff,float banyak_air){
  float perbedaan_air;
  int waktu_jeda;
  float ml_yang_diperlukan;
  perbedaan_air = banyak_air/ 1000;
  ml_yang_diperlukan = diff/1.9*2.2;
  waktu_jeda = ml_yang_diperlukan/2.2*1000*perbedaan_air;
  return waktu_jeda;
}

int CalDelay_pu(float diff, float banyak_air){
  float perbedaan_air;
  int waktu_jeda;
  float ml_yang_diperlukan;
  perbedaan_air = banyak_air/ 1000;
  ml_yang_diperlukan = diff/0.051*2.2;
  waktu_jeda = ml_yang_diperlukan/2.2*1000*perbedaan_air;
  return waktu_jeda;
}

int CalDelay_pd(float diff, float banyak_air){
  float perbedaan_air;
  int waktu_jeda;
  float ml_yang_diperlukan;
  perbedaan_air = banyak_air/ 1000;
  ml_yang_diperlukan = diff/0.032*2.2;
  waktu_jeda = ml_yang_diperlukan/2.2*1000*perbedaan_air;
  return waktu_jeda;
}

void pu_run(int dly){
  setPinRate(relay_ph_up, HIGH);
  delay(dly);
  setPinRate(relay_ph_up, LOW);
}

void pd_run(int dly){
  setPinRate(relay_ph_down, HIGH);
  delay(dly);
  setPinRate(relay_ph_down, LOW);
}

void pm_run(int dly){
  setPinRate(relay_ppm, HIGH);
  delay(dly);
  setPinRate(relay_ppm, LOW);
}
