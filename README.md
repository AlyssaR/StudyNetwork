----------------
| StudyNetwork |
----------------
A user-friendly way to form study groups based on customer input


----------------------------------------
| IMPORTANT: To configure dev with API |
----------------------------------------
1. Edit: /etc/apache2/sites-available by changing AllowOverride to All so it looks like the following:
	\<Directory /var/www/><br />
		Options Indexes FollowSymLinks MultiViews<br />
		AllowOverride All<br />
		Order allow,deny<br />
		allow from all<br />
	\</Directory><br />
2. Run: sudo a2enmod rewrite && sudo service apache2 restart

-----------
| Vagrant |
-----------
1. Create a directory for the Vagrant files (i.e. "mkdir Machine")
2. Copy the Vagrant file into it, and create "data" and "www" directories as well
3. From the "Machines" directory run "vagrant up"
4. SSH (or use Putty) to the machine at 192.168.10.10
	Username: vagrant
	Password: vagrant
5. From the SSH session run: sudo apt-get install lamp-server^
6. Pick a SQL password when prompted 
7. To test the installation, when everything is complete run: mysql -u root -p
	Then type in the password. If it worked you'll have a sql prompt. 
8. Run: sudo apt-get install git
9. From /var/www type: git clone -b dev https://github.com/AlyssaR/StudyNetwork.git
10. Code all the codez!!

--------------------
| Testing for users|
--------------------
~This is from your vagrant. (If you have not, clone the StudyNetwork dev repo) and install lamp<br />
1. Pull from git, you should be pulling from origin dev<br />
2. Go into your mysql root and create a database called 'StudyNetwork'<br />
3. Log out and go to /var/www/StudyNetwork/database<br />
4. From here type:<br />
	mysql -u root -p StudyNetwork < studyNetBackup.sql<br />
	--- you will be prompted to give a password, it's just your mysql root password<br />
5. Log back into mysql root from the topmost directory<br />
6. Type:<br />
	create user 'web'@'localhost' identified by 'wearegeniuses';<br />
	grant all privileges on StudyNetwork.* to web@localhost with grant option;<br />
7. *optional* log into mysql -u web -p just to make sure it works<br />
8. go back to the StudyNetwork/database directory and type:<br />
	mysql -u web -pwearegeniuses StudyNetwork < populateScript.sql<br />
9. In your browser:<br />
	192.168.10.10/StudyNetwork/bin/test.php<br />
