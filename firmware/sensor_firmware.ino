//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

// BlueLab: Woven Wind
// A2Steam Wind Turbine Sensor Code and Server Push
// Last Edit: June 6th, 2017
// Created by: Justin Hsieh, Genevieve Flaspohler

/*
                 / '.         .' \
                /    '.     .'    \
                 '-._  '. .'  _.-'
                     '-. ; .-'
                    _.-;(_);-._
                _.-'   .'_'.   '-._
                \    .'/[+]\'.    /
                 \_.' /     \ '._/
                      |  _  |
                      | [_] |
                     /III III\
                     `"""""""`
*/

//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

#define DEBUG
#include <Ethernet.h>
#include <SPI.h> // For SERIAL MONITOR
#include <OneWire.h> // FOR TEMPERATURE SENSOR
#include <avr/interrupt.h> // FOR HALL EFFECT


// HALL EFFECT SENSOR GLOBAL VARS
volatile int prevTime = 0;
volatile int currTime = 0;
float rpm = 0.0;

// TEMPERATURE SENSOR GLOBAL VARS
OneWire ds(9);  // on pin 9
volatile float celsius = 0.0;

// ANEMOMETER GLOBAL VARS
const int wind_pin = A5;
volatile int sensorValue = 0;
volatile float sensorVoltage = 0.0;
volatile float windSpeed = 0.0;


// VOLTAGE GLOBAL VARS
const int voltage_divider = A1;
volatile float voltage = 0.0;

// ETHERNET SETUP
EthernetClient client;
byte mac[] = {  
  0x90, 0xA2, 0xDA, 0x10, 0x74, 0x23 };
IPAddress ip(10,122,102,46);
//char serverName [] = "northside2.aaps.k12.mi.us";
char serverName [] = "10.122.102.45";
// DELAY
int interval = 20000; // wait 20 sec between dumps


void setup() {

  // start the Ethernet connection and serial interface:
  Ethernet.begin(mac, ip);
  Serial.begin(9600);

  // give the sensor and Ethernet shield time to set up:
  delay(1000);
  
#ifdef DEBUG  
  Serial.println("             Network Information             ");
  Serial.println("-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n");
  Serial.print("IP Address        : ");
  Serial.println(Ethernet.localIP());
  Serial.print("Subnet Mask       : ");
  Serial.println(Ethernet.subnetMask());
  Serial.print("Default Gateway IP: ");
  Serial.println(Ethernet.gatewayIP()); 
  Serial.print("Server Address : ");
  Serial.println(serverName);
#endif

  //Sesnors
  //Digitial pin 10 in the temeperature digital input
  pinMode(2,INPUT); //Digital pin 2 is the hall effect sensor
  attachInterrupt(0, pin2ISR,FALLING);

}

void loop() { 

      read_temperature();
      
      read_wind();
      
      //read_voltage();
     
      //No need to call RPM; interrupt based
      
      postData();
            
      delay(interval);
}


void postData() {
  if (client.connect(serverName, 80)) {

#ifdef DEBUG
    Serial.println("Connection successful...");
#endif
    // Make a HTTP request:    
    
    client.print(F("GET /add_data.php?windspeed="));
    //client.print(F("GET test.php?windspeed="));
    client.print(windSpeed);
    client.print(F("&temperature="));
    client.print(celsius);
    client.print(F("&rpm="));

    cli();
    client.println(rpm);
    rpm = 0.0;
    sei();
    
    client.println(F("Host: 10.122.102.45"));
    client.println(F("Connection: close"));
    client.println();   
    client.stop();

#ifdef DEBUG
    Serial.println("Sending Finished");  
#endif
  }
  else{
#ifdef DEBUG
    Serial.println("Connection failed...");
#endif
  }
} 

void pin2ISR() {
  cli();
  //calculating RPS
  currTime = millis();

#ifdef DEBUG
  Serial.print("RPM: ");
  Serial.print(1000.0/(currTime-prevTime) * 60.0);
  Serial.println();
#endif

  float temp = 1000.0/(currTime-prevTime) * 60.0;

  if(temp <= 200) {
    if(temp > 0) {
      rpm = temp;
    }
    else {
      rpm = 0.0;
    }
  }
  else {
    rpm = 0.0;
  }

  
  prevTime = currTime;
  sei();
}

