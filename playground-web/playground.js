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

document.addEventListener("DOMContentLoaded", function() {
	'use strict';
	var REMOTE_URI = location.href.indexOf("file://") !== -1 ? 'http://localhost:8080/' : '/run';
	var outputContainer = document.getElementById('output');
	var outputContents = document.getElementById('output-contents');
	var runButton = document.getElementById('run-code');
	var gistButton = document.getElementById('gist-button');
	var closeOutputButton = document.getElementById('close-output');
	var editorElement = document.getElementById('code');
	var editor = ace.edit('code');
	editor.$blockScrolling = Infinity;
	editor.getSession().setMode('ace/mode/vbscript');
	runButton.addEventListener('click', runCode);
	gistButton.addEventListener('click', sendGist);
	closeOutputButton.addEventListener('click', function() {
		outputContainer.className = '';
	});

	function runCode() {
		var xhr = new XMLHttpRequest();
		outputContainer.className = 'visible';
		outputContents.className = 'loading';
		xhr.onreadystatechange = function() {
			if(this.readyState !== XMLHttpRequest.DONE) return;
			if(this.status === 200) {
				outputContents.textContent = this.responseText;
			} else {
				outputContents.textContent = 'Server returned with error ' + this.status + ' : \n\n' + this.responseText;
			}
			outputContents.className = '';
		}.bind(xhr)
		xhr.open('POST', REMOTE_URI, true);
		xhr.send(editor.getValue());
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

	// 599e1257e151db48755b2ebf0713a336
	function fetchGist(gist_id) {
		var xhr = new XMLHttpRequest();
		editorElement.classList.add('loading');
		xhr.onreadystatechange = function() {
			if(xhr.readyState !== XMLHttpRequest.DONE) return;
			if(xhr.status === 200) {
				var response = JSON.parse(xhr.responseText);
				if (!response) return;
				for (var name in response.files) {
					if (response.files.hasOwnProperty(name)) {
						editor.setValue(response.files[name].content);
						break;
					}
				}
			} else {
				console.error('GitHub returned with error ' + xhr.status + ' : \n\n' + xhr.responseText);
			}
			editorElement.classList.remove('loading');
		};
		xhr.open('GET', 'https://api.github.com/gists/' + gist_id, true);
		xhr.send();
	}

	function sendGist() {
		var xhr = new XMLHttpRequest();
		outputContainer.className = 'visible';
		outputContents.className = 'loading';
		xhr.onreadystatechange = function() {
			if(xhr.readyState !== XMLHttpRequest.DONE) return;
			if(xhr.status === 201) {
				var response = JSON.parse(xhr.responseText);
				if (!response) return;

				var gist_id = response.id;
				var gist_url = response.html_url;
				var play_url = "?gist=" + encodeURIComponent(gist_id);

				outputContents.innerHTML = '<p><a href="' + play_url + '">Playground permalink</a></p>'
								+ '<p><a href="' + gist_url + '">Gist link</a></p>';

			} else {
				console.error('GitHub returned with error ' + xhr.status + ' : \n\n' + xhr.responseText);
			}
			outputContents.className = '';
		};
		xhr.open('POST', 'https://api.github.com/gists', true);
		xhr.send(JSON.stringify({
			description: "Shared via Gambas Playground",
			public: true,
			files: {
				"playground.gbs": {
					"content": editor.getValue()
				}
			}
		}));
	}


	var parameters = getQueryParameters();
	if(parameters.gist) {
		fetchGist(parameters.gist);
	} else {
		var savedCode = getLocalStorage('code');
		if (savedCode) {
			editor.setValue(savedCode);
		} else {
			editor.setValue('Print "Hello world !"');
		}
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

});
