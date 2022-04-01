import connect_database as db #connect_database is a .py file
import datetime
import numpy as np
from datetime import date #Date
from datetime import datetime #Time

mycursor = db.conn.cursor(buffered=True) #To use the variable from a file, must call the file name
#I get the error 'Unread result found' and forced to put buffered=True into argument

today = date.today() #Get today's date
d = today.strftime("%Y-%m-%d") #Date format: 2021-02-28
now = datetime.now() #Get current time
t = now.strftime("%H:%M:%S") #Time format: 10:05:30

id = 1

sql_flag = """UPDATE timestamp 
            SET t_afternoon_break = IF(t_afternoon_break IS NULL, %s, 
            WHERE date = %s
            AND emp_id = %s"""

mycursor.execute(sql_flag, (d,id))
flag_fetch = mycursor.fetchone()
dateData, shift = flag_fetch

print(a)