# VideoTube MySQL Project (WIP)
*Making a YouTube-Like Website Using MySQL and JavaScript PHP*

<br />

## Contents
* Database Tables
    * VideoTube Table
    * Categories Table
    * Users Table
    * Videos Table
    * Thumbnails Table
    * Subscribers Table
    * Likes Table
    * Dislikes Table
* Website Pages
    * index.php Page
    * SignUp.php Page
    * SignIn.php Page
    * upload.php Page
    * watch.php Page
* Database Diagrams
    * ER Model
    * Relational Schema
* References

<br />

## Database Tables
### VideoTube Table

The videotube database table is the main container for all of the other database tables.

<img src="README%20images/Database%20Table%20Screenshots/VideoTube%20Database%20Main%20Screenshot.PNG">

### Categories Table

The categories database table contains all of the possible video categories to choose from when uploading a video to the website. Each category is assigned an ID which is saved as a reference to the category of each video in the video database table.

<img src="README%20images/Database%20Table%20Screenshots/VideoTube%20Categories%20Screenshot.PNG">

### Users Table

The users database table stores the information for each user that has signed up on the website using the SignUp.php page. The table stores each user with an ID, first and last name, username (which needs to be unique), email, password (which is stored as a hash code), the date they created their account, and a profile picture.

<img src="README%20images/Database%20Table%20Screenshots/VideoTube%20Users%20Screenshot.PNG">

### Videos Table

The videos database table stores the information about all videos that have been uploaded,regardless of user. Each video table has a unique ID for each video, as well as the user that uploaded the video, video title, video description, privacy setting ID, video filepath, video category ID, date uploaded, total views of video, and video duration.

<img src="README%20images/Database%20Table%20Screenshots/VideoTube%20Videos%20Screenshot.PNG">

### Thumbnails Table

The thumbnails database table contains the thumbnail information created when a user uploads a video using the upload.php page. Each video generates three thumbnails to be used when choosing an image to display the video on the website. The thumbnails table stores the unique thumbnail ID, the associated video ID, the filepath, and a boolean for whether that particular thumbnail is selected to represent the video file.

<img src="README%20images/Database%20Table%20Screenshots/VideoTube%20Thumbnails%20Screenshot.PNG">

### Subscribers Table

The subscribers database table contains the information of all users that have subscribed to any other user. The subscribers table simply stores a unique ID, which user is the subscriber and which is being subscribed to.

<img src="README%20images/Database%20Table%20Screenshots/VideoTube%20Subscribers%20Screenshot.PNG">

### Likes Table

The likes database table contains all of the information about which videos or comments have been liked with a unique ID, the username of the user who liked it, a unique ID for which comment has been liked, and the video ID for which video has been liked.

<img src="README%20images/Database%20Table%20Screenshots/VideoTube%20Likes%20Screenshot.PNG">

### Dislikes Table

The dislikes database table contains all of the information about which videos or comments have been disliked with a unique ID, the username of the user who disliked it, a unique ID for which comment has been disliked, and the video ID for which video has been disliked.

<img src="README%20images/Database%20Table%20Screenshots/VideoTube%20Dislikes%20Screenshot.PNG">

<br />

## Website Pages
### index.php Page

The index.php page is the homepage of the VideoTube website. As the project is still a work in progress, it only displays the header with a pop-out sidebar menu, a link to the homepage, a search bar, a link to upload.php to upload a video, and a profile button. Also displayed in the body is the name of which user is currently logged in, or wheather there is no user logged in. Future work will enable the sidebar menu, search bar, profile button, and add suggested videos in the body.

<img src="README%20images/Website%20Page%20Screenshots/Index%20Page%20Screenshot.PNG">

### SignUp.php Page

The SignUp.php page is where users are directed to in order to create an account for the website by filling out a form. Users must enter their first and last names, create a unique username, enter their email twice, and create a password, entered twice, and then submit the form. Once submitted without errors, the account is created and the data is stored in the users database table.

<img src="README%20images/Website%20Page%20Screenshots/Sign%20Up%20Page%20Screenshot.PNG">

### SignIn.php Page

The SignIn.php page is where users are directed to in order to sign into the website using the credentials that they've previously created for their account. They must input their unique username and their password and click the submit button. The users database table is searched for these credentials and the user is logged in if the username and password match a table element.

<img src="README%20images/Website%20Page%20Screenshots/Sign%20In%20Page%20Screenshot.PNG">

### upload.php Page

The upload.php page is where users can upload videos to their account for viewing on the website. The form requires that a video file be selected, a name be given to the video, a security preference be chosen, and a video category chosen. The user may also enter a description if they'd like. On the upload button is clicked, the video file is processed which converts it to an mp4 file type, the old video file is deleted, three thumbnails are generated, and the data is inserted into the videos database table.

<img src="README%20images/Website%20Page%20Screenshots/Upload%20Video%20Page%20Screenshot.PNG">

### watch.php Page

The watch.php page is where users can view videos that either they or other users have uploaded to the website. Users can also like/dislike videos and subscribe to the user that posted the video. When a video is liked/disliked, that information is inserted into the likes and dislikes database tables. Future work will add a comments section beneath and a recommened videos on the right side panel.

<img src="README%20images/Website%20Page%20Screenshots/Watch%20Page%20Screenshot.PNG">

<br />

## Database ER Diagrams
### ER Diagram
<img src="README%20images/Models/VideoTube%20ER%20Model.png">

### Relational Schema
<img src="README%20images/Models/VideoTube%20Relational%20Schema.PNG">

<br />

## References
### YouTube
* Basic visual formatting elements
* User sign up, log in, video like/dislike, and user subscriber system design
### Udemy Online Courses
* **Reece Kenny** - Software Engineer at Microsoft
* *Make a YouTube Clone from Scratch: JavaScript PHP and MySQL* online course
* Online teacher and course for guidance, direction, and project structure
### icons8
* Free icons for site
### ffmpeg
* Free mp4 video converter
### MaxCDN
* Bootstrap style sheet
### Google Developer APIs
* AJAX jQuery library
### cdnjs CloudFlare
* Website APIs and libraries for efficient data processing
### Microsoft Visual Studio Code
* Integrated Development Environment
### w3Schools
* HTML, CSS, PHP, SQL, AJAX, JavaScript, jQuery, and JSON programming references
