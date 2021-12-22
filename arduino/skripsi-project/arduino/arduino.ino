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
float temperature = 28.5;

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
int buf[10],temp, ppm_arr[30];
float calibrationValue = 21.338 - 0.51;

void setup() {
  Serial.begin(115200);

  gravityTds.setPin(pinPpmSensor);
  gravityTds.setAref(5.0);
  gravityTds.setAdcRange(1024);
  gravityTds.begin();
 

}

void loop() {

  getpHData();
  Serial.println(getAllData());
  avg_data_ppm = 0;
  avg_data_ph = 0;
delay(1000);
}

String getAllData(){
  dataPh = getDataPhFromSensor();
  dataPpm = avgPpm();
  dataWaterLevel = getDataWaterLevelFromSensor();

  device = "DVC001";
//  return "device_id="+device+"&sensor_ph="+String(dataPh)+"&sensor_ppm="+String(dataPpm)+"&sensor_level_air="+String(dataWaterLevel);
  return "device_id=DVC001&sensor_ph=6.8&sensor_ppm="+String(dataPpm)+"&sensor_level_air=HIGH";
}

float averagePhData(){
   delay(5000);
   for (int i=0; i<10 ; i++){
    
    float data = getDataPhFromSensor();
    Serial.println(data);
    raw_data_ph+=data;

    delay(1000);

  }
  avg_data_ph = raw_data_ph/10;
  raw_data_ph = 0;
 return avg_data_ph;
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

float getpHData(){
  for(int i=0;i<10;i++) 
 { 
  buf[i]=analogRead(pinPhSensor);
  delay(10);
 }

 avgValue=0;
 for(int i=2;i<8;i++)
 avgValue+=buf[i];
 
 float pHVol=(float)avgValue*5.0/1024/6;
 float pHFormula= 7 + ((2.5-pHVol)/0.18);
 float phValue = -5.70 * pHVol + 21.34;
 return phValue;
// Serial.print("voltage : ");
// Serial.println(pHVol);
// Serial.print("Formula : ");
// Serial.println(pHFormula);
// Serial.print("Calibration : ");
// Serial.println(phValue);

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
