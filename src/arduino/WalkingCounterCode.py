#!/usr/bin/python
import serial
import time
import MySQLdb
import time
from datetime import datetime
from time import sleep
from timeit import default_timer as timer

#The following line is for serial over GPIO
port = 'COM4'
ard = serial.Serial(port,9600,timeout=5)
time.sleep(2)

#Variables
distance = 0
change = 0
#Enter Database Info Here
log_info = ["XXXSERVERXXX", "XXXUSERNAMEXXX", "XXXPASSWORDXXX", "XXXDATABASEXXX"];

# this record will contains an auto increment id and timestamp
def add_record():
	db = MySQLdb.connect(host = log_info[0],user = log_info[1],passwd = log_info[2],db = log_info[3]);
	cursor = db.cursor();
# also revise the table name if needed
	sql = """INSERT INTO WalkingCounterDatabase () 
			VALUES (null, CURRENT_DATE, CURRENT_TIME)"""
	try:
		cursor.execute(sql)
		db.commit();
	except:
		db.rollback();
	db.close();

#buffer reading	
buffer = ard.readline()

#While loop will read in sensor data from Serial and check if someone enters or exits
while (1):
	msg_new = ard.readline()
	m_new = msg_new.split(" ")
	
	firstSensor = float(m_new[0])
	secondSensor = float(m_new[1])
	
	#Triggers if first sensor is broken then waits for second sensor to
	#trigger and will add an entry to the database
	if (firstSensor < 100):
		while (secondSensor > 100):
			msg_new = ard.readline()
			m_new = msg_new.split(" ")
			
			firstSensor = float(m_new[0])
			secondSensor = float(m_new[1])
		print("Person Entered: Entry added to DB")
		add_record() #adds DB entry
		time.sleep(.5)
	
	#This section was used for testing
	#Works same as above but will check for exiting
	#This can be uncommented if exiting data is wanted
	#if (secondSensor < 100):
	#	while (firstSensor > 100):
	#		msg_new = ard.readline()
	#		m_new = msg_new.split(" ")
	#		
	#		firstSensor = float(m_new[0])
	#		secondSensor = float(m_new[1])
	#	#print("Exit")
	#	time.sleep(.5)