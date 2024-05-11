# praxxys-dev-exam

## A product management project coded for PRAXXYS' back-end developer exam.
### Developed with Laravel 11.x Breeze with Vue3 and Inertia.
### Also features the following front-end libraries.
1. [@tiptap/vue-3](https://tiptap.dev/) - Used to build custom WYSIWYG HTML editor.
2. [@vuepic/vue-datepicker](https://vue3datepicker.com/) - Used to create a Vue3 datetime picker.
3. [moment-timezone](https://momentjs.com/timezone/) - Used to parse and manipulate datetime to a specific timezone in JavaScript.
4. [bootstrap](https://getbootstrap.com/) - Used to design front-end layouts.

## Local Setup
### We will use Homestead to setup the project on our local environment.
### Required 
1. [php](https://www.php.net/downloads.php)
2. [Composer](https://getcomposer.org/download/)
3. [Oracle VirtualBox](https://www.virtualbox.org/wiki/Downloads)
4. [Vagrant](https://www.vagrantup.com/downloads)

### Setup
1. Run `git clone https://github.com/laravel/homestead.git ~/Homestead` to clone Homestead
2. Redirect to the Homestead directory by running `cd ~/Homestead`
3. Checkout to the release branch `git checkout release`
4. Run the following command to create the **Homestead.yaml** file
```
# macOS / Linux...
bash init.sh
 
# Windows...
init.bat
```
5. Add the following to the Homestead.yaml file
```
folders:

    - map: /path/to/the/app/praxxys-dev-exam
      to: /home/vagrant/praxxys-dev-exam

    - map: ~/code
      to: /home/vagrant/code

sites:

    - map: praxxys-dev-exam.com
      to: /home/vagrant/praxxys-dev-exam/public

    - map: homestead.test
      to: /home/vagrant/code/public
```
6. Next, run a text editor as administrator and update the **hosts** file
```
192.168.56.56  praxxys-dev-exam.com
```
7. Run `vagrant up` to initiate Homestead. This will take a while because it will download the Homestead box for your virtual machine.
8. After Homestead is initiated, run `vagrant ssh` to SSH into the newly created VM.
9. Redirect to the project by typing `cd /home/vagrant/praxxys-dev-exam`
10. Run `composer install` to install the composer packages needed.
11. Generate an **APP_KEY** by executing the command `php artisan key:generate`.
12. An **.env** file should be created for you, inside it, change the key-value pairs for database setup.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo-app
DB_USERNAME=homestead
DB_PASSWORD=secret
```
13. Create the database by typing `mysql` then `CREATE DATABASE 'praxxys_dev_exam';`.
14. Run `php artisan migrate` to create the tables.
15. Run `php artisan db:seed` to seed the tables.
16. Run `npm install` to install all the frontend libraries needed.

### And done! You should now be able to access the app via http://praxxys-dev-exam.com/ on your browser.