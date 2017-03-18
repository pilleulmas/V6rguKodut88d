window.onload = function() {
	var muutuja = document.getElementsByClassName('bead');
	for(var i = 0; i < muutuja.length; i++){
		muutuja[i].addEventListener("click", function(e) {
			console.log('click');			
			if (getComputedStyle(this).getPropertyValue("float") == "left") {
				e.target.style.cssFloat = "right";
			}
			else e.target.style.cssFloat = "left";
		})
	}
}