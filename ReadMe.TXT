This system has 2 different platform, web-based and executable-based.
Because I tried to integrate python code with html/css/javascript but failed.

1. htdocs
paste in XAMPP folder

2. repos
created by Visual Studio Community
No need paste in specific folder, just run executable files

3. face_recognition.sql
database for phpmyadmin

Setup:
#1 Download insall XAMPP

#2 import the .sql database into myphpymadmin (localhost/phpmyadmin)

#3 go to \repos\FacialRecognition\FaceRecognition\dist run
FaceRecognizer.exe. If cannot open, make sure no other apps using camera

#4 In \htdocs move "face_recognition" folder
into your XAMPP htdocs folder (D:\xampp\htdocs)

#5 in your browser type http://localhost/face_recognition/index.html
