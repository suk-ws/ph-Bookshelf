
const cssVar = getComputedStyle(document.querySelector(":root"));

const animationSpeedMultiplier = parseFloat(cssVar.getPropertyValue("--animation-speed-multiplier"));
const menuItemChildrenAnimaSpeed = parseFloat(cssVar.getPropertyValue("--sidebar-menu-item-anima-speed")) * 1000 * animationSpeedMultiplier;

const itemSidebar = document.getElementById("sidebar");

for (const node of document.getElementsByTagName("noscript")) {
	node.parentNode.removeChild(node);
}

for (const node of document.getElementsByClassName("menu-item-parent")) {
	if (node.parentElement.id === "menu-metas") {
		console.log("a");
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
sidebarToggle();
