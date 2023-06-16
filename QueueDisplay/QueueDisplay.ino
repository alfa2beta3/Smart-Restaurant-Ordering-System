#include "SevSeg.h"  /* Included seven-segment library */
#include <WiFi.h>    /* Added WiFi library */

SevSeg sevseg;       /* Create a seven-segment library */

//WIFI Network Credentials
const char* ssid = "ASUS 1986";
const char* password = "0560g4Q[";

// Web server configuration
WiFiServer server(80);
String header;
unsigned long currentTime = millis();
unsigned long previousTime = 0;
const long timeoutTime = 2000;

short table = 0;

  

void setup()
{
  byte sevenSegments = 1;  /* Number of connected seven-segment */
  byte CommonPins[] = {};  /* Define Common pin of seven-segment */
  byte LEDsegmentPins[] = {15, 2, 4, 5, 18, 19, 21};  /* Define ESP32 digital pins for seven-segment */
  bool resistorsOnSegments = true; /* Assign Boolean type to the registers of the seven-segment */
  sevseg.begin(COMMON_ANODE, sevenSegments, CommonPins, LEDsegmentPins, resistorsOnSegments); /* Seven-segment configuration */
  sevseg.setBrightness(80);  /* Seven segment brightness */

  Serial.begin(9600);
  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected.");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  server.begin();

}

void loop()
{

   // Handle incoming client requests
  WiFiClient client = server.available();

   if (client) {
    currentTime = millis();
    previousTime = currentTime;
    Serial.println("New Client.");
    String currentLine = "";
    while (client.connected() && currentTime - previousTime <= timeoutTime) {
      currentTime = millis();
      if (client.available()) {
        char c = client.read();
        Serial.write(c);
        header += c;
        if (c == '\n') {
          if (currentLine.length() == 0) {
            // Prepare and send HTTP response
            client.println("HTTP/1.1 200 OK");
            client.println("Content-type:text/html");
            client.println("Connection: close");
            client.println();
            
            // Process specific requests
            if (header.indexOf("GET /17/on") >= 0) {
              Serial.println("GPIO 17 on");
              table = 0;
              table = table <<1 + 1;
              client.println("GPIO 17 on");
            }
            if (header.indexOf("GET /18/on") >= 0) {
              Serial.println("GPIO 18 on");
              table = table <<1 + 1;
              client.println("GPIO 18 on");
            }
            if (header.indexOf("GET /18/off") >= 0) {
              Serial.println("GPIO 18 off");
              table = table <<1;
              client.println("GET /18/off");
            }
            if (header.indexOf("GET /19/on") >= 0) {
              Serial.println("GPIO 19 on");
              table = table <<1 + 1;
              client.println("GET /19/on");
            }
            if (header.indexOf("GET /19/off") >= 0) {
              Serial.println("GPIO 19 off");
              table = table <<1;
              client.println("GET /19/off");
            }
            if (header.indexOf("GET /20/on") >= 0) {
              Serial.println("GPIO 20 on");
              table = table <<1 + 1;
              client.println("GET /20/on");
            }
            if (header.indexOf("GET /20/off") >= 0) {
              Serial.println("GPIO 20 off");
              table = table <<1;
              client.println("GET /20/off");
            }
            
            
            // Send HTML web page
            client.println("<!DOCTYPE html><html>");
            client.println("<head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">");
            client.println("<link rel=\"icon\" href=\"data:,\">");
            client.println("<style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}");
            client.println(".button { background-color: #4CAF50; border: none; color: white; padding: 16px 40px;");
            client.println("text-decoration: none; font-size: 30px; margin: 2px; cursor: pointer;}</style></head>");
            
            client.println("<body><h1>ESP32 Web Server</h1>");
            client.println("<p><a href=\"/25/on\"><button class=\"button\">Book Seat 25</button></a></p>");
            client.println("</body></html>");
            client.println();
            break;
          } else {
            currentLine = "";
          }
        } else if (c != '\r') {
          currentLine += c;
        }
      }
    }
    header = "";
    client.stop();
    Serial.println("Client disconnected.");
    Serial.println("");
  }
  Serial.println("table is");
  Serial.println(table);
   for(int i = 0; i < 10; i++)   /* Display number from 0 to 9 using for loop */
   {
     sevseg.setNumber(i);
     sevseg.refreshDisplay(); /* Refresh seven-segment display after each iteration */
     delay(1000);    /* Time delay for loop iteration */
   }
}
