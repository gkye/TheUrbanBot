function parseHtml(){
	var list = $(".htmlContent").find('.def-panel').first();
	
	var word = $(list).find('.word').text();
	var meaning = $(list).find('.meaning').text();
	var example = $(list).find('.example').text();
	
	var url = 'createTweet.php?word='+ word +'&meaning='+ meaning +'&example='+ example;
	window.location.href = url;
}