
// -- To submit variable using post -- //
function Send_PostData_ToUrl(path, params) {
	// -- Create object form -- //
    	var form = document.createElement("form");
	    form.setAttribute("method", 'post');
	    form.setAttribute("action", path);
	// -- Add params to form -- //
	for(var key in params) {
        	if(params.hasOwnProperty(key)) {
	            var hiddenField = document.createElement("input");
	        	hiddenField.setAttribute("type", "hidden");
	                hiddenField.setAttribute("name", key);
	                hiddenField.setAttribute("value", params[key]);
			// -- Add element to form -- //
               		form.appendChild(hiddenField);
	         }
	 }
	// -- Add form in document -- //
	document.body.appendChild(form);
	// -- Submit form -- //
    	form.submit();
}
