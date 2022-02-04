# Grade Wars (Beta Build)

## TODO
- [x] set up incoding and decoding accout type for OTP.php testing script
- [x] add database instagration for OTP.php testing script
- [ ] add user to access only gradewars db
- [x] finish OTP.php
- [x] work on first page of joining
- [x] make second page of joining
- [x] fix second page of joining (line 91)
- [x] add login page 
- [x] make email working
- [x] fix `./user/userCration.php` (line 116) `Fatal error: Uncaught Error: Call to a member function bind_param() on bool in /var/www/html/beta/user/userCreation.php:116 Stack trace: #0 {main} thrown in /var/www/html/beta/user/userCreation.php on line 116`
- [ ] Fix `AccType` session var changing. always at 2 when going to `login.php`


## note to self
- [ ] **REMOVE OTP.php**
- [ ] **REMOVE** any other testing scripts
- [ ] **REMOVE** any mention of testing scripts
- [ ] **REMOVE** any mention of `type_plaintext` of the table `pre_user`
- [ ] **ADD** `// Path: config.php` into the `<?php` tag
- [ ] **CHANGE** `KEY` and `IV` in `config.php` when finished
