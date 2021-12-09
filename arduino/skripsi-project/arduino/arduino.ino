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
float temperature = 25.0;

int waterLevelValue = 0;
float phSensorValue = 0;
int ppmSensorValue = 0;

//pH sensor stuff
unsigned long int avgValue; 
float b;
int buf[10],temp;
float calibrationValue = 21.34 - 0.51;

void setup() {
  Serial.begin(115200);

  gravityTds.setPin(pinPpmSensor);
  gravityTds.setAref(5.0);
  gravityTds.setAdcRange(1024);
  gravityTds.begin();
 

}

void loop() {
  Serial.println(getAllData());
  delay(10000);
}

String getAllData(){
  dataPh = getDataPhFromSensor();
  dataPpm = getDataPpmFromSensor();
  dataWaterLevel = getDataWaterLevelFromSensor();
  device = "DVC001";
  return "device_id="+device+"&sensor_ph="+String(dataPh)+"&sensor_ppm="+String(dataPpm)+"&sensor_level_air="+String(dataWaterLevel);
}

float getDataPhFromSensor(){
  for(int i=0;i<10;i++) { 
    buf[i]=analogRead(pinPhSensor);
    delay(10);
   }
   for(int i=0;i<9;i++)
   {
    for(int j=i+1;j<10;j++)
    {
     if(buf[i]>buf[j])
     {
      temp=buf[i];
      buf[i]=buf[j];
      buf[j]=temp;
     }
    }
   }
   avgValue=0;
   for(int i=2;i<8;i++)
   avgValue+=buf[i];
   float pHVol=(float)avgValue*5.0/1024/6;
   phSensorValue = -5.70 * pHVol + calibrationValue;
   return phSensorValue;
}

int getDataPpmFromSensor(){
  gravityTds.setTemperature(temperature);
  gravityTds.update();
  ppmSensorValue = gravityTds.getTdsValue();
  return ppmSensorValue;
}

String getDataWaterLevelFromSensor(){
  waterLevelValue = analogRead(pinWaterLevel);

  if (waterLevelValue >=643){
    return "HIGH";
  }
  else if (waterLevelValue >= 573 && waterLevelValue <= 642){
    return "MED";
  }
  else if (waterLevelValue <= 572){
    return "LOW";
  }
}
