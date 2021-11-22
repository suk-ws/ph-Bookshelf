
const cssVar = getComputedStyle(document.querySelector(":root"));

const animationSpeedMultiplier = parseFloat(cssVar.getPropertyValue("--animation-speed-multiplier"));
const menuItemChildrenAnimaSpeed = parseFloat(cssVar.getPropertyValue("--sidebar-menu-item-anima-speed")) * 1000 * animationSpeedMultiplier;

const itemSidebar = document.getElementById("sidebar");

for (const node of document.getElementsByTagName("noscript")) {
	node.parentNode.removeChild(node);
}

for (const node of document.getElementsByClassName("menu-item-parent")) {
	if (node.parentElement.id === "menu-metas") {
		node.firstElementChild.onclick = function () {
			if (!node.classList.contains("active")) {
				for (const nodeOther of node.parentElement.children) {
					if (nodeOther.classList.contains("active")) { toggleMenuItem(nodeOther).then(); }
				}
			}
			toggleMenuItem(node).then();
		}
	} else {
		node.firstElementChild.onclick = function () { toggleMenuItem(node).then(); }
	}
}

async function toggleMenuItem(node) {
	const children = node.getElementsByClassName("children")[0];
	node.classList.toggle("active");
	if (node.classList.contains("active")) {
		const height = children.clientHeight;
		children.style.height = "0px";
		await sleep(1);
		children.style.height = height + "px";
		await sleep(menuItemChildrenAnimaSpeed);
		children.style.height = "";
	} else {
		children.style.display = "block";
		const height = children.clientHeight;
		children.style.height = height + "px";
		await sleep(1);
		children.style.height = "0px";
		await sleep(menuItemChildrenAnimaSpeed);
		children.style.height = "";
		children.style.display = "";
	}
}

function sleep(ms) {
	return new Promise(resolve => setTimeout(resolve, ms));
}

document.getElementById("sidebar-show").onclick = sidebarToggle;
function sidebarToggle() {
	itemSidebar.parentElement.classList.toggle("show-sidebar");
}
if (window.innerWidth > 1000) { sidebarToggle(); }



window.onload = function () {
	
	// 循环删除页面加载时css过度动画的效果抑制
	const elementsTranslationPreload = document.getElementsByClassName("prevent-animation");
	while (elementsTranslationPreload.length > 0) {
		// console.debug("Removing translation-preload tag on element" + elementsTranslationPreload[0].nodeName + "#" + elementsTranslationPreload[0].id);
		// console.debug("Last elements count is : " + elementsTranslationPreload.length);
		elementsTranslationPreload[0].classList.remove("prevent-animation");
	}
	console.debug("prevent-animation tag remove done");
	
}
