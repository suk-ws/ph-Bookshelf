const WITH_SUMMARY_CLASS = "with-summary"

const DROPDOWN_OPEN_CLASS = "open";

let bookRoot;
let pageContainer;
let inBookNavContainer;

let fontSettingDiv;

let bookCurrentId;
let pageCurrentId;

function summaryOnOrOff () {
	
	if (bookRoot.classList.contains(WITH_SUMMARY_CLASS)) {
		bookRoot.classList.remove(WITH_SUMMARY_CLASS);
	} else {
		bookRoot.classList.add(WITH_SUMMARY_CLASS);
	}
	
}

window.onload = function () {
	
	bookRoot = document.getElementsByClassName("book")[0];
	pageContainer = document.getElementById("page-container");
	inBookNavContainer = document.getElementById("in-book-nav-container");
	
	fontSettingDiv = document.getElementsByClassName("font-settings")[0].getElementsByClassName("dropdown-menu")[0];
	
	if (window.innerWidth > 600) {
		bookRoot.classList.add(WITH_SUMMARY_CLASS);
	}
	
};

function bindFolderClickEvent () {
	for (let node of document.getElementsByClassName("fold")) {
		node.childNodes[0].addEventListener("click", function () {
			if (node.classList.contains("on")) {
				node.classList.remove("on");
			} else node.classList.add("on");
		});
	}
} bindFolderClickEvent();

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

function openOrCloseFontSettings () {
	if (fontSettingDiv.classList.contains(DROPDOWN_OPEN_CLASS)) {
		fontSettingDiv.classList.remove(DROPDOWN_OPEN_CLASS);
	} else {
		fontSettingDiv.classList.add(DROPDOWN_OPEN_CLASS);
	}
}

function getFontSize () {
	return parseInt(
		/ font-size-([0-9]+) /.exec(bookRoot.className)[1]
	);
}

function setFontSize (size) {
	if (size < 0) size = 0;
	else if (size > 4) size = 4;
	bookRoot.className = bookRoot.className.replace(/ font-size-[0-9]+ /, " font-size-"+size+" ");
	setCookie("font-size", size);
}

function enlargeFontSize () {
	setFontSize(getFontSize()+1);
}

function reduceFontSize () {
	setFontSize(getFontSize()-1);
}

function setFontFamily (familyId) {
	bookRoot.className = bookRoot.className.replace(/ font-family-[0-9]+ /, " font-family-"+familyId+" ");
	setCookie("font-family", familyId);
}

function setFontFamilySerif () {
	setFontFamily(0);
}

function setFontFamilySans () {
	setFontFamily(1);
}

function setColorTheme (colorThemeId) {
	bookRoot.className = bookRoot.className.replace(/ color-theme-[0-9]+ /, " color-theme-"+colorThemeId+" ");
	setCookie("color-theme", colorThemeId);
}

function setColorThemeWhite () {
	setColorTheme(0);
}

function setColorThemeSepia () {
	setColorTheme(1);
}

function setColorThemeNight () {
	setColorTheme(2);
}

function setCookie(name, value) {
	const d = new Date()
	d.setTime(d.getTime() + (30*24*60*60*1000));
	const expires = "expires=" + d.toGMTString()
	document.cookie = name + "=" + value + "; " + expires;
}

function updatePage (bookId, pageId = "") {
	
	const isNavRefresh = bookId !== bookCurrentId;
	const request = new XMLHttpRequest();
	const url = (
		"/" + bookId + "/" + pageId
	);
	const urlParam = (
		"?raw=true" +
		((isNavRefresh)?("&nav=true"):(""))
	)
	request.open("GET", url + urlParam, true);
	console.log(url + urlParam);
	request.onreadystatechange = function () {
		if (request.readyState === 4 && request.status === 200) {
			
			// data
			const data = request.responseText.split("\n", 2);
			const nav = isNavRefresh?data[0]:"";
			const content = request.responseText.substr(nav.length);
			console.log(nav);
			console.log(content);
			// content
			pageContainer.innerHTML = content;
			if (!isNavRefresh) document.getElementById("page/"+pageCurrentId).classList.remove("active");
			if (!isNavRefresh) pageCurrentId = pageId;
			if (!isNavRefresh) document.getElementById("page/"+pageId).classList.add("active");
			// nav
			if (isNavRefresh) {
				inBookNavContainer.innerHTML = nav;
				if (bookCurrentId !== "%root")
					document.getElementById("book/"+bookCurrentId).classList.remove("active");
				bookCurrentId = bookId;
				pageCurrentId = inBookNavContainer.getElementsByClassName("active")[0].getAttribute("page-id");
				document.getElementById("book/"+bookId).classList.add("active");
				bindFolderClickEvent();
				bindPageLinkClickEvent();
			}
			// history
			window.history.pushState(document.documentElement.innerHTML, document.title, url);
			pageContainer.classList.remove("loading");
			// post-process
			updateRef();
			
		}
	}
	request.send();
	pageContainer.classList.add("loading");
	
}

function bindBookLinkClickEvent () {
	for (let node of document.getElementsByClassName("link-book")) {
		node.children[0].removeAttribute("href");
		node.childNodes[0].addEventListener("click", function () {
			updatePage(node.getAttribute("book-id"));
		}, true);
	}
} bindBookLinkClickEvent();

function bindPageLinkClickEvent () {
	for (let node of document.getElementsByClassName("link-page")) {
		node.children[0].removeAttribute("href");
		node.childNodes[0].addEventListener("click", function () {
			updatePage(bookCurrentId, node.getAttribute("page-id"));
		}, true);
	}
} bindPageLinkClickEvent();
