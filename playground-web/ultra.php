<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta charset="UTF-8">
    <title>Gambas Playground</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
     
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="lib/codemirror.js"></script>
    <script src="lib/addon/selection/active-line.js"></script>
    <script src="lib/gambas.js"></script>

    <script>
        $(document).ready(function(){

            var REMOTE_URI = 'http://localhost/Gambas/playground-php-server/run.php'

            var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                lineNumbers: true,
                styleActiveLine: true
            });

            var url = getQueryParameters();  
            if (url.gist) {
                $.get("https://api.github.com/gists/" + url.gist, function(data, status){                  
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

            function getQueryParameters() {
                var a = window.location.search.substr(1).split('&');
                if (a === "") return {};
                var b = {};
                for (var i = 0; i < a.length; i++) {
                    var p = a[i].split('=');
                    if (p.length !== 2) continue;
                    b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
                }
                return b;
            }

            var savedTheme = getLocalStorage('theme');
            if (savedTheme) {
                $("#select").val(savedTheme);
                editor.setOption("theme", savedTheme);
            }

            $("#select").on("change", function selectTheme(){
                var theme = $("#select option:selected").text(); 
                editor.setOption("theme", theme);
                setLocalStorage('theme', theme);
            });

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
    <link rel="stylesheet" href="lib/theme/3024-day.css">
    <link rel="stylesheet" href="lib/theme/3024-night.css">
    <link rel="stylesheet" href="lib/theme/abcdef.css">
    <link rel="stylesheet" href="lib/theme/ambiance.css">
    <link rel="stylesheet" href="lib/theme/base16-dark.css">
    <link rel="stylesheet" href="lib/theme/bespin.css">
    <link rel="stylesheet" href="lib/theme/base16-light.css">
    <link rel="stylesheet" href="lib/theme/blackboard.css">
    <link rel="stylesheet" href="lib/theme/cobalt.css">
    <link rel="stylesheet" href="lib/theme/colorforth.css">
    <link rel="stylesheet" href="lib/theme/dracula.css">
    <link rel="stylesheet" href="lib/theme/duotone-dark.css">
    <link rel="stylesheet" href="lib/theme/duotone-light.css">
    <link rel="stylesheet" href="lib/theme/eclipse.css">
    <link rel="stylesheet" href="lib/theme/elegant.css">
    <link rel="stylesheet" href="lib/theme/erlang-dark.css">
    <link rel="stylesheet" href="lib/theme/gruvbox-dark.css">
    <link rel="stylesheet" href="lib/theme/hopscotch.css">
    <link rel="stylesheet" href="lib/theme/icecoder.css">
    <link rel="stylesheet" href="lib/theme/isotope.css">
    <link rel="stylesheet" href="lib/theme/lesser-dark.css">
    <link rel="stylesheet" href="lib/theme/liquibyte.css">
    <link rel="stylesheet" href="lib/theme/lucario.css">
    <link rel="stylesheet" href="lib/theme/material.css">
    <link rel="stylesheet" href="lib/theme/mbo.css">
    <link rel="stylesheet" href="lib/theme/mdn-like.css">
    <link rel="stylesheet" href="lib/theme/midnight.css">
    <link rel="stylesheet" href="lib/theme/monokai.css">
    <link rel="stylesheet" href="lib/theme/neat.css">
    <link rel="stylesheet" href="lib/theme/neo.css">
    <link rel="stylesheet" href="lib/theme/night.css">
    <link rel="stylesheet" href="lib/theme/oceanic-next.css">
    <link rel="stylesheet" href="lib/theme/panda-syntax.css">
    <link rel="stylesheet" href="lib/theme/paraiso-dark.css">
    <link rel="stylesheet" href="lib/theme/paraiso-light.css">
    <link rel="stylesheet" href="lib/theme/pastel-on-dark.css">
    <link rel="stylesheet" href="lib/theme/railscasts.css">
    <link rel="stylesheet" href="lib/theme/rubyblue.css">
    <link rel="stylesheet" href="lib/theme/seti.css">
    <link rel="stylesheet" href="lib/theme/shadowfox.css">
    <link rel="stylesheet" href="lib/theme/solarized.css">
    <link rel="stylesheet" href="lib/theme/the-matrix.css">
    <link rel="stylesheet" href="lib/theme/tomorrow-night-bright.css">
    <link rel="stylesheet" href="lib/theme/tomorrow-night-eighties.css">
    <link rel="stylesheet" href="lib/theme/ttcn.css">
    <link rel="stylesheet" href="lib/theme/twilight.css">
    <link rel="stylesheet" href="lib/theme/vibrant-ink.css">
    <link rel="stylesheet" href="lib/theme/xq-dark.css">
    <link rel="stylesheet" href="lib/theme/xq-light.css">
    <link rel="stylesheet" href="lib/theme/yeti.css">
    <link rel="stylesheet" href="lib/theme/idea.css">
    <link rel="stylesheet" href="lib/theme/darcula.css">
    <link rel="stylesheet" href="lib/theme/zenburn.css">

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
        <td align="right">
          <select id=select>
            <option selected>default</option>
            <option>3024-day</option>
            <option>3024-night</option>
            <option>abcdef</option>
            <option>ambiance</option>
            <option>base16-dark</option>
            <option>base16-light</option>
            <option>bespin</option>
            <option>blackboard</option>
            <option>cobalt</option>
            <option>colorforth</option>
            <option>darcula</option>
            <option>dracula</option>
            <option>duotone-dark</option>
            <option>duotone-light</option>
            <option>eclipse</option>
            <option>elegant</option>
            <option>erlang-dark</option>
            <option>gruvbox-dark</option>
            <option>hopscotch</option>
            <option>icecoder</option>
            <option>idea</option>
            <option>isotope</option>
            <option>lesser-dark</option>
            <option>liquibyte</option>
            <option>lucario</option>
            <option>material</option>
            <option>mbo</option>
            <option>mdn-like</option>
            <option>midnight</option>
            <option>monokai</option>
            <option>neat</option>
            <option>neo</option>
            <option>night</option>
            <option>oceanic-next</option>
            <option>panda-syntax</option>
            <option>paraiso-dark</option>
            <option>paraiso-light</option>
            <option>pastel-on-dark</option>
            <option>railscasts</option>
            <option>rubyblue</option>
            <option>seti</option>
            <option>shadowfox</option>
            <option>solarized dark</option>
            <option>solarized light</option>
            <option>the-matrix</option>
            <option>tomorrow-night-bright</option>
            <option>tomorrow-night-eighties</option>
            <option>ttcn</option>
            <option>twilight</option>
            <option>vibrant-ink</option>
            <option>xq-dark</option>
            <option>xq-light</option>
            <option>yeti</option>
            <option>zenburn</option>
          </select>
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
