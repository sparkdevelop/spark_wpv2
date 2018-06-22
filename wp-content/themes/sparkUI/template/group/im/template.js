;(function(RCS){
	var getTemplates = function(callback){
		var list = {
	        button: 'wp-content/themes/sparkUI/template/group/im/templates/button.html',
	        chat: 'wp-content/themes/sparkUI/template/group/im/templates/chat.html',
	        closebefore: 'wp-content/themes/sparkUI/template/group/im/templates/closebefore.html',
	        conversation: 'wp-content/themes/sparkUI/template/group/im/templates/conversation.html',
	        endconversation: 'wp-content/themes/sparkUI/template/group/im/templates/endconversation.html',
	        evaluate: 'wp-content/themes/sparkUI/template/group/im/templates/evaluate.html',
	        imageView: 'wp-content/themes/sparkUI/template/group/im/templates/imageView.html',
	        leaveword: 'wp-content/themes/sparkUI/template/group/im/templates/leaveword.html',
	        main: 'wp-content/themes/sparkUI/template/group/im/templates/main.html',
	        imMain: 'wp-content/themes/sparkUI/template/group/im/templates/imMain.html',
	        message: 'wp-content/themes/sparkUI/template/group/im/templates/message.html',
	        imMessage: 'wp-content/themes/sparkUI/template/group/im/templates/imMessage.html',
	        messageTemplate: 'wp-content/themes/sparkUI/template/group/im/templates/messageTemplate.html',
	        imMessageTemplate: 'wp-content/themes/sparkUI/template/group/im/templates/imMessageTemplate.html',
	        userInfo: 'wp-content/themes/sparkUI/template/group/im/templates/userInfo.html',
	    };
	    var templates = {};
	    for (var key in list) {
	    	var url = list[key];
	    	var html = RCS.templateCache[url];
	    	if (html) {
	    		templates[key] = html;
	    	} else {
		    	var xhr = new XMLHttpRequest();
		    	xhr.open('get', url, false);
		    	xhr.onreadystatechange = function(){
		    		if (xhr.readyState == 4 && xhr.status == 200) {
		    			templates[key] = xhr.responseText;
		    		}
		    	}
		    	xhr.send(null);
	    	}

	    }
	    return templates;
	}
	RCS.getTemplates = getTemplates;
})(RCS);