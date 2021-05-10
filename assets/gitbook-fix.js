const WITH_SUMMARY_CLASS = "with-summary"

let bookRoot;

function summaryOnOrOff () {
	
	if (bookRoot.classList.contains(WITH_SUMMARY_CLASS)) {
		bookRoot.classList.remove(WITH_SUMMARY_CLASS);
	} else {
		bookRoot.classList.add(WITH_SUMMARY_CLASS);
	}
	
}

window.onload = function () {
	
	bookRoot = document.getElementsByClassName("book")[0];
	
	if (window.innerWidth > 600) {
		bookRoot.classList.add(WITH_SUMMARY_CLASS);
	}
	
};

for (let node of document.getElementsByClassName("fold")) {
	node.childNodes[0].addEventListener("click", function () {
		if (node.classList.contains("on")) {
			node.classList.remove("on");
		} else node.classList.add("on");
	});
}

for (const node of document.getElementsByClassName("summary-container")) {
	
	node.nextElementSibling.innerHTML = node.nextElementSibling.innerHTML + "<a class='summary-container-icon'><i class='fa'></i></a>";
	node.nextElementSibling.getElementsByClassName("summary-container-icon")[0].addEventListener("click", function () {
		if (node.classList.contains("on")) {
			node.classList.remove("on")
		} else {
			node.classList.add("on")
		}
	})
	
}
