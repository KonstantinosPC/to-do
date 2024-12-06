import mysql.connector
import keys
import hashlib
from getpass import getpass
from  datetime import date

mydb = mysql.connector.connect(
    host = keys.hostname,
    user = keys.username,
    password = keys.password,
    database = keys.database
)

name = ""
lastname = ""
today = date.today()

# Authenticator
def authenticator(username, password):
  global name, lastname
  mycursor = mydb.cursor()
  mycursor.execute("SELECT * FROM users WHERE username='" + username + "'")
  myresult = mycursor.fetchall()
  if(myresult):
    for i in myresult:
      if(hashlib.sha256(password.encode()).hexdigest() == i[2]):
        name = i[3]
        lastname = i[4]
        return True
      else:
        print("Wrong Password.Try again later!")
        return False
  else:
    print("Sorry but there is no user with that Username")
    return False

# Add Job
def addJob(job):
  if(job == "exit"):
    return False
  global name, lastname, mydb, today
  mycursor = mydb.cursor()
  
  sql = "INSERT INTO todolist (chore, user, day) VALUES (%s, %s, %s)"
  value = (job, name + " " + lastname, today)
  mycursor.execute(sql,value)
  mydb.commit()
  print("Chore:")
  print(f"Added {job} by {name} {lastname} at {today}")
  print("Added Successfully :D")
  return True

#Change Password
def changePassword(oldPassword, newPassword, confPassword):
  global password, mydb, username
  if(oldPassword != password):
    return False
  
  if(newPassword != confPassword):
    return False
  
  hash = hashlib.sha256(newPassword.encode()).hexdigest()
  sql = f"UPDATE users SET password='{hash}' WHERE username='{username}'"
  mydb.cursor().execute(sql)
  mydb.commit()
  return True

# Check
def checkId(id):
  global mydb, name, lastname
  try:
    mycursor = mydb.cursor()
    mycursor.execute(f"SELECT * FROM todolist WHERE id='{str(id)}'")
    myresult = mycursor.fetchall()
    for i in myresult:
      sql1 = f"INSERT INTO donelist (id, chore,doneby,day,oldAuthor,oldDay) VALUES (%s, %s, %s, %s, %s, %s)"
      values1 = (i[0], i[1], name + " " + lastname, today, i[2], i[3])
      mydb.cursor().execute(sql1, values1)
      mydb.commit()

      sql2 = f"DELETE FROM todolist WHERE id={str(id)}"
      mydb.cursor().execute(sql2)
      mydb.commit()
    return True
  except:
    return False

# Recover Chore

def recoverChore(id):
  global mydb, name, lastname
  try:
    mycursor = mydb.cursor()
    mycursor.execute(f"SELECT * FROM donelist WHERE id='{str(id)}'")
    myresult = mycursor.fetchall()
    for i in myresult:
      sql1 = f"INSERT INTO todolist (id, chore, user, day) VALUES (%s, %s, %s, %s)"
      values1 = (i[0], i[1], i[4], i[5])
      mydb.cursor().execute(sql1, values1)
      mydb.commit()

      sql2 = f"DELETE FROM donelist WHERE id={str(id)}"
      mydb.cursor().execute(sql2)
      mydb.commit()
    return True
  except:
    return False

# Remove Chore 
def removeChore(id):
  global mydb,name,lastname
  if(input(f"Are you sure you want to delete Job {id}? [Y/n]").lower() == "y"):
    mycursor = mydb.cursor()
    mycursor.execute(f"SELECT * FROM todolist WHERE id='{str(id)}'")
    myresult = mycursor.fetchall()
    for i in myresult:
      if(i[2] == (name + " " + lastname)):
        mydb.cursor().execute(f"DELETE FROM todolist WHERE id='{str(id)}'")
        mydb.commit()
        return True
      else:
        return False
  else:
    return False

def showToDo():
  mycursor = mydb.cursor()
  mycursor.execute("SELECT * FROM todolist")
  myresult = mycursor.fetchall()
  if(myresult):
    print("Id\t|Chore - Author - |Day\n")
    for i in myresult:
      print(f"{i[0]}\t| {i[1]} - {i[2]} - {i[3]}")
  else:
    print("The table of the database it's empty")
    return False
  
def showDone():
  mycursor = mydb.cursor()
  mycursor.execute("SELECT * FROM donelist")
  myresult = mycursor.fetchall()
  if(myresult):
    print("Id\t|Chore -  Done by - Done Day\n")
    for i in myresult:
      print(f"{i[0]}\t| {i[1]} - {i[2]} - {i[3]}")
  else:
    print("The table of the database it's empty")
    return False

username = input("Insert your Username:")
password = getpass("Insert your Password:")

if(authenticator(username,password)):
  print("Welcome to To-Do terminal")
  print("Type 'help' or '?' for help")

  escape = True
  while (escape):
    command = input("> ")

    if(command == "help" or command == "?"):
      print('''>>>>> Todo Commands <<<<<
- addjob - You can add a job in the to-do list
- check - You can check a job that is done
- recover - You can recover a job that is in the donelist
- todo - You can see all the jobs
- done - You can see all the jobs that are ready
- showall - Show todo and done
- remove - You can remove ONLY your own jobs
- passwd - You can change your password in your account
- exit - Leave the To-do's terminal''')
    elif(command == "addjob"):
      job = input("Insert your job:\n")
      addJob(job)
    elif(command == "passwd"):
      oldPass = getpass("Old Password:")
      newPass = getpass("New Password:")
      confPass = getpass("Confirm Password:")
      if(changePassword(oldPass, newPass, confPass)):
        print("Password Changed Successfully")
      else:
        print("Something went wrong. Please try again!")
    elif(command == "check"):
      try:
        id = int(input("Please insert that id of the job that you have done (Number):"))
        if(checkId(id)):
          print(f"Job {id} has been checked Successfully")
        else:
          print("Something went wrong. Please make sure that the Id that you given is valid")
      except:
        print("Something went wrong. Please try again!")
    elif(command == "recover"):
      try:
        id = int(input("Please insert that id of the job you want to recover (Number):"))
        if(recoverChore(id)):
          print(f"Job {id} has been recovered Successfully")
        else:
          print("Something went wrong. Please make sure that the Id that you given is valid")
      except:
        print("Something went wrong. Please try again!")
    elif(command == "remove"):
      try:
        id = int(input("Please insert the id that you want to remove (Number):"))
        if(removeChore(id)):
          print(f"Job {id} has been removed Successfully")
        else:
          print("Something went wrong. Please make sure that this is your chore.")
      except:
        print("Something went wrong. Please try again later!")
    elif(command == "todo"):
      showToDo()
    elif(command == "done"):
      showDone()
    elif(command == "showall"):
      print("-------------------[ToDo]-------------------")
      showToDo()
      print("-------------------[Done]-------------------")
      showDone()
    elif(command == "exit"):
      print("Goodbye :)")
      escape = False
    else:
      print('''Sorry but this command doesn't seem to exist.
Please use 'help' to see which commands are available''')

      

else:
  print("Auto exit!")
  print("Bye")