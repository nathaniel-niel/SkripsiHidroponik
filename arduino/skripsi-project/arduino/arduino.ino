//#include<SoftwareSerial.h>

// Sensor pin declaration
#define pinWaterLevel A0
#define pinPhSensor A1
#define pinPpmSensor A2

// Object Declaration
//SoftwareSerial nodemcuSerial(5,6);

// Variable Declaration
float dataPh;
int dataPpm;
String dataWaterLevel;

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
//   nodemcuSerial.begin(115200);
//   

}

void loop() {
//  Serial.println(getAllData());
  Serial.println(getAllData());
  delay(1000);

}

String getAllData(){
  dataPh = getDataPhFromSensor();
  dataPpm = getDataPpmFromSensor();
  dataWaterLevel = getDataWaterLevelFromSensor();
  return "sensor_ph="+String(dataPh)+"&sensor_ppm="+String(dataPpm)+"&sensor_level_air="+String(dataWaterLevel);
}

float getDataPhFromSensor(){
//  for(int i=0;i<10;i++) { 
//    buf[i]=analogRead(analogInPin);
//    delay(10);
//   }
//   for(int i=0;i<9;i++)
//   {
//    for(int j=i+1;j<10;j++)
//    {
//     if(buf[i]>buf[j])
//     {
//      temp=buf[i];
//      buf[i]=buf[j];
//      buf[j]=temp;
//     }
//    }
//   }
//   avgValue=0;
//   for(int i=2;i<8;i++)
//   avgValue+=buf[i];
//   float pHVol=(float)avgValue*5.0/1024/6;
//   phSensorValue = -5.70 * pHVol + calibrationValue;
//
//   return phSensorValue;
  return 7.3;
}

int getDataPpmFromSensor(){

  return 1020;
  
}

String getDataWaterLevelFromSensor(){
//  waterLevelValue = analogRead(pinWaterLevel);
//  return waterLevelValue;
  return "HIGH";
}
