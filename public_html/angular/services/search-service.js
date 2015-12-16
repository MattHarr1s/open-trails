app.service("SearchService", function() {
	this.trails = [];

	this.setTrails = function(newTrails) {
		this.trails = newTrails;
	};

	this.getTrails = function() {
		return (this.trails);
	};
});