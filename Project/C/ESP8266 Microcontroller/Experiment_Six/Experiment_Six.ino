#include <ESP8266WiFi.h>
#include <AdafruitIO.h>
#include <AdafruitIO_Dashboard.h>
#include <AdafruitIO_Data.h>
#include <AdafruitIO_Definitions.h>
#include <AdafruitIO_Feed.h>
#include <AdafruitIO_Group.h>
#include <AdafruitIO_MQTT.h>
#include <AdafruitIO_Time.h>
#include <AdafruitIO_WiFi.h>
#include <Adafruit_MQTT.h>
#include <Adafruit_MQTT_Client.h>
#include <ArduinoHttpClient.h>
#include <DHT.h>
#include <DHT_U.h>
#include <Adafruit_Sensor.h>

/************************* WiFi Access Point *********************************/

#define WLAN_SSID       "" // enter wifi name
#define WLAN_PASS       "" // enter wifi password

/************************* Adafruit.io Setup *********************************/

#define AIO_SERVER      "io.adafruit.com"
#define AIO_SERVERPORT  1883                   // use 8883 for SSL
#define AIO_USERNAME    "OliverBikar"
#define AIO_KEY         "aio_PAAp74l8Xp8QksRC2NKgFXgwK2P9"

/************ Global State (you don't need to change this!) ******************/

WiFiClient client;
Adafruit_MQTT_Client mqtt(&client, AIO_SERVER, AIO_SERVERPORT, AIO_USERNAME, AIO_KEY);

/****************************** Feeds ***************************************/

Adafruit_MQTT_Subscribe onoffbutton = Adafruit_MQTT_Subscribe(&mqtt, AIO_USERNAME "/feeds/onoff");
Adafruit_MQTT_Publish temperature = Adafruit_MQTT_Publish(&mqtt, AIO_USERNAME "/feeds/Temperature");
Adafruit_MQTT_Publish humidity = Adafruit_MQTT_Publish(&mqtt, AIO_USERNAME "/feeds/Humidity");

/*************************** Sketch Code ************************************/

void MQTT_connect();
DHT_Unified dht(2, DHT22);

void setup() {
  Serial.begin(115200);
  delay(10);
  dht.begin();

  Serial.println(F("Adafruit MQTT demo"));

  Serial.println(); Serial.println();
  Serial.print("Connecting to ");
  Serial.println(WLAN_SSID);

  WiFi.begin(WLAN_SSID, WLAN_PASS);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println();

  Serial.println("WiFi connected");
  Serial.println("IP address: "); Serial.println(WiFi.localIP());

  mqtt.subscribe(&onoffbutton);
}

uint32_t x=0;

void loop() {
  MQTT_connect();
  sensors_event_t event;
  
  dht.temperature().getEvent(&event);
  float temp = event.temperature;
  Serial.print("temp = ");
  Serial.println(temp);

  dht.humidity().getEvent(&event);
  float relative_humidity = event.relative_humidity;
  Serial.print("humidity = ");
  Serial.println(relative_humidity);

  Adafruit_MQTT_Subscribe *subscription;
  while ((subscription = mqtt.readSubscription(5000))) {
    if (subscription == &onoffbutton) {
      Serial.print(F("Got: "));
      Serial.println((char *)onoffbutton.lastread);
    }
  }

  if (! temperature.publish(temp)) {
    Serial.println(F("Failed"));
  } else {
    Serial.println(F("Temperature read successfully"));
  }

  if (! humidity.publish(relative_humidity)) {
    Serial.println(F("Failed"));
  } else {
    Serial.println(F("Humidity read successfully"));
  }
}

void MQTT_connect() {
  int8_t ret;

  if (mqtt.connected()) {
    return;
  }

  Serial.print("Connecting to MQTT... ");

  uint8_t retries = 3;
  while ((ret = mqtt.connect()) != 0) {
       Serial.println(mqtt.connectErrorString(ret));
       Serial.println("Retrying MQTT connection in 5 seconds...");
       mqtt.disconnect();
       delay(5000);
       retries--;
       if (retries == 0) {
         while (1);
       }
  }
  Serial.println("MQTT Connected!");
}
