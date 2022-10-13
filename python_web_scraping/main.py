import random
import csv
import mysql.connector
import os
from dotenv import load_dotenv

def read_from_csv(file_name):
    with open(file_name) as csv_file:
        res_list = []
        csv_reader = csv.reader(csv_file, delimiter=',')

        line_count = 0
        for row in csv_reader:
            if line_count == 0:
                line_count = 1
                continue
            res_list.append(row[1])
        return res_list


if __name__ == '__main__':
    load_dotenv()
    DB_HOST = os.getenv("DB_HOST")
    DB_PORT = os.getenv("DB_PORT")
    DB_DATABASE = os.getenv("DB_DATABASE")
    DB_USERNAME = os.getenv("DB_USERNAME")
    DB_PASSWORD = os.getenv("DB_PASSWORD")

    my_db = mysql.connector.connect(
        host = DB_HOST,
        user = DB_USERNAME,
        password = DB_PASSWORD,
        database = DB_DATABASE,
        port = "3306",
        auth_plugin = 'mysql_native_password'
    )
    my_cursor = my_db.cursor()\

    # print('current directory:', os.getcwd())
    os.chdir('python_web_scraping')

    # color pool
    colorPool = [
        '#A5BE0D',
        '#DF7649',
        '#A5D2D4',
        '#D2C2FF',
        '#F59300',
    ]

    colorDict = {}

    # Courses
    courses = []
    courses += read_from_csv('courses.csv')

    for course in courses:
        prefix = course.split(" ")[0]
        if not prefix in colorDict:
            colorDict[prefix] = random.choice(colorPool)

    values = [[item, colorDict[item.split(" ")[0]] if item.split(" ")[0] in colorDict else random.choice(colorPool)] for item in courses]

    my_cursor.executemany(u"INSERT INTO `courses`(`course`, `color`) VALUES (%s, %s)", values)

    # Tags
    tags = []

    tags += read_from_csv('courses.csv')
    tags += read_from_csv('tags.csv')
    tags += read_from_csv('buildings.csv')
    tags += read_from_csv('majors.csv')
    tags += read_from_csv('minors.csv')

    values = [[item, colorDict[item.split(" ")[0]] if item.split(" ")[0] in colorDict else random.choice(colorPool)] for item in tags]
    my_cursor.executemany(u"INSERT INTO `tags`(`tag`, `color`) VALUES (%s, %s)", values)

    # Majors
    majors = []
    majors += read_from_csv('majors.csv')

    values = [[item] for item in majors]
    my_cursor.executemany(u"INSERT INTO `majors`(`major`) VALUES (%s)", values)

    # Minors
    minors = []
    minors += read_from_csv('minors.csv')

    values = [[item] for item in minors]
    my_cursor.executemany(u"INSERT INTO `minors`(`minor`) VALUES (%s)", values)

    my_db.commit()
