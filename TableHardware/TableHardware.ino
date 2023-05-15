#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "ASUS 1986";
const char* password = "0560g4Q[" ;

WiFiServer server(80);

// Variable to store the HTTP request
String request;

// Auxiliar variables to store the current output state
String output26State = "off";
String output27State = "off";

// Assign output variables to GPIO pins
const int output26 = 26;
const int output27 = 27;

unsigned long currentTime = millis();
// Previous time
unsigned long previousTime = 0; 
// Define timeout time in milliseconds (example: 2000ms = 2s)
const long timeoutTime = 2000;

void setup(){

  Serial.begin(9600);

  // Initialize the output variables as outputs
  pinMode(output26, OUTPUT);
  pinMode(output27, OUTPUT);

  // Set outputs to LOW
  digitalWrite(output26, LOW);
  digitalWrite(output27, LOW);

  // Connect to Wi-Fi network with SSID and password
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  // Print local IP address and start web server
  Serial.println("");
  Serial.println("WiFi connected.");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  server.begin();
}

void loop(){
  // Check if a client has connected
  WiFiClient client = server.available();
  if (client) {
    // Wait for data from client to become available
    while (client.connected() && !client.available()) delay(1);
    
    // Read the first line of the request
    request = client.readStringUntil('\r');
    if (request){
      Serial.println(server.arg("bit"));
    }
    client.flush();
    
    // Extract the bit from the request
    int bit = server.arg("bit").toInt());
    if (bit == 1){
      printf("GP26 light up");
    } printf("GP26 dim");
    
    // Turn on GP26 if the bit is one
    if (bit == 1) {
      digitalWrite(output26, HIGH);
      output26State = "on";
    } else {
      digitalWrite(output26, LOW);
      output26State = "off";
    }
    
    // Prepare the response
    String response = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n";
    response += "<!DOCTYPE HTML>\r\n<html>\r\n";
    response += "GP26 is " + output26State + "<br>\r\n";
    response += "</html>\n";
    
    // Send the response to the client
    client.print(response);
    
    // Wait for some time to stabilize before closing the connection
    delay(10);
    client.stop();
  }
}
