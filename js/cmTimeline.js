function cmTimelineRun(code, start, finish, totalFrames, totalTime) {
	// the time each frame takes
	var milli = (totalTime / totalFrames) * 1000;
	
	// setup and execute timeline
	var next = start;
	for(var i = 0; i <= totalFrames; ++i) {
		next += ((finish - start) / totalFrames);
		var newcode = code.replace('%', next);
		setTimeout(newcode, milli * i);
	}
}
