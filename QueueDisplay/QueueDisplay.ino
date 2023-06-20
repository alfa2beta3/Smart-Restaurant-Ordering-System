#include <WiFi.h>    /* Added WiFi library */
#include <LiquidCrystal_I2C.h>
#include "SevSeg.h"  /* Included seven-segment library */

//WIFI Network Credentials
const char* ssid = "ASUS 1986";
const char* password = "0560g4Q[";

// Web server configuration
WiFiServer server(80);
String header;
unsigned long currentTime = millis();
unsigned long previousTime = 0;
const long timeoutTime = 2000;

// Set your Static IP address
IPAddress local_IP(192, 168, 137, 100);
// Set your Gateway IP address
IPAddress gateway(192, 168, 1, 1);

IPAddress subnet(255, 255, 255, 0);
IPAddress primaryDNS(8, 8, 8, 8);   //optional
IPAddress secondaryDNS(8, 8, 4, 4); //optional


SevSeg sevseg;       /* Create a seven-segment library */

// set the LCD number of columns and rows
int lcdColumns = 16;
int lcdRows = 2;

// set LCD address, number of columns and rows
// if you don't know your display address, run an I2C scanner sketch
LiquidCrystal_I2C lcd(0x27, lcdColumns, lcdRows); 

short table = 0;
short tables[3] = {0,0,0};
String words = ""; 
String printTables;

short i = 0;
short j = 0;

void setup()
{
  byte sevenSegments = 1;  /* Number of connected seven-segment */
  byte CommonPins[] = {};  /* Define Common pin of seven-segment */
  byte LEDsegmentPins[] = {15, 2, 4, 5, 18, 19, 21};  /* Define ESP32 digital pins for seven-segment */
  bool resistorsOnSegments = true; /* Assign Boolean type to the registers of the seven-segment */
  sevseg.begin(COMMON_ANODE, sevenSegments, CommonPins, LEDsegmentPins, resistorsOnSegments); /* Seven-segment configuration */
  sevseg.setBrightness(80);  /* Seven segment brightness */
  
  // initialize LCD
  lcd.init();
  // turn on LCD backlight                      
  lcd.backlight();

   // Configures static IP address
  if (!WiFi.config(local_IP, gateway, subnet, primaryDNS, secondaryDNS)) {
    Serial.println("STA Failed to configure");
  }
  
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
              table = table + 1;
              Serial.println("Table is");
              Serial.println(table);
              client.println("GPIO 17 on");
              if (j<3)
                j++;
              else
                j = 0;
            }
              if (header.indexOf("GET /17/off") >= 0) {
              Serial.println("GPIO 17 off");
              table = 0;
              Serial.println("Table is");
              Serial.println(table);
              client.println("GPIO 17 off");
              if (j<3)
                j++;
              else
                j = 0;
            }
            if (header.indexOf("GET /18/on") >= 0) {
              Serial.println("GPIO 18 on");
              table = table + (1<<1);
              Serial.println("Table is");
              Serial.println(table);
              client.println("GPIO 18 on");
            }
            if (header.indexOf("GET /19/on") >= 0) {
              Serial.println("GPIO 19 on");
              table = table + (1<<2);
              Serial.println("Table is");
              Serial.println(table);
              client.println("GET /19/on");
            }
            if (header.indexOf("GET /20/on") >= 0) {
              Serial.println("GPIO 20 on");
              table = table + (1<<3);
              Serial.println("Table is");
              Serial.println(table);
              client.println("GET /20/on");
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
    Serial.println("table is");
    Serial.println(table);

    tables[j] = table;
}

    if (i<3)
      i++;
    else
      i = 0;
  
  words = "Please take your orders";
  printTables = String(tables[i]);
  
   // set cursor to first column, first row
  lcd.setCursor(0, 0);
  // print message
  lcd.print(words);
  delay(1000);
  // clears the display to print new message
  // set cursor to first column, second row
  lcd.setCursor((i*7),1);
  lcd.print(printTables);
  delay(1000);
  lcd.clear(); 
}
