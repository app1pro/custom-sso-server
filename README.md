# custom-sso-server
# An example of custom SSO server side for Signonify app / Shopify.

Enviroinment: PHP, MySQL database.

How to use:
Git clone the project into your computer.


Open this page on your browser (change the URL to match your local URL on your computer):

`http://localhost/dev/custom-sso-server/login.php?client_id=2e838f2f2652dab5c976381d58463ba6&redirect_url=http://localhost/app/users/callback`




Live demo: [https://signonify-demo.myshopify.com/account/login](https://signonify-demo.myshopify.com/account/login)

Test on your Signonify app setting:

```
Auth Type = OAuth2
CLIENT_ID = 2e838f2f2652dab5c976381d58463ba6
CLIENT_SECRET = 062a2c8e0e79a247143443b2de98ccacee4a24fc
Server Auth Url = https://test.signonify.com/custom-sso-server/login.php
Server Token Url = https://test.signonify.com/custom-sso-server/access_token.php
Server Userinfo Url = https://test.signonify.com/custom-sso-server/users.php
```
