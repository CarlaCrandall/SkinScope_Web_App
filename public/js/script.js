$(document).ready(function(){
	
	//if browser doesn't support pointerEvents, apply special class - fixes issues with styling the select arrow
	if(!('pointerEvents' in document.body.style)) { $('.sel-container').setAttribute('class','sel-container no-pointer-events'); }


	//clear search field on focus
	$("#search input[type=text]").focus(function() {

		var text = $("#search input[type=text]").val();

		if(text == "Search"){
			$("#search input[type=text]").val("");	
		}
	});


	//replace search field text when it loses focus
	$("#search input[type=text]").focusout(function() {

		var text = $("#search input[type=text]").val();

		if(text == ""){
			$("#search input[type=text]").val("Search");	
		}
	});


	//handles search form
	$("#search").submit(function(e) {
		
		e.preventDefault(); //prevent page reload

		var searchTerm = $("#search input[type=text]").val();

		if(searchTerm != "Search" && searchTerm != ""){
			var updatedURL = updateQueryParams(window.location.href, 'name', searchTerm); //search product name
			updatedURL = updateQueryParams(updatedURL, 'brand', searchTerm); //search product brand
			window.location.replace(updatedURL); //load new URL
		}
	});


	//filter product by rating when select value changes
	$("#filter select").change(function() {

		if(this.value != "All Ratings"){
			var updatedURL = updateQueryParams(window.location.href, 'rating', this.value); //create new URL
			window.location.replace(updatedURL); //load new URL
		}
		//remove filter when user selects "all ratings"
		else{
			var updatedURL = removeQueryParams(window.location.href, 'rating'); //create new URL
			window.location.replace(updatedURL); //load new URL	
		}
	});

});


//adds or updates query parameter
function updateQueryParams(url, param, paramVal){

    var newURL = "";
    var temp = "";

    var urlArray = url.split("?"); //split URL and current query parameters into array
    var baseURL = urlArray[0]; //get base URL
    var params = urlArray[1]; //get query parameters

    //if parameters already exist
    if(params){

        urlArray = params.split("&"); //split parameters into array

        //loop through paramters
        for (i=0; i < urlArray.length; i++){

        	//if parameter is not the one we're looking to add/update...
            if(urlArray[i].split('=')[0] != param){
                
                //add parameters to new URL
                newURL += temp + urlArray[i];
                temp = "&";
            }
        }
    }

    var newParam = temp + "" + param + "=" + paramVal; //create new query parameter
    return baseURL + "?" + newURL + newParam; //return entire URL
}


//removes query parameter
function removeQueryParams(url, param){

    var newURL = "";
    var temp = "";

    var urlArray = url.split("?"); //split URL and current query parameters into array
    var baseURL = urlArray[0]; //get base URL
    var params = urlArray[1]; //get query parameters

    //if parameters already exist
    if(params){

        urlArray = params.split("&"); //split parameters into array

        //loop through paramters
        for (i=0; i < urlArray.length; i++){

        	//if parameter is not the one we're looking to add/update...
            if(urlArray[i].split('=')[0] != param){
                
                //add parameters to new URL
                newURL += temp + urlArray[i];
                temp = "&";
            }
        }
    }

    return baseURL + "?" + newURL; //return entire URL
}



