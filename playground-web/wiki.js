// Gambas Wiki - Javascript to Run Examples in Playground
// Written by: Matthew Collins - Feb 2019

// Add this into the wiki: <script type="text/javascript" src="http://gambas.one/playground/wiki.js"></script>

// Run this when Document Loaded
document.addEventListener("DOMContentLoaded", function() {

    var REMOTE_URI = 'http://localhost/Gambas/playground-php-server/run.php';

    // Get and loop all "code gambas" elements
    var gcs = document.getElementsByClassName("code gambas");
    var i;
    for (i = 0; i < gcs.length; i++) {

        // Add Outer Div with look of Result Box
        var divOuter = document.createElement("div");
        divOuter.style = "border:solid 1px #D8D8D8; border-top:none; background-color:#F8F8F8";
        gcs[i].parentElement.appendChild(divOuter, gcs[i]);

        // Add From
        var formPlay = document.createElement("form");
        formPlay.action = "http://localhost/Gambas/Playground/ultra.php";
        formPlay.method = "POST";
        divOuter.appendChild(formPlay);

        // Add Pre and Code Elements same a Result Box
        var preResult = document.createElement("pre");
        preResult.style = "padding:0.5em 1em; margin:0";
        var codeResult = document.createElement("code");
        codeResult.innerText = "...";
        preResult.appendChild(codeResult);
        formPlay.appendChild(preResult);

        // Add Run Button
        var buttonRun = document.createElement("button");
        buttonRun.type = "button";
        buttonRun.innerText = "Run";
        formPlay.appendChild(buttonRun);

        // Add Run Click Event
        buttonRun.addEventListener('click', function() {
	        var xhr = new XMLHttpRequest();
	        this[1].innerText = "Loading...";
	        xhr.onreadystatechange = function() {
		        if(xhr.readyState !== XMLHttpRequest.DONE) return;
		        if(xhr.status === 200) {
			        this.innerText = xhr.responseText;
		        } else {
			        this.innerText = 'Error: ' + xhr.status + ' : \n\n' + xhr.responseText;
		        }
	        }.bind(this[1]);
	        xhr.open('POST', REMOTE_URI, true);
	        xhr.send(this[0]);
        }.bind([gcs[i].innerText,codeResult]));

        // Add Input Box
        var inputCode = document.createElement("textarea");
        inputCode.style = "display:none;";
        inputCode.name = "Code";
        inputCode.value = gcs[i].innerText;    
        formPlay.appendChild(inputCode);

        // Add Play Button
        var buttonPlay = document.createElement("button");
        buttonPlay.style="margin-left: 3px;";
        buttonPlay.innerText = "Play";
        formPlay.appendChild(buttonPlay);

    }

});


