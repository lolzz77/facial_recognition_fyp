import cv2 #Facial recognition
import numpy as np
import os 
from datetime import date #Date
from datetime import datetime #Time
import mysql.connector
import connect_database as db #connect_database is a .py file
import check_time as ct #check_time is a .py file


mycursor = db.conn.cursor()


#Get names from db
mycursor.execute("SELECT emp_id, first_n, middle_n, last_n FROM employee")
names = mycursor.fetchall() #Get names from db
#Assigning values to pairs using "Dictionary method"
pair = {0:"Unknown"} #Define dictionary with pre-value
for index, tup in enumerate(names): #Iterating through tuple
    a = tup[0] #assign emp_id to a
    b = tup[1] + " " + tup[2] + " " + tup[3] #assign names to b
    pair[a] = b #Assigning the pair value using "Dictionary method", doing this will auto append
    #To assess dictionary, print(pair[1]), the 1 is one of value of "a"

recognizer = cv2.face.LBPHFaceRecognizer_create() #LBPH Algorithm here
recognizer.read('trainer/trainer.yml')
cascadePath = "Cascades/haarcascade_frontalface_default.xml" #Stored in D:\Documents\repos\FacialRecognition\FaceRecognition
faceCascade = cv2.CascadeClassifier(cascadePath);
font = cv2.FONT_HERSHEY_SIMPLEX

id = 0 #To indicate "unknown" if unknown face scanned
 
# Initialize and start realtime video capture
cam = cv2.VideoCapture(0)
cam.set(3, 640) # set video widht
cam.set(4, 480) # set video height# Define min window size to be recognized as a face
minW = 0.1*cam.get(3) #Size for the rectangle
minH = 0.1*cam.get(4) #Size for the rectangle

while True:
    today = date.today() #Get today's date
    d = today.strftime("%Y-%m-%d") #Date format: 2021-02-28
    now = datetime.now() #Get current time
    t = now.strftime("%H:%M:%S") #Time format: 10:05:30

    ret, img =cam.read()
    img = cv2.flip(img, 1) #Camera image
    gray = cv2.cvtColor(img,cv2.COLOR_BGR2GRAY) #Grayscaled image
    
    faces = faceCascade.detectMultiScale( 
        gray,
        scaleFactor = 1.2,
        minNeighbors = 5,
        minSize = (int(minW), int(minH)),
       ) #Define how to detect face
    for(x,y,w,h) in faces: #Put rectangle on detected face
        cv2.rectangle(img, (x,y), (x+w,y+h), (0,255,0), 2)
        emp_id, confidence = recognizer.predict(gray[y:y+h,x:x+w])
                # If confidence is less them 100 ==> "0" : perfect match 
        if (confidence < 80):
            id = emp_id
            confidence = "  {0}%".format(round(100 - confidence))
        else:
            id = 0 #0 to indicate "unknown"
            confidence = "  {0}%".format(round(100 - confidence))
        
        cv2.putText(
                    img, 
                    str(id), 
                    (x+5,y-5), 
                    font, 
                    1, 
                    (255,255,255), 
                    2
                   )
        cv2.putText(
                    img, 
                    pair[id],  
                    (x+30,y-5), 
                    font, 
                    1, 
                    (255,255,255), 
                    2
                   )
        cv2.putText(
                    img, 
                    str(confidence), 
                    (x+5,y+h-5), 
                    font, 
                    1, 
                    (255,255,0), 
                    1
                   ) 
        cv2.putText(
                    img, 
                    str(t), 
                    (x+5,y+h+30), 
                    font, 
                    1, 
                    (255,255,0), 
                    1
                   ) 
        cv2.putText(
                    img, 
                    str(d), 
                    (x+5,y+h+60), 
                    font, 
                    1, 
                    (255,255,0), 
                    1
                   ) 

    
    cv2.imshow('camera',img) 
    k = cv2.waitKey(10) & 0xff # Press 'ESC' for exiting video
    if k == 27:
       break

# Do a bit of cleanup
print("\n [INFO] Exiting Program and cleanup stuff")
cam.release()
cv2.destroyAllWindows()

sql_flag = """SELECT date, shift
FROM flag
WHERE date = %s AND
emp_id = %s"""

mycursor.execute(sql_flag, (d,id))
flag_fetch = mycursor.fetchone()
if (flag_fetch is not None):
    dateData, shift = flag_fetch
    ct.Attendance(shift, dateData, id, t)
else:
    print("Flag not found for this employee")