### Authy Two Factor Authentication(2FA) Using Plain PHP and JavaScript
In this project there is a login system and also a 2FA feature using Authy API. The implementation uses curl in PHP to talk to Authy server. If the user activates 2FA, then in the next login attempt, the user will get an OTP(One time password) as an SMS and the user will use this SMS to authenticate and to login to the system. 

## Prerequisite
1. The user must have a [twilio account](https://www.twilio.com/). The username and password of twilio can be used to login into [Authy](https://authy.com/). 
2. After successful login in Authy, the user must create an **app** in Authy and get an **API key** from the dashboard section.

## Installation
1. Install Wamp or Xampp. If it is Wamp then put the Authy2FA folder inside "www" folder and if it is Xampp then put the "Authy2FA" folder in the "htdocs" folder. After that the project can be run as localhost/Authy2FA.
2. You might already have a php_myadmin with username and password and if this is the case then replace the php_myadmin credentials with yours in authy_request.php and verify_users.php in "bg" folder for database connection. I have already provided the database in the database folder.

## Notes
 1. There are only two test users now, **Jon Snow**(username: 'jon@castleblack.com', Password: 'ygritte') and **Bruce Wayne**(username: 'bruce@gotham.com', Password: 'iambatman'). 
 2. To activate 2FA, please provide your own phone number and an OTP will be sent to you which you will have to use verify yourself.

