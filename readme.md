The project comes from an already existing project designed by openclassroom, here it is accessible at the following address:
https://github.com/saro0h/project8-TodoList
As you will have been able to see if you had cloned this one, it was designed under a very old version of symfony here in this case version 3.2, moreover the version of PHP to be used is 5, therefore very depreciated.
Before making any type of modification we have chosen to migrate the version present under a much more recent version here the latest version 5 of symfony using version 7.4 of PHP.
This will make it easier for us to write new improvements, but to maintain this code in the future.

Here are the different steps to install our project as if you were a beginner.
at first you have to download a version of wamp server at the following address:
"https://sourceforge.net/projects/wampserver/files/WampServer%203/WampServer%203.0.0/wampserver3.3.0 x64.exe/download"
once the software has been downloaded, follow the different installation steps by opening the download file.
Once wampserver install; you need to download and install "composer" from:
"https://getcomposer.org/Composer-Setup.exe"; install this software and proceed to the next step.

Download git software: "https://github.com/git-for-windows/git/releases/download/v2.40.0.windows.1/Git-2.40.0-64-bit.exe"
Install it and go to the next step.

Go to the directory where you installed wamp, then to the "www" folder and open a command executor window either by left-clicking then opening a windows power chel window, or by doing a "c:/ wamp/www".
Once in the correct directory and once the command executor has been launched, do "git clone https://github.com/hacene92230/p8.git".
There the project is on your machine so do cd /p8 normally you are in the right folder, but before the project works do a "composer install" to install all the dependencies necessary for the proper functioning of the project.
Once the installation is finished, you have a ".env" file in the root of the project where you must modify the mysql variable with your own connection data, if you have not touched anything and your wamp installation is recent like us just saw it, you can go to the next step.

Then do a "cd/bin" and a "php console doctrine:database:create" then a "doctrine:schema:update --force".
This will create the database, then update with the creation of tables in the database.
Then do a "php console doctrine:fixtures:load" this will set up the different fixtures, which will allow you to have test data.
the username and password are as follows for an administrator:"user0" "password"
to have another test account for a simple user simply do "user1" and the password is identical.