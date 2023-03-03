/******************************************************************************
 ##############################################################################
 #####                                                                    #####
 #####   JavaScript of ph-Bookshelf of ui design BreadCard                #####
 #####     enhanced extension                                             #####
 #####     for ! Permalink Highlight !                                    #####
 #####     for ¶[Heading Permalink](#heading-permalink)                   #####
 #####                                                                    #####
 #####     @author: Sukazyo Workshop                                      #####
 #####     @version： 1.0                                                 #####
 #####                                                                    #####
 ##############################################################################
 ******************************************************************************/

const headingPermalink_animaTimeoutMs = 150;

function headingPermalink_onScrollFocused (event) {
	const node = event.target;
	node.classList.add("highlighting");
	sleep(headingPermalink_animaTimeoutMs).then(() => {
		node.classList.remove("highlighting");
		sleep(headingPermalink_animaTimeoutMs).then(() => {
			node.classList.add("highlighting");
			sleep(headingPermalink_animaTimeoutMs).then(() => {
				node.classList.remove("highlighting");
			});
		});
	});
}

for (const node of document.getElementsByClassName("heading-permalink")) {
	node.addEventListener("focus", headingPermalink_onScrollFocused);
}

// document.getElementById("main").addEventListener("scrollend", onHeadingPermalinkScrollFocused);
