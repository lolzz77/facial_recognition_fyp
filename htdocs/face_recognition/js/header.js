

//$(function() {...})
/*What it's designed to do (amongst other things) is ensure that your function is called once all the DOM elements of the page are ready to be used.
*/

/*Bug detected: If you deleted one tab from Header.html, then here u no change right, so any tab that is below the deleted one will result in the tab unclickable. To solve this, make sure to remove the click function in here for the removed tab in header.html too*/
$(function(){


	
    
    
    document.getElementById("welcome").onclick = function () {
        location.href = "/face_recognition/welcome.html";
    };

	document.getElementById("register_employee").onclick = function () {
        location.href = "/face_recognition/register_employee.html";
    };
	
	document.getElementById("delete_employee").onclick = function () {
        location.href = "/face_recognition/delete_employee.php";
    };
	
	document.getElementById("list_of_employee").onclick = function () {
        location.href = "/face_recognition/list_of_employee.php";
    };
	
	document.getElementById("insert_timetable").onclick = function () {
        location.href = "/face_recognition/insert_timetable.php";
    };
	
	document.getElementById("view_timetable").onclick = function () {
        location.href = "/face_recognition/view_timetable.php";
    };
	
	document.getElementById("view_attendance").onclick = function () {
        location.href = "/face_recognition/view_attendance.php";
    };
	
	document.getElementById("report").onclick = function () {
        location.href = "/face_recognition/report.php";
    };
	
	document.getElementById("change_timetable").onclick = function () {
        location.href = "/face_recognition/change_timetable.php";
    };
	
	document.getElementById("delete_timetable").onclick = function () {
        location.href = "/face_recognition/delete_timetable.php";
    };
	
	//document.getElementById("change_attendance").onclick = function () {
    //    location.href = "/face_recognition/change_attendance.php";
    //};
	
	document.getElementById("notification").onclick = function () {
        location.href = "/face_recognition/notification.php";
    };
	
});