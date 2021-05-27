const WITH_SUMMARY_CLASS = "with-summary"

const DROPDOWN_OPEN_CLASS = "open";

let bookRoot;

let fontSettingDiv;

function summaryOnOrOff () {
	
	if (bookRoot.classList.contains(WITH_SUMMARY_CLASS)) {
		bookRoot.classList.remove(WITH_SUMMARY_CLASS);
	} else {
		bookRoot.classList.add(WITH_SUMMARY_CLASS);
	}
	
}

window.onload = function () {
	
	bookRoot = document.getElementsByClassName("book")[0];
	
	fontSettingDiv = document.getElementsByClassName("font-settings")[0].getElementsByClassName("dropdown-menu")[0];
	
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
