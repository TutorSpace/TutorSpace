import csv
import mysql.connector


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
    my_db = mysql.connector.connect(
        host="www.joinme.us",
        user="joinmeus_db_user",
        password="Lsq987069!",
        database="joinmeus_tutorspace_db",
        port="3306"
    )
    my_cursor = my_db.cursor()\

    # Tags
    tags = []
    tags += read_from_csv('tags.csv')
    tags += read_from_csv('buildings.csv')

    my_cursor.execute(u"TRUNCATE TABLE tags;")
    values = [[item] for item in tags]
    my_cursor.executemany(u"INSERT INTO `tags`(`tag`) VALUES (%s)", values)

    # Courses
    courses = []
    courses += read_from_csv('courses.csv')

    my_cursor.execute(u"TRUNCATE TABLE courses;")
    values = [[item] for item in courses]
    my_cursor.executemany(u"INSERT INTO `courses`(`course`) VALUES (%s)", values)

    # Majors
    majors = []
    majors += read_from_csv('majors.csv')

    my_cursor.execute(u"TRUNCATE TABLE majors;")
    values = [[item] for item in majors]
    my_cursor.executemany(u"INSERT INTO `majors`(`major`) VALUES (%s)", values)

    # Minors
    minors = []
    minors += read_from_csv('minors.csv')

    my_cursor.execute(u"TRUNCATE TABLE minors;")
    values = [[item] for item in minors]
    my_cursor.executemany(u"INSERT INTO `minors`(`minor`) VALUES (%s)", values)

    my_db.commit()
