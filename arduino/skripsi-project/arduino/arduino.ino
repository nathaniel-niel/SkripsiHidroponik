#include<EEPROM.h>
#include<GravityTDS.h>

// Sensor pin declaration
#define pinWaterLevel A0
#define pinPhSensor A1
#define pinPpmSensor A2

// Object Declaration
GravityTDS gravityTds;

// Variable Declaration
float dataPh, avg_data_ph, temperature = 25.0, pH4 = 3.1, pH7 = 2.6, sumValue, pHVolt, pHFormula, phStep, pH_arr[30];
int dataPpm, avg_data_ppm, raw_data_ppm, ppmSensorValue = 0, waterLevelValue = 0, ppm_arr[30] ;
String dataWaterLevel, device;

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
<<<<<<< HEAD
//return "device_id="+device+"&sensor_ph=7&sensor_ppm="+String(dataPpm)+"&sensor_level_air=HIGH";
  return "device_id="+device+"&sensor_ph="+String(dataPh)+"&sensor_ppm=500&sensor_level_air=HIGH";
//  return "device_id=DVC001&sensor_ph="+String(dataPh)+"&sensor_ppm="+String(dataPpm)+"&sensor_level_air="+String(dataWaterLevel);
=======
  return "device_id="+device+"&sensor_ph="+String(dataPh)+"&sensor_ppm="+String(dataPpm)+"&sensor_level_air="+String(dataWaterLevel);
>>>>>>> 1a2d474c578380e15d0e1aa919be58181e6ed01e
}

float avgPh(){
  for(int i=0;i<30;i++) 
 { 
  pH_arr[i]=analogRead(pinPhSensor);
  delay(10);
 }

 sumValue = 0.0;
 for(int i=5;i<30;i++)
 sumValue += pH_arr[i];

 phStep = (pH4-pH7) / (7-4);
 pHVolt= sumValue*5.0/1023/25;
 pHFormula= 7 + ((2.6-pHVolt)/phStep);
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
  if (waterLevelValue >=381){
    return "HIGH";
  }
  else if (waterLevelValue>= 51 &&   waterLevelValue <= 380){
    return "MED";
  }
  else if (waterLevelValue <= 50){
    return "LOW";
  }
}
