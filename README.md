# itp460-Bravo

## Created Frontend Pages
1. [index page](http://www.joinme.us/test_bravo/)
2. [signup page (tutor + student)](http://www.joinme.us/test_bravo/signup_user.html)
3. [signup page (student)](http://www.joinme.us/test_bravo/signup_student.html)
4. [signup page (tutor)](http://www.joinme.us/test_bravo/signup_tutor.html)
5. [report tutor page](http://www.joinme.us/test_bravo/report_tutor.html)
6. [profile page (student)](http://www.joinme.us/test_bravo/profile_student.html)
7. [login (tutor + student)](http://www.joinme.us/test_bravo/login.html)
8. [edit profile page (student)](http://www.joinme.us/test_bravo/edit_profile_student.html)
9. [home page (student)](http://www.joinme.us/test_bravo/home_student.html)
10. [home page (tutor)](http://www.joinme.us/test_bravo/home_tutor.html)
11. [forget password page](http://www.joinme.us/test_bravo/forget_password.html)



## Development Steps:
1. Run "npm install" (if have not already installed NPM, please install it first)
2. Run "npm run start" and then go to localhost:8001 to see the web pages. (just save the css/scss files and the web page will be updated automatically, np need to refresh the pages)

##### Shuaiqing Luo

##### Nick LoCastro

##### Katelyn Designer

##### Sarah Selke

##### Sophia Park

<br /><br />

## Git Process:
1. Always work on our own branches when developing. (use ```git checkout <your branch name>``` in your project directory)<br /> 
    **Don't** directly work on the "master" branch or the "develop" branch.
2. After fully testing your code, use the following steps to push to your branch remotely on github so that others can integrate your code into their own branches
    - ```git add .``` 
    <br />**or**
     <br /> ```git add <filenames of the files that you newly created, such as index.html>```)
    - ```git commit -m <some description about why you are pushing these files to the remote branch so that others can understand what you are doing in this update, and it would also be helpful if we later want to reset to this update>```
    - ```git push origin <your branch name, such as Shuaiqing-frontend>```
    - Tell others on Slack that you just pushed your code on your branch, so that someone can merge it into "develop" branch (Shuaiqing will probably take care of it)
    - After Shuaiqing merge it into the **"develop"** branch, please use ```git pull origin develop``` to integrate the updated part into your project.
3. If we want to test the project, we can test it on the **"develop"** branch. 
4. If everything goes well on the **"develop"** branch, and we implemented/improved/modified some important functionalities (such as if we created the login page, created the searching functionality, or created the payment functionality), then we can create a new branch called ```release-<version number>``` and merge it to the **"master"** branch. This makes it easier for us to go back to a version if we find something goes wrong in the future development.

