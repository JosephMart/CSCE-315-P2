/*
* Ultrasonic Sensor HC-SR04 and Arduino Tutorial
*
* Crated by Dejan Nedelkovski,
* www.HowToMechatronics.com
*
*/

// defines pins numbers
// Sensor 1
const int trigPin = 9;
const int echoPin = 10;
// Sensor 2
const int trigPin1 = 11;
const int echoPin1 = 12;

// defines variables
// Sensor 1
long duration;
int distance;
// Sensor 2
long duration1;
int distance1;

void setup() {
  pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
  pinMode(echoPin, INPUT); // Sets the echoPin as an Input
  pinMode(trigPin1, OUTPUT); // Sets the trigPin1 as an Output
  pinMode(echoPin1, INPUT); // Sets the echoPin1 as an Input
  Serial.begin(9600); // Starts the serial communication
}

void loop() {
  // Clears the trigPin
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  
  // Sets the trigPin on HIGH state for 10 micro seconds
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);
  
  // Reads the echoPin, returns the sound wave travel time in microseconds
  duration = pulseIn(echoPin, HIGH);

  //Delay to reduce sensor interference
  delay(60);

  //Clears the trigPin1
  digitalWrite(trigPin1, LOW);
  delayMicroseconds(2);

  // Sets the trigPin1 on HIGH state for 10 micro seconds
  digitalWrite(trigPin1, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin1, LOW);

  // Reads the echoPin1, returns the sound wave travel time in microseconds
  duration1 = pulseIn(echoPin1, HIGH);
  
  // Calculating the distance
  distance = duration*0.034/2;
  distance1 = duration1*0.034/2;

  //Send sensor data to the Serial
  Serial.print(distance);
  Serial.print(" ");
  Serial.println(distance1);
}
