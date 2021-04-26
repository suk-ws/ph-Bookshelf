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
