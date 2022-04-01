#This version is Python GUI, no more HTML, CSS, Javascript
#This file can connect to MySQL, retrieve data from the 'account' table
#This file also can call PHP script externally
#Then it reads out what's inside the PHP


import tkinter as tk 
import mysql.connector 
from tkinter import *
import PIL 
import subprocess #This one i include one, to call PHP script in Python

#This function i define one, to call PHP script in Python
def callphp():
	# if you want output
	proc = subprocess.Popen(['php', 'C:/Users/AsusROG/source/repos/FaceRecognition/FaceRecognition/php/a.php'], shell=True, stdout=subprocess.PIPE)
	script_response = proc.stdout.read()
	print(script_response)

def submitact(): 
	
	user = Username.get() 
	passw = password.get() 

	print(f"The name entered by you is {user} {passw}") 

	logintodb(user, passw) 


def logintodb(user, passw): 
	
	# If paswword is enetered by the 
	# user 
	if passw: 
		db = mysql.connector.connect(host ="localhost", 
									user = user, 
									password = passw, 
									db ="face_recognition") 
		cursor = db.cursor() 
		
	# If no password is enetered by the 
	# user 
	else: 
		db = mysql.connector.connect(host ="localhost", 
									user = user, 
									db ="face_recognition") 
		cursor = db.cursor() 
		
	# A Table in the database 
	savequery = "select * from account"
	
	try: 
		cursor.execute(savequery) 
		myresult = cursor.fetchall() 
		
		# Printing the result of the 
		# query 
		for x in myresult: 
			print(x) 
		print("Query Excecuted successfully") 
		
	except: 
		db.rollback() 
		print("Error occured") 


root = tk.Tk() 
root.geometry("300x300") 
root.title("DBMS Login Page") 

C = Canvas(root, bg ="blue", height = 250, width = 300) 

# Definging the first row 
lblfrstrow = tk.Label(root, text ="Username -", ) 
lblfrstrow.place(x = 50, y = 20) 

Username = tk.Entry(root, width = 35) 
Username.place(x = 150, y = 20, width = 100) 

lblsecrow = tk.Label(root, text ="Password -") 
lblsecrow.place(x = 50, y = 50) 

password = tk.Entry(root, width = 35) 
password.place(x = 150, y = 50, width = 100) 

submitbtn = tk.Button(root, text ="Login", 
					bg ='blue', command = callphp) #To change what function the button does, chg here
submitbtn.place(x = 150, y = 135, width = 55) 

root.mainloop() 
