#include <Adafruit_NeoPixel.h>
 Adafruit_NeoPixel pixels = Adafruit_NeoPixel(5, 4, NEO_GRB + NEO_KHZ800);

#define SPEAKER 2
void chirp() {  // Bird chirp
  for(uint8_t i=200; i>180; i--)
     playTone(i,9);
}

void meow() {
  uint16_t i;
  playTone(5100,50);
  playTone(394,180);
  for(i=990; i<1022; i+=2)
     playTone(i,8);
  playTone(5100,40);
}

void meow2() {
  uint16_t i;
  playTone(5100,55);
  playTone(394,170);
  delay(30);
  for(i=330; i<360; i+=2)
     playTone(i,10);
  playTone(5100,40);
}

void mew() {  // cat mew
  uint16_t i;
  playTone(5100,55);
  playTone(394,130);
  playTone(384,35);
  playTone(5100,40);
}

void ruff() {   // dog ruff
  uint16_t i;
  for(i=890; i<910; i+=2)
     playTone(i,3);
  playTone(1664,150);
  playTone(12200,70);
}

void arf() {    // dog arf
  uint16_t i;
  playTone(890,25);
  for(i=890; i<910; i+=2)
     playTone(i,5);
  playTone(4545,80);
  playTone(12200,70);
}

// play tone on a piezo speaker: tone shorter values produce higher frequencies
//  which is opposite beep() but avoids some math delay - similar to code by Erin Robotgrrl

void playTone(uint16_t tone1, uint16_t duration) {
  if(tone1 < 50 || tone1 > 15000) return;  // these do not play on a piezo
  for (long i = 0; i < duration * 1000L; i += tone1 * 2) {
     digitalWrite(SPEAKER, HIGH);
     delayMicroseconds(tone1);
     digitalWrite(SPEAKER, LOW);
     delayMicroseconds(tone1);
  }
}


void setup() {
  pixels.begin();

    pinMode(SPEAKER,OUTPUT);  //

}

void loop() {
  pixels.setPixelColor(0, 0x33cc00);
  pixels.setPixelColor(1, 0x33cc00);
  pixels.setPixelColor(2, 0x33cc00);
  pixels.setPixelColor(3, 0xff0000);
  pixels.setPixelColor(4, 0xff0000);
  pixels.show();
  pixels.show();
  meow();

}
