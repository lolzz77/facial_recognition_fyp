import cv2
import os
import connect_database as db #connect_database is a .py file

cam = cv2.VideoCapture(0)
cam.set(3, 640) # set video width
cam.set(4, 480) # set video height
face_detector = cv2.CascadeClassifier('Cascades/haarcascade_frontalface_default.xml')
# For each person, enter one numeric face id
name_input = input('\n Enter name: ')
face_id = input('\n Enter ID: ')
print("\n [INFO] Initializing face capture. Look the camera and wait ...")
# Initialize individual sampling face count
count = 0

while(True):
    ret, img = cam.read()
    img = cv2.flip(img, 1) # flip video image vertically
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    faces = face_detector.detectMultiScale(gray, 1.3, 5)
    for (x,y,w,h) in faces:
        cv2.rectangle(img, (x,y), (x+w,y+h), (255,0,0), 2)     
        count += 1
        # Save the captured image into the dat
        # asets folder
        if(count>10): 
            cv2.imwrite("dataset/" + str(name_input) + "." + str(face_id) + ".png", gray[y:y+h,x:x+w])
    cv2.imshow('image', img)
    k = cv2.waitKey(100) & 0xff 
    # Press 'ESC' for exiting video
    if k == 27:
        break
    elif count >= 15: # Take 15 face sample and stop video
        break

#Upload to database
upload = open('dataset\\' + str(name_input) + '.' + str(face_id) + '.png' , 'rb').read()
sql = '''INSERT INTO image (emp_id, image) 
VALUES (%s,%s)'''
args = (face_id, upload) #This refers to replace %s
mycursor = db.conn.cursor() #Define mycursor
mycursor.execute(sql, args) #Dont know
db.conn.commit() #This code is needed in order to insert into db

# Do a bit of cleanup
print("\n [INFO] Exiting Program and cleanup stuff")
cam.release()
cv2.destroyAllWindows()