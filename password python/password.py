from cryptography.fernet import Fernet

def generate_key():
    key = Fernet.generate_key()
    with open("key.key", "wb") as key_file:
        key_file.write(key)


def load_key():
    with open("key.key", "rb") as file:
        key=file.read()
    return key

keys=load_key()
fer=Fernet(keys)

def add():
    username=input("enter a username: ")
    password=input("enter a password: ")
    encryptPassword=fer.encrypt(password.encode()).decode()
    with open('users.txt' ,'a') as f:
        f.write(username +"|"+  encryptPassword +"\n")


def view():
    with open('users.txt','r') as f:
        for line in f.readlines():
            data=line.rstrip()
            list=data.split("|")
            name,pwd = list
            print("Username: "+name +" , Password: "+fer.decrypt(pwd.encode()).decode())
    
while 1:
    mode=input("Do you want to add user or view existing ones(add,view,q), type q if you want to quit ").lower()
    if mode=="q":
        break
    if mode=="add":
        add()
    elif mode=="view":
        view()
    else:
        continue