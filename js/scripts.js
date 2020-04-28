


window.onscroll = function () {
	scrollFunction()
};

function scrollFunction() {
	if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
		document.getElementById("mainhead").style.backgroundColor = "rgba(0,0,0, 1.0)";
	} else {
		document.getElementById("mainhead").style.backgroundColor = "rgba(0,0,0, 0)";
	}
};





