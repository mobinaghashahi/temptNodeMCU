
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <Wire.h>

const char* ssid = "SSID NETWORK";
const char* password = "PASSWORD NETWORK";

String serverName = "SERVER NAME";

void setup() {
  Serial.begin(9600);

  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

 
}


void loop() {
  int sumTemp=0,count=0;
  float avgTemp=0;
  if(WiFi.status()== WL_CONNECTED){
    WiFiClient client;
    HTTPClient http;
    for (count=0;count<15;count++)
    {
      sumTemp=drawLM35()+sumTemp;
      Serial.println(sumTemp);
    }
    avgTemp=(float)sumTemp/(float)count;
    Serial.print("avg Temp");
    Serial.println(serverName+(String)avgTemp);
    delay(300);
    http.begin(client, serverName+(String)avgTemp);
      int httpResponseCode = http.GET();
      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String payload = http.getString();
        Serial.println(payload);
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      // Free resources
      http.end();
  }
}

int drawLM35() {
  int val = 0;
  for (int i = 0; i < 10; i++) {
    val += analogRead(A0);
    delay(200);
  }

  int templm35 = val * 33 / 1023;

  return templm35;
  

}
