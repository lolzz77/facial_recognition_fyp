// JavaScript Document for timetable.php
/* I get problem where functions were not being called, turns out the problem is
dont place the function inside $(function(){...}), cause that one is actually used
for running the function for once when loaded (maybe)*/

var id;




$(document).ready(function(){

});



function deleteData() {
	location.href = "php/employee_delete.php" + "?id=" + id;
}


/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
/*the parameter btnId is linked with (this.id) in HTML */
function dropMenuFunction(btnId) {
  	switch (btnId) {
		case 'btn1':
			document.getElementById("myDropdown1").classList.toggle("show");
			break;

		default:
			break;
	}
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
   	var i;
   	for (i = 0; i < dropdowns.length; i++) {
   		var openDropdown = dropdowns[i];
    	if (openDropdown.classList.contains('show')) {
        	openDropdown.classList.remove('show');
    	}
    }
 }
}

//Change the button value to the selected employee id
//parameter text is linked to with (this.text) in HTML
//And set variable value
function getEmpId(text) {
  	//Change button value to display selected value
	document.getElementById("btn1").innerHTML = text;
	//Get only numbers from the string
	id = text.match(/\d+/)[0];
}

