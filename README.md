# TutorSpace

## Website: https://tutorspace.joinme.us/

## Promotion Page: https://www.tutorspace.info

## Instagram: https://www.instagram.com/tutorspaceusc/

<!-- ## Prototype project: https://tutor.joinme.us
### This prototype project is created by Shuaiqing Luo in Spring 2020 and is already fully functional. Wishing to build the largest tutor matching service platform in California that provides best user experience, he decided to revamp all the frontend design and backend functionalities, which then turned into the current product of TutorSpace. 

### TutorSpace has gathered a group of professional and passionate developers, designers, and marketing specialists. If you are interested in joining TutorSpace, please contact us at tutorspaceusc@gmail.com -->

## Sample Tutor Account:
```
Email: tutor@usc.edu
Password: password
```

## Sample Student Account:
```
Email: student@usc.edu
Password: password
```



### ======================== `RESOURCES` ========================
1. [**Github**](https://github.com/TutorSpace/TutorSpace)
2. [**Trello**](https://trello.com/tutorspace1/home)
3. [**Figma**](https://www.figma.com/file/5fTGR3CI0dBXJgsb7gp3ev/Tutor?node-id=0%3A1)

### ====================== `ALL DEVELOPERS` ======================
1. ***NEVER*** push directly to the ***MASTER*** branch. Create your own branches and make pull requests to ***DEVELOP*** branch.
2. Pull from ***DEVELOP*** branch regularly to make sure you get the most updated code. If there’s a merge conflict you don’t know how to solve, please let other developers know and we can figure it out together.
3. We are using the **Agile** methodology, so it would be best if all our developers can follow the following rules:
    1. Our sprint cycle is ***ONE WEEK***. Everyone’s tasks are listed in Trello. Remember to update the tasks before the end each sprint cycle by adding description to the tasks. Remember not to move the tasks to a different list, since we will do it together in our daily meeting. (The meeting time has yet to be decided.)
    2. Please always notify others about 1) What features/tasks have you accomplished last 1 - 2 days and 2) What features/tasks do you plan to work on next 1 - 2 days. 
        > **Please update these every 1 or 2 days in our slack room.**
4. Try ***adding comment*** to your code as much as possible
5. Avoid Repetitive Code (***DRY***)
6. If you see any bugs in our project or you have any concerns about the existing functionalities( no matter it’s frontend or backend), please report it directly in the corresponding slack channel or take a note of it and bring it up in our next weekly meeting.
7. If there is anything you did not finish yet or you want to work on later in the future, please put some comments around them with a format of `TODO: xxxxxx`
8. Import commands to run our project:
    1. First check your `.env` file exists in the root directory of the project, and the credentials inside it can either connect to your local database or the `joinmeus_tutorspace_db` database.
    2. Run `php artisan serve` and `php artisan queue:work` to start running the project. By default, you should be able to see the project by entering `localhost:8000` in your browser if the port 8000 is not occupied.
    3. Run `npm install` to install all required packages
    4. Run `npm run watch` to compile all js/css files (very useful for our ***FrontEnd*** developers)
    5. Run `php artisan migrate:refresh --seed` to refresh & seed the database


## ====================== `BACKEND DEVELOPERS` ======================
1. Debug at `localhost:8000/telescope`, where you can access the exact queries you executed and their runtime, cache, queues, scheduled tasks, .etc
2. Runtime is of our ***TOP*** priority. Try to optimize runtime using techniques like CACHE, QUEUES, EAGER LOADING, and more beyond.
3. Keep code ***STRUCTURED***
4. Please restructure/optimize existing code wherever you see a potential to improve. (***Just make sure you fully tested it after you modified the code to guarantee it really works. If you know some part of the program can be improved/optimized but dont want to modify it right away, please leave a "todo" comment near it so that we can modify it sometime in the future***)
5. Most Useful Sections in Laravel's Official Documentation : (***PLEASE READ ALL THE ONES MARKED WITH * FIRST, AS THEY ARE THE MOST IMPORTANT ONES!***)
    1. Architecture Concepts:
        1. Facades
    2. The Basics 
        1. Routing (*)
        2. Middleware (*)
        3. CSRF Protection
        4. Controllers (*)
        5. Requests (*)
        6. Responses
        7. Views
        8. Session (*)
        9. Validation (*)
    3. Digging Deeper
        1. Cache (*)
        2. Collections
        3. Events
        4. Helpers (*)
        5. Notifications
        6. Queues
        7. Task Scheduling
    4. Database
        1. Getting Started
        2. Query Builder (*)
        3. Migrations (*)
        4. Seeding
    5. Eloquent ORM
        1. Getting Started
        2. Relationships (*)
        3. Collections (*)
        4. Mutators (*)



<!-- 

## Screenshots
### Index Page:
![Schema Picture](screenshots/index.png)

### Login Page:
![Schema Picture](screenshots/login.png)

### Sign Up Page:
![Schema Picture](screenshots/signup.png)

### Home Page - Tutor:
![Schema Picture](screenshots/home_tutor.png)

### Home Page - Student:
![Schema Picture](screenshots/home_student.png)

### Forum:
![Schema Picture](screenshots/forum.png)

### Forum (post detail):
![Schema Picture](screenshots/post_detail.png)

### Forum (create new post):
![Schema Picture](screenshots/create_new_post.png)

### Search:
![Schema Picture](screenshots/search.png)
 -->
