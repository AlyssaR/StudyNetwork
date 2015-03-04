----------------
| StudyNetwork |
----------------
A user-friendly way to form study groups based on customer input


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
