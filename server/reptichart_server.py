#!/usr/bin/env python3

import sys
import socket
import time
import types
import configparser
import threading
import sqlite3
import os

CONFIG = configparser.ConfigParser()
CONFIG.read("config.ini")
HOST = CONFIG.get("reptichart_server_vars", "host")
REPTILES = CONFIG.items("reptiles")
SOCKETS_CLEAN = True

# In process_reading, we process the reading!
# Split the string down into the bits of data, and insert it into the db with sqlite3

def process_reading(readingstring):
    readingstringList = readingstring.split("|", 7)

    readingname = readingstringList[1]
    dbtype = readingstringList[2]
    readingdatetime = readingstringList[3]
    readingtemp = readingstringList[4]
    readinghumi = readingstringList[5]

    try:
        # create/open the db
        db = sqlite3.connect('reptichart_readings.db')
        # make a cursor
        cursor = db.cursor()
        # check the table for this name exists, create if not
        cursor.execute("CREATE TABLE IF NOT EXISTS reptichart_{}_{}\
                (id INTEGER PRIMARY KEY AUTOINCREMENT,timedate VARCHAR(22)\
                ,temperature DECIMAL(4,2),humidity DECIMAL(4,2))".format(readingname, dbtype,))
        db.execute('''INSERT INTO reptichart_{}_{}\
                (timedate, temperature, humidity)\
                VALUES('{}','{}','{}')'''\
                .format(readingname, dbtype, readingdatetime, readingtemp, readinghumi))
        # commit to the change
        db.commit()

    # Catch the exception
    except Exception as e:
        # Roll back any change if something goes wrong
        db.rollback()
        raise e
    finally:
        # Close the db connection
        db.close()

# In open_listener, we open a socket, to listen out for readings sent in from sensor devices.
# when we recieve a reading on (port) , we invoke process_reading with it
def open_listener(port):
    # Set the SOCKETS_CLEAN variable to be global, so the script can exit if a socket couldn't open
    global SOCKETS_CLEAN

    # Create a TCP/IP socket
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    # Bind the socket to the port
    server_address = HOST, port
    print('starting up on {} port {}'.format(HOST, port))

    try:
        sock.bind(server_address)
    except Exception:
        SOCKETS_CLEAN = False
        raise Exception("\nCan't bind to port {} on ip {}.".format(port, HOST)
                        + "Check your config.ini\n")

    # Listen for incoming connections
    sock.listen(1)

    while True:
        # Wait for a connection
        print('Socket ready: waiting for a connection on port {}'.format(port))
        connection, client_address = sock.accept()
        try:
            print('connection from {}:{}'.format(client_address, port))

            # Receive the data , process it
            while True:
                data = connection.recv(4096)
                readingstring = format(data)
                print('received {!r}'.format(data))
                if data:
                    print('processing' + format(readingstring))
                    try:
                        process_reading(readingstring)
                    except Exception:
                        print('ERROR-PROCESSING-READING:' + format(readingstring))
                        print(Exception)
                else:
                    print('no data from', client_address)
                break

        finally:
            # Clean up the connection
            connection.close()

# Spawn a thread , with a socket listening
# for each reptile's sensor readings, on it's respective port.
for idnum, CONFIG in REPTILES:
    configlist = CONFIG.split(":")
    portnum = int(configlist[1])
    name = configlist[0]
    print("listening for " + name + "'s readings, on port : " + configlist[1])
    thread = threading.Thread(target=open_listener,
                              kwargs={'port':portnum},
                              daemon=True,
                              name=name,)
    thread.start()
    print("Thread alive: " + str(thread.is_alive()))

# Stop here if there was an issue opening sockets
#if SOCKETS_CLEAN is False:
#    print("sockets unclean")
#    sys.exit(1)
print("running")
# Monitor the threads
while True:
    print("")
    print("Running " + str(threading.active_count()) + "threads\n")
    print(threading.enumerate())
    time.sleep(60)
