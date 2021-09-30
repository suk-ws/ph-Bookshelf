
for (const node of document.getElementsByTagName("noscript")) {
	node.parentNode.removeChild(node);
}

for (const node of document.getElementsByClassName("menu-item-parent")) {
	node.firstElementChild.onclick = function () {
		node.classList.toggle("active");
	}
}
