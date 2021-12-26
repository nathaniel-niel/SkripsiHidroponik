#include<EEPROM.h>
#include<GravityTDS.h>

// Sensor pin declaration
#define pinWaterLevel A0
#define pinPhSensor A1
#define pinPpmSensor A2

// Object Declaration
GravityTDS gravityTds;

// Variable Declaration
float dataPh;
int dataPpm;
String dataWaterLevel, device;
float temperature = 25;

int waterLevelValue = 0;
float phSensorValue = 0;
int ppmSensorValue = 0;
int raw_data_ppm;
int avg_data_ppm;
float raw_data_ph;
float avg_data_ph;
int measure = 0;

//pH sensor stuff
unsigned long int avgValue; 
float b;
int pH_arr[30],ppm_arr[30];
float calibrationValue = 21.338 - 0.51;

void setup() {
  Serial.begin(115200);

  gravityTds.setPin(pinPpmSensor);
  gravityTds.setAref(5.0);
  gravityTds.setAdcRange(1024);
  gravityTds.begin();

}

void loop() {

  Serial.println(getAllData());
  avg_data_ppm = 0;
  avg_data_ph = 0;
  delay(30000);
}

String getAllData(){
  dataPh = avgPh();
  dataPpm = avgPpm();
  dataWaterLevel = getDataWaterLevelFromSensor();

  device = "DVC001";
  return "device_id="+device+"&sensor_ph="+String(dataPh)+"&sensor_ppm="+String(dataPpm)+"&sensor_level_air=HIGH";
//  return "device_id=DVC001&sensor_ph="+String(dataPh)+"&sensor_ppm="+String(dataPpm)+"&sensor_level_air="+String(dataWaterLevel);
}



float avgPh(){
  for(int i=0;i<30;i++) 
 { 
  pH_arr[i]=analogRead(pinPhSensor);
  delay(10);
 }

 avgValue=0;
 for(int i=5;i<30;i++)
 avgValue+=pH_arr[i];
 
 float pHVol= avgValue*5.0/1023/25;
 float pHFormula= 7+((2.5-pHVol)/0.18);
 return pHFormula;

}

int getDataPpmFromSensor(){
  for(int i=0;i<30;i++) { 
    gravityTds.setTemperature(temperature);
    gravityTds.update();
    ppmSensorValue = gravityTds.getTdsValue();
    ppm_arr[i]=ppmSensorValue;
    delay(1000);
   }
}

float avgPpm(){
   getDataPpmFromSensor();
   for (int i=5; i<30 ; i++){
    raw_data_ppm+=ppm_arr[i];
  }
  avg_data_ppm = raw_data_ppm/25;
  raw_data_ppm = 0;
 return avg_data_ppm;
}

String getDataWaterLevelFromSensor(){
  waterLevelValue= analogRead(pinWaterLevel);
  if (  waterLevelValue >=651){
    return "HIGH";
  }
  else if (waterLevelValue>= 430 &&   waterLevelValue <= 650){
    return "MED";
  }
  else if (waterLevelValue <= 429){
    return "LOW";
  }
 
}
