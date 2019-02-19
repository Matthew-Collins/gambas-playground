<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta charset="UTF-8">
    <title>Gambas Playground</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
     
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="lib/codemirror.js"></script>
    <script src="lib/gambas.js"></script>

    <script>
        $(document).ready(function(){

            let url = new URLSearchParams(location.search);
            var REMOTE_URI = 'http://localhost/Gambas/playground-php-server/run.php'

            var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                lineNumbers: true
            });

            if (url.has("gist")) {
                $.get("https://api.github.com/gists/" + url.get("gist"), function(data, status){                  
                    if (status == "success") {
                        for (var name in data.files) {
                            if (data.files.hasOwnProperty(name)) {
                                editor.setValue(data.files[name].content);
                                break;
                            }
                        }
                    }
                });
	        } else {
	        	if (editor.getValue() == '') {
		        	var savedCode = getLocalStorage('code');
		        	if (savedCode) {
			        	editor.setValue(savedCode);
		        	} else {
			        	editor.setValue('Shell "gbs3 --version"');
		        	}
		        }
	        }

            $("#run-code").click(RunCode);

            $(window).keydown(function(event){
                switch (event.keyCode) {
                    case 115:
                        RunCode();
                }
            });

            function RunCode(){         
                $("#output-contents").text("Loading...");
                $.post(REMOTE_URI, editor.getValue(), function(result){
                    $("#output-contents").text(result);
                });
            }

	        var typingTimeout = null;
	        editor.on("change", function() {
		        if(!typingTimeout) {
			        typingTimeout = setTimeout(function() {
				        typingTimeout = null;
				        setLocalStorage('code', editor.getValue());
			        }, 1000);
		        }
	        });

            function getLocalStorage(key) {
	            try {
		            return localStorage.getItem(key);
	            } catch(e) {
		            return null;
	            }
            }

            function setLocalStorage(key, value) {
	            try {
		            window.localStorage.setItem(key, value);
	            } catch(e) {}
            }

            editor.refresh();

        });
    </script>

    <link rel="stylesheet" href="lib/codemirror.css">

    <style>
        body 
        {
            margin: 0;
            padding: 0;
        }
        .CodeMirror 
        {
            border: 1px solid #999999;
            min-height: 0; 
            height: 100%;
            overflow-y: auto;
        }
        .CodeMirror pre 
        { 
            font-family: monospace;
        }
        textarea
        {
            font-family: monospace;
            border: 1px solid #999999;
            width: 100%;
            height: 100%;
            resize: none;
        }
    </style>

</head>
<body margin="0">
    <table width="100%" height="100%" border="0">
      <tr>
        <td>
          <button id="run-code">Run (F4)</button>&nbsp;&nbsp;&nbsp;&nbsp;
          <a href = "examplesultra.html"><button>Examples</button></a>&nbsp;&nbsp;
          <a href = "http://gambaswiki.org/wiki/playground"><button>Help</button></a>&nbsp;&nbsp;
          <a href = "index.html"><button>Main</button></a>&nbsp;
          <a href = "lite.html"><button>Lite</button></a>&nbsp;
          <a href = "slim.html"><button>Slim</button></a>&nbsp;
          <a href = "mobile.html"><button>Mobile</button></a>
        </td>
      </tr>
      <tr height="50%">
        <td>
            <textarea name="code" id="code"><?php echo htmlspecialchars($_POST["Code"]); ?></textarea>
        </td>
      </tr>
      <tr height="50%">
        <td>
          <textarea id="output-contents" readonly></textarea>
        </td>
      </tr>
    </table>
</body>
</html>
