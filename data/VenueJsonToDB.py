'''
@summary: Converts output of VenueCrawler.py to CSV
@author: Philip Wardlaw
Created on Dec 30, 2015

STAND ALONE SCRIPT
'''
import json as J
import sys
import codecs
import sqlite3 as lite

delim = '\t'


def stripChars(aString):
    return aString.replace('\t', ' ') \
                  .replace('\n', ' ') \
                  .replace('\r', ' ')

if __name__ == '__main__':

    if len(sys.argv) != 2 or not sys.argv[1].count('.json'):
        print 'Please provide the file name of the JSON Venue file.'
        exit(1)

    print 'Creating database table'
    con = lite.connect('Venue.db')
    cur = con.cursor()

    cur.execute('CREATE TABLE IF NOT EXISTS'
                ' Venues(venueId TEXT UNIQUE,'
                ' name TEXT, lat NUMBER, long NUM, json TEXT);')

    print 'Reading JSON File'
    with codecs.open(sys.argv[1], 'r', encoding='UTF-8') as fp:
        json = J.load(fp)

    print 'Writing to DB'
    for key in json:
        venue = json[key]
        qryData = (key,
                   venue['name'],
                   venue['location']['lat'],
                   venue['location']['lng'],
                   J.dumps(venue))

        cur.execute("INSERT INTO Venues VALUES(?, ?, ?, ?, ?);", qryData)

    con.commit()
    print 'Finished'
