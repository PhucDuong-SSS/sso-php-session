# sso-php-session
Simple SSO PHP based on session
At foder sso-php-session
+ php -S localhost:8888
+ brower : localhost:8888/manager/login.php to first login

+ php -S localhost:9999
+ brower : localhost:9999/web_page/web_page to show infomation.
 
Concept:
<ul>
<li>While session empty go to login page with sso-manager, while session not empty go to the last record session url.</li>
<li>When logout, sso-manager redirect to every record url stored in session then sso-client destroy local session and back to sso-manager until all url stored empty.</li>
</ul>

