#include <Adafruit_NeoPixel.h>
#include <WiFi.h>

// WiFi credentials
const char* ssid = "ASUS 1986";
const char* password = "0560g4Q[";

// NeoPixel configuration
Adafruit_NeoPixel pixels = Adafruit_NeoPixel(5, 4, NEO_GRB + NEO_KHZ800);

// Pin assignments
#define SPEAKER 2

// Web server configuration
WiFiServer server(80);
String header;
unsigned long currentTime = millis();
unsigned long previousTime = 0;
const long timeoutTime = 2000;

// Function declarations
void chirp();
void meow();
void meow2();
void mew();
void ruff();
void arf();
void nobitaSound();
void playTone(uint16_t tone1, uint16_t duration);

void setup() {
  Serial.begin(9600);
  pinMode(SPEAKER, OUTPUT);
  //pinMode(output25, OUTPUT);
  pixels.begin();
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

  getLedOff();
}

void loop() {
  // Control NeoPixel LEDs
//  pixels.setPixelColor(0, 0x33cc00);
//  pixels.setPixelColor(1, 0x33cc00);
//  pixels.setPixelColor(2, 0x33cc00);
//  pixels.setPixelColor(3, 0xff0000);
//  pixels.setPixelColor(4, 0xff0000);
//  pixels.show();
//  pixels.show();
  
  // Play sound
 // meow();

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

            // Process specific requests
            if (header.indexOf("GET /16/on") >= 0) {
              Serial.println("GPIO 16 on");
              meow();
              Serial.println("meow");
              client.println("<h2>meow meow</h2>");
            }

             if (header.indexOf("GET /25/on") >= 0) {
              Serial.println("GPIO 25 on");
              //digitalWrite(output25, HIGH);
              getLedOn();
              Serial.println("Seat 01 booked");
              client.println("<h2>Seat 01 booked</h2>");
            }
            
            // Send HTML web page
            client.println("<!DOCTYPE html><html>");
            client.println("<head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">");
            client.println("<link rel=\"icon\" href=\"data:,\">");
            client.println("<style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}");
            client.println(".button { background-color: #4CAF50; border: none; color: white; padding: 16px 40px;");
            client.println("text-decoration: none; font-size: 30px; margin: 2px; cursor: pointer;}</style></head>");
            
            client.println("<body><h1>ESP32 Web Server</h1>");
            client.println("<p><a href=\"/16/on\"><button class=\"button\">Book Seat 25</button></a></p>");
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
}

// Sound generation functions
void chirp() {
  for (uint8_t i = 200; i > 180; i--)
    playTone(i, 9);
}

void meow() {
  uint16_t i;
  uint16_t j;

  for (j=0;j<10;j++){
      delay(1000);
      playTone(5100, 40);
      playTone(194, 200);
        for (i = 590; i < 622; i += 4)
        playTone(i, 40);
        playTone(2700, 200);
  }
}

void meow2() {
  uint16_t i;
  playTone(5100, 1100);
  playTone(394, 3400);
  delay(600);
  for (i = 330; i < 360; i += 2)
    playTone(i, 200);
  playTone(5100, 800);
}

void mew() {
  uint16_t i;
  playTone(5100, 55);
  playTone(394, 130);
  playTone(384, 35);
  playTone(5100, 40);
}

void ruff() {
  uint16_t i;
  for (i = 890; i < 910; i += 2)
    playTone(i, 3);
  playTone(1664, 150);
  playTone(12200, 70);
}

void arf() {
  uint16_t i;
  playTone(890, 25);
  for (i = 890; i < 910; i += 2)
    playTone(i, 5);
  playTone(4545, 80);
  playTone(12200, 70);
}

void playTone(uint16_t tone1, uint16_t duration) {
  if (tone1 < 50 || tone1 > 15000) return;
  for (long i = 0; i < duration * 1000L; i += tone1 * 2) {
    digitalWrite(SPEAKER, HIGH);
    delayMicroseconds(tone1);
    digitalWrite(SPEAKER, LOW);
    delayMicroseconds(tone1);
  }
}

void getLedOn(){
  pixels.setPixelColor(0, 0x33cc00);
  pixels.setPixelColor(1, 0x33cc00);
  pixels.setPixelColor(2, 0x33cc00);
  pixels.setPixelColor(3, 0x33cc00);
  pixels.setPixelColor(4, 0x33cc00);
  pixels.show();
  pixels.show();

}


void getLedOff(){
  pixels.setPixelColor(0, 0xff0000);
  pixels.setPixelColor(1, 0xff0000);
  pixels.setPixelColor(2, 0xff0000);
  pixels.setPixelColor(3, 0xff0000);
  pixels.setPixelColor(4, 0xff0000);
  pixels.show();
  pixels.show();
  
}
