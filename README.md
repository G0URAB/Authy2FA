### Authy Two Factor Authentication(2FA) USING Plain PHP and JavaScript
In this project there is a login system and also a 2FA feature using Authy API. The implementation uses curl in PHP to talk to Authy server. If the user activates 2FA, then in the next login attempt, the user will get an OTP(One time password) as an SMS and the user will use this SMS to authenticate and to login to the system. 

## Getting started 
1. The user must have a [twilio account](https://www.twilio.com/). The username and password of twilio can be used to login into [Authy](https://authy.com/). After successful login, the user must create an **app** in Authy and get an **API key** from the dashboard section.
2. There are only two test users now, **Jon Snow** and **Bruce Wayne**. Please download the table **authy_2fa** from the database folder. There is no password for the database user **root** and name of database in this project is **github_projects**. So a database connection would look something like: $con = mysqli_connect("localhost","root","","github_projects").
3. Please insert your own API key in **bg/authy_requests.php**.
4. Install Wamp or Xampp. If it is Wamp then put the Authy2FA folder inside "www" folder and if it is Xampp then put the "Authy2FA" folder in the "htdocs" folder. After that the project can be run as localhost/Authy2FA.

