#include "SevSeg.h"  /*Included seven-segment library*/
SevSeg sevseg;       /*Create a seven-segment library*/

void setup()
{
  byte sevenSegments = 1;  /*Number of connected seven-segment*/
  byte CommonPins[] = {};  /*Define Common pin of seven-segment*/
  byte LEDsegmentPins[] = {15, 2, 4, 5, 18, 19, 21};  /*Define ESP32 digital pins for seven-segment*/
  bool resistorsOnSegments = true; /*assigning Boolean type to the registers of the seven=segment*/
  sevseg.begin(COMMON_ANODE, sevenSegments, CommonPins, LEDsegmentPins, resistorsOnSegments);/*seven-segment configuration */
  sevseg.setBrightness(80);  /*Seven segment brightness*/
}
void loop()
{
   for(int i = 0; i < 10; i++)   /*Display number from 0 to 9 using for loop*/
   {
     sevseg.setNumber(i);
     sevseg.refreshDisplay(); /*Refresh seven-segment display after each iteration*/
     delay(1000);    /*Time delay for loop iteration*/
   }
}
