import connect_database as db #connect_database is a .py file

mycursor = db.conn.cursor(buffered=True) #To use the variable from a file, must call the file name
#I get the error 'Unread result found' and forced to put buffered=True into argument

sql_id = """SELECT emp_id
FROM employee"""

mycursor.execute(sql_id)
id_fetch = mycursor.fetchall()
id = id_fetch
count = 0
space1 = " " #To append space to the first_n, middle_n, last_n
space2 = " " #To append space to the first_n, middle_n, last_n

for x in id_fetch:

    sql_img = """SELECT image
    FROM image
    WHERE emp_id = %s"""

    sql_name = """SELECT first_n, middle_n, last_n
    FROM employee
    WHERE emp_id = %s"""
    #If you use {}, then u have to use .format() at the end of string
    #If you use %s, then you have to add argument into mycrusor.execute() there

    mycursor.execute(sql_img, id[count])
    img_fetch = mycursor.fetchone() #fectchone() will return 'tuple' type
    mycursor.execute(sql_name, id[count])
    name_fetch = mycursor.fetchone()

    while img_fetch is not None:
        blob = img_fetch[0] #Always at index 0, dont ask me why
        img_fetch = mycursor.fetchone() #Have to repeat this code in order to retrieve the next image in db, also, this code is needed to break out of the inifinite loop
        if name_fetch[1] == "": #This if else statement is to handle empty middle_n
            name = name_fetch[0] + name_fetch[1] + space2 + name_fetch[2]
        else:
            name = name_fetch[0] + space1 + name_fetch[1] + space2 + name_fetch[2]
        #'name_fetch' has to use fetchone(), this will return 'tuple' data type
        #Then, from the tuple, get index of 0,1,2 to get first_n, middle_n, last_n string and store into 'name'
        #If you dont use this technique, python gonna print out ("preston", "", "lo)
        #Also, no need to repeat fetchone() for 'name_fetch' becos this is nested loop, the fetchone() on above will be executed again
        with open("dataset/{}".format(name) + "." + " ".join(map(str,id[count])) + ".png", 'wb') as file: #Mode: wb = write n binary, rb = read n binary
            file.write(blob)
        #If you have 'tuple' data type, u must use {} technique to concatenate the string
        #If not tuple type, you can use .join(map(str, $variable here)) to concatenate the string and avoid ("1",) kind of output

    count += 1 #This count is used for iterate 'id' index