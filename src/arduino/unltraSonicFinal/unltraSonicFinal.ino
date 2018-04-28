#include <NewPing.h>

int t1=10; //Sensor Trig pin connected to Arduino pin 13
int e1=11;  //Sensor Echo pin connected to Arduino pin 11
int t2=5; //Sensor Trig pin connected to Arduino pin 13
int e2=6;  //Sensor Echo pin connected to Arduino pin 11
float pingTime;  //time for ping to travel from sensor to target and return
float targetDistance; //Distance to Target in inches
float speedOfSound=776.5; //Speed of sound in miles per hour when temp is 77 degrees.

void setup() {
    // put your setup code here, to run once:
    Serial.begin(9600);
    pinMode(t1, OUTPUT);
    pinMode(e1, INPUT);
    pinMode(t2, OUTPUT);
    pinMode(e2, INPUT);
}

void runSonic(int trigPin, int echoPin)
{
  
    digitalWrite(trigPin, LOW); //Set trigger pin low
    delayMicroseconds(2000); //Let signal settle
    digitalWrite(trigPin, HIGH); //Set trigPin high
    delayMicroseconds(15); //Delay in high state
    digitalWrite(trigPin, LOW); //ping has now been sent
    delayMicroseconds(10); //Delay in low state

    pingTime = pulseIn(echoPin, HIGH);  //pingTime is presented in microceconds
    pingTime=pingTime/1000000; //convert pingTime to seconds by dividing by 1000000 (microseconds in a second)
    pingTime=pingTime/3600; //convert pingtime to hourse by dividing by 3600 (seconds in an hour)
    targetDistance= speedOfSound * pingTime;  //This will be in miles, since speed of sound was miles per hour
    targetDistance=targetDistance/2; //Remember ping travels to target and back from target, so you must divide by 2 for actual target distance.
    targetDistance= targetDistance*63360;    //Convert miles to inches by multipling by 63360 (inches per mile)

    Serial.print(trigPin);
    Serial.print(": ");
    Serial.println(targetDistance);
}

void loop() {
    // put your main code here, to run repeatedly:
    runSonic(t1, e1);
    runSonic(t2, e2);
    delay(100); //delay tenth of a  second to slow things down a little.
}
