import connect_database as db #connect_database is a .py file
from datetime import date #Date
from datetime import datetime #Time

mycursor = db.conn.cursor()
now = datetime.now() #Output: 2021-03-31 04:29:50.907235
currTime = now.strftime("%H:%M:%S") #Current TIme: Output: 04:29:50

today = date.today() #Get today's date
d = today.strftime("%Y-%m-%d") #Date format: 2021-02-28

#Define time
a0800 = now.replace(hour=8, minute=0, second=0, microsecond=0)
a1230 = now.replace(hour=12, minute=30, second=0, microsecond=0)
a1330 = now.replace(hour=13, minute=30, second=0, microsecond=0)
a1700 = now.replace(hour=17, minute=0, second=0, microsecond=0)
a1600 = now.replace(hour=16, minute=0, second=0, microsecond=0)
a2130 = now.replace(hour=21, minute=30, second=0, microsecond=0)

#For determining time slot: Morning/Afternoon/Evening for attendance taking
#Morning
m0800 = now.replace(hour=8, minute=0, second=0, microsecond=0)
m1230 = now.replace(hour=12, minute=30, second=0, microsecond=0)
m1330 = now.replace(hour=13, minute=30, second=0, microsecond=0)
m1700 = now.replace(hour=17, minute=0, second=0, microsecond=0)

#Afternoon
a1230 = now.replace(hour=12, minute=30, second=0, microsecond=0)
a1600 = now.replace(hour=16, minute=0, second=0, microsecond=0)
a1700 = now.replace(hour=17, minute=0, second=0, microsecond=0)
a2130 = now.replace(hour=21, minute=30, second=0, microsecond=0)

#Full
f0800 = now.replace(hour=8, minute=0, second=0, microsecond=0)
f1230 = now.replace(hour=12, minute=30, second=0, microsecond=0)
f1330 = now.replace(hour=13, minute=30, second=0, microsecond=0)
f1600 = now.replace(hour=16, minute=0, second=0, microsecond=0)
f1700 = now.replace(hour=17, minute=0, second=0, microsecond=0)
f2130 = now.replace(hour=21, minute=30, second=0, microsecond=0)




def Attendance(shift, date, emp_id, time):
    sql = '''SELECT *
    FROM timestamp
    WHERE emp_id = %s AND
    date = %s'''
    mycursor.execute(sql, (emp_id, date))
    fetch = mycursor.fetchone()
    print(shift, date, emp_id, time)
    if (emp_id == 0): #Not needed, but it's good to put just in case
        print("ID 0 is detected")
        return
    if (shift == 'morning' or shift == 'Morning'):
        if (now < m0800): #Morning 8am start work
            sql = """INSERT INTO timestamp (t_morning, date, emp_id)
            VALUES (%s, %s, %s)"""
        elif (m0800<= now <m1230): #meantime of 8am working
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_morning, date, emp_id)
            VALUES (%s, %s, %s)""" 
            else:
                return
        elif (m1230<= now <m1330): #Break time 12:30pm - 1.30pm
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_afternoon_break, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_afternoon_break = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        elif (m1330<= now <m1700): #Meantime of 1.30-5pm working
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_afternoon, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_afternoon = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        elif (m1700 < now): #End of work 5pm
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_end, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_end = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        mycursor.execute(sql, (time, date, emp_id))
        db.conn.commit()
        sql = ''

    elif (shift == 'afternoon' or shift == 'Afternoon'):
        if (now < a1230): #Afternoon 12.30 start work
            sql = """INSERT INTO timestamp (t_afternoon, date, emp_id)
            VALUES (%s, %s, %s)"""
        elif (a1230<= now <a1600): #meantime of 8am working
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_afternoon, date, emp_id)
            VALUES (%s, %s, %s)""" 
            else:
                return
        elif (a1600<= now <a1700): #Break time 4pm - 5pm t_evening_break
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_evening_break, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_evening_break = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        elif (a1700<= now <a2130): #Meantime of 5pm-9:30pm working t_evening
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_evening, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_evening = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        elif (a2130 < now): #End of work 9:30pm t_end
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_end, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_end = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        mycursor.execute(sql, (time, date, emp_id))
        db.conn.commit()

    elif (shift == 'full' or shift == 'Full'):
        if (now < f0800): #start work 8am
            sql = """INSERT INTO timestamp (t_morning, date, emp_id)
            VALUES (%s, %s, %s)"""
        elif (f0800<= now <f1230): #meantime of 8am working
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_morning, date, emp_id)
            VALUES (%s, %s, %s)""" 
            else:
                return
        elif (f1230<= now <f1330): #Break time 12:30pm - 1:30pm
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_afternoon_break, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_afternoon_break = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        elif (f1330<= now <f1600): #Meantime of afternoon work 1:30pm - 4pm
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_afternoon, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_afternoon = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        elif (f1600<= now <f1700): #Break time 4pm - 5pm
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_evening_break, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_evening_break = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        elif (f1700<= now <f2130): #Meantime of evening work 5pm - 9:30pm
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_evening, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_evening = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        elif (f2130 < now): #End of work 9:30pm
            if (fetch is None):
                sql = """INSERT INTO timestamp (t_end, date, emp_id)
            VALUES (%s, %s, %s)"""
            else:
                sql = """UPDATE timestamp 
                SET t_end = %s 
                WHERE date = %s 
                AND emp_id = %s"""
        mycursor.execute(sql, (time, date, emp_id))
        db.conn.commit()