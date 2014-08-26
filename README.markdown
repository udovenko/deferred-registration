Deferred registration
=====================

>Just a test task I've been made for checking my PHP skills. Has no practical value and stored on GitHub only as a code example. 

It was forbidden to use any existing PHP frameworks to achieve mentioned goals, so page uses its own small core with framework-like functionality. For quick layout it uses Twitter Bootstrap CSS framework.

So that's what this page does:

 1. According to task conditions, it renders welcome page:
![](doc/presentation/images/welcome_page.png?raw=true)
 2. When you click "Register", you get registration form:
![](doc/presentation/images/registration_form.png?raw=true)
 3. After submitting the form, page creates cookie with encrypted registration token and sends an email to mail box you've entered. You get send mail confirmation:
![](doc/presentation/images/send_email_confirmation.png?raw=true)
 4. This email contains a link with same token as was saved in cookie:
![](doc/presentation/images/email.png?raw=true)
 5. By clicking this link (if your cookie is still alive), you will be registered and able to see your new profile:
 ![](doc/presentation/images/profile_page.png?raw=true)
 6. Now you can come back any time and login with your new credentials: 
  ![](doc/presentation/images/authentication_form.png?raw=true)
  
    And that's it! ))