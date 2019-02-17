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

        });
    </script>

    <link href="http://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
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
            font-family: Inconsolata; 
            font-size: 14px;
        }
        textarea
        {
            font-family: Inconsolata; 
            font-size: 14px;
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
          <button id="run-code">Run (F4)</button>
        </td>
        <td align="right">
          <a href="help.html">Help</a>
        </td>
      </tr>
      <tr height="50%">
        <td colspan="2">
            <textarea name="code" id="code"><?php echo htmlspecialchars($_POST["Code"]); ?></textarea>
        </td>
      </tr>
      <tr height="50%">
        <td colspan="2">
          <textarea id="output-contents" readonly></textarea>
        </td>
      </tr>
    </table>
</body>
</html>