void read_wind(void){
   
   sensorValue =  analogRead(wind_pin); 
   
   if (sensorValue == 0 || sensorValue == 1023) return;

   sensorVoltage = sensorValue * .004882814;

#ifdef DEBUG
   Serial.print("Sensor Value: ");
   Serial.print(sensorValue);
   Serial.print("\t");
   Serial.print("Voltage: ");
   Serial.print(sensorVoltage);
#endif

   if (sensorVoltage <= 0.4)
      windSpeed = 0;
   else
   {
      windSpeed = (sensorVoltage-0.4) * 10 * 2;
   }

#ifdef DEBUG
   Serial.print("\t");
   Serial.print("Wind Speed: ");
   Serial.print(windSpeed * 2.3694);
   Serial.println(" mph");
#endif

   delay(1000);   
}

void read_voltage(void){
   voltage =  analogRead(voltage_divider); 
}


void read_temperature(void) {
/*
  int rawvoltage= analogRead(0);
  float volts= rawvoltage/205.0;
  float celsiustemp= 100.0 * volts - 50;
  float fahrenheittemp= celsiustemp * 9.0/5.0 + 32.0;
  //celsius =  ( 4.4 * analogRead(0) * 100.0) / 1024.0;

#ifdef DEBUG
  Serial.print("Sensor Value: ");
  Serial.print(rawvoltage);
  Serial.print("\tVoltage: ");
  Serial.print(volts);
  Serial.print("\tTemperature (F): ");
  Serial.println(fahrenheittemp-95);
#endif
*/

  int HighByte, LowByte, TReading, SignBit, Tc_100, Whole, Fract;   
  byte i;
  byte present = 0;
  byte data[12];
  byte addr[8];

  Serial.println(analogRead(A0));

  ds.reset_search();
  if ( !ds.search(addr)) {
      Serial.print("No more addresses.\n");
      ds.reset_search();
      return;
  }

  //Serial.print("R=");
  for( i = 0; i < 8; i++) {
    Serial.print(addr[i], HEX);
    Serial.print(" ");
  }

  if ( OneWire::crc8( addr, 7) != addr[7]) {
      //Serial.print("CRC is not valid!\n");
      return;
  }

  if ( addr[0] == 0x10) {
      Serial.print("Device is a DS18S20 family device.\n");
  }
  else if ( addr[0] == 0x28) {
      Serial.print("Device is a DS18B20 family device.\n");
  }
  else {
      Serial.print("Device family is not recognized: 0x");
      Serial.println(addr[0],HEX);
      return;
  }

  ds.reset();
  ds.select(addr);
  ds.write(0x44,1);         // start conversion, with parasite power on at the end

  delay(1000);     // maybe 750ms is enough, maybe not
  // we might do a ds.depower() here, but the reset will take care of it.

  present = ds.reset();
  ds.select(addr);    
  ds.write(0xBE);         // Read Scratchpad

  //Serial.print("P=");
  //Serial.print(present,HEX);
  //Serial.print(" ");
  for ( i = 0; i < 9; i++) {           // we need 9 bytes
    data[i] = ds.read();
    //Serial.print(data[i], HEX);
    //Serial.print(" ");
  }

#ifdef DEBUG
  Serial.print(" CRC=");
  Serial.print( OneWire::crc8( data, 8), HEX);
  Serial.println();
#endif
  LowByte = data[0];
  HighByte = data[1];
  TReading = (HighByte << 8) + LowByte;
  SignBit = TReading & 0x8000;  // test most sig bit
  if (SignBit) // negative
  {
    TReading = (TReading ^ 0xffff) + 1; // 2's comp
  }
  Tc_100 = (6 * TReading) + TReading / 4;    // multiply by (100 * 0.0625) or 6.25

  double Tc_100_d = Tc_100;


  Whole = Tc_100 / 100;  // separate off the whole and fractional portions
  Fract = Tc_100 % 100;

  celsius = Tc_100/100.0;
  
#ifdef DEBUG
  if (SignBit) // If its negative
  {
     Serial.print("-");
  }
  Serial.print(Whole);
  Serial.print(".");
  if (Fract < 10)
  {
     Serial.print("0");
  }
  Serial.print(Fract);

  Serial.print("\n");

  Serial.print("Celsius: "); 
  Serial.print(celsius); 
  Serial.print('\n');
#endif
}


