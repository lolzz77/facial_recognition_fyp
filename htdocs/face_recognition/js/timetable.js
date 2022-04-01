// JavaScript Document for timetable.php
/* I get problem where functions were not being called, turns out the problem is
dont place the function inside $(function(){...}), cause that one is actually used
for running the function for once when loaded (maybe)*/

var id;
var shift;



$(document).ready(function(){

});



//Insert selected value into database table 'flag'
function insertIntoDB() {
	//Get selected date value
	var d = document.getElementById("myDate").value;
	//This function is used to pass clicked value to php to process database
	//If u need to pass multiple value to PHP, use '&' on the second one n the following
	location.href = "php/flag.php" + "?date=" + d + "&text=" + id + "&id=" + shift;
}


/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
/*the parameter btnId is linked with (this.id) in HTML */
function dropMenuFunction(btnId) {
  	switch (btnId) {
		case 'btn1':
			document.getElementById("myDropdown1").classList.toggle("show");
			break;
		case 'btn2':
			document.getElementById("myDropdown2").classList.toggle("show");
			break;
		case 'btn3':
			document.getElementById("myDropdown3").classList.toggle("show");
			break;
		case 'btn4':
			document.getElementById("myDropdown4").classList.toggle("show");
			break;
		case 'btn5': //still under development, for change_attendance.php
			document.getElementById("myDropdown5").classList.toggle("show");
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


//Change the button valeu to the selected shift
//parameter s is linked to with (this.text) in HTML
//And set variable value
function getShift(s) {
  	document.getElementById("btn2").innerHTML = s;
	shift = s;
}


//---------------------------------------------------------
//Function below is for change_timetable.php

//Old means previous data before it gets updated, is needed for SQL query for flag_update.php
var od; //old date
var oid; //old id

function update() {
	//Get selected date value
	var d = document.getElementById("myDate").value;
	//This function is used to pass clicked value to php to process database
	//If u need to pass multiple value to PHP, use '&' on the second one n the following
	location.href = "php/flag_update.php" + "?date=" + d + "&text=" + id + "&id=" + shift + "&old_date=" + od + "&old_id=" + oid;
}


function getEmpId3(text) {
  	//Change button value to display selected value
	document.getElementById("btn3").innerHTML = text;
	//Remove date from the original string
	var temp = text.substring(11, text.length);
	//Get the employee id from temp string
	oid = temp.match(/\d+/)[0];
	//Get only date from the original string
	od = text.substring(0, 11);
}


//Code below is same shit as above but is for delete button

function getEmpId4(text) {
  	//Change button value to display selected value
	document.getElementById("btn4").innerHTML = text;
	//Remove date from the original string
	var temp = text.substring(11, text.length);
	//Get the employee id from temp string
	id = temp.match(/\d+/)[0];
	//Get only date from the original string
	d = text.substring(0, 11);
}

function deleteData () {
	//This function is used to pass clicked value to php to process database
	//If u need to pass multiple value to PHP, use '&' on the second one n the following
	location.href = "php/flag_delete.php" + "?date=" + d + "&text=" + id;
}




//---------------------------------------------------------
//Function below is for change_attendance.php



function getButtonId(text) {
  	//Change button value to display selected value
	document.getElementById("atnButton").innerHTML = id;
	//Remove date from the original string
	var temp = text.substring(11, text.length);
	//Get the employee id from temp string
	id = temp.match(/\d+/)[0];
	//Get only date from the original string
	d = text.substring(0, 11);
}



