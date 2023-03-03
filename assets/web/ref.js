function updateRef () {
	for (let node of document.getElementsByTagName("ref")) {
		node.innerHTML = "...";
		const request = new XMLHttpRequest();
		request.open("GET", node.getAttribute("source"), true);
		request.onreadystatechange = function () {
			if (request.readyState === 4 && request.status === 200) {
				node.innerHTML = marked(request.responseText);
			} else if (request.readyState === 4) {
				node.innerHTML = "ERROR "+ request.status;
			}
		}
		request.send();
	}
} updateRef();
