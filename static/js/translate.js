$(function() {

    	$("#words").focus();

        $("#auto").click(function() {
            $("#auto").removeClass("btn-default").addClass("btn-primary");
            $("#zh").removeClass("btn-primary").addClass("btn-default");
            $("#en").removeClass("btn-primary").addClass("btn-default");
            $("#words").focus();
        });

    	$("#zh").click(function() {
            $("#auto").removeClass("btn-primary").addClass("btn-default");
    		$("#zh").removeClass("btn-default").addClass("btn-primary");
    		$("#en").removeClass("btn-primary").addClass("btn-default");
    		$("#words").focus();
    	});

    	$("#en").click(function() {
            $("#auto").removeClass("btn-primary").addClass("btn-default");
    		$("#zh").removeClass("btn-primary").addClass("btn-default");
    		$("#en").removeClass("btn-default").addClass("btn-primary");
    		$("#words").focus();
    	});

    	$("#words").keyup(function() {
    		var url = "http://translate.sundabao.com/translate.php";
        		var word = $("#words").val().trim();
        		var param = {
        		    'word' : word,
        		    'from' : $(".btn-primary").attr("id"),
    		    };

    		$.post(url, param, function(data) {
                var style_title ={
                    display: 'block',
                    color: '#898989',
                };

    		    if(data.hasOwnProperty('translate')) {
        			$("#translate").html(data.translate);
        		}
                if(data.hasOwnProperty('basic')) {
                    
                    $("#rest-tr-title").css(style_title);
                    $("#rest-tr").empty();

                    $.each(data.basic, function(index, value) {
                        $("#rest-tr").append("<p style='color: #252525;'>"+value+"</p>");
                    });
                }
                if(data.hasOwnProperty("web")) {
                    $("#rest-web-tr-title").css(style_title);
                    $("#rest-web-tr").empty();
                    
                    $.each(data.web, function(index, value) {
                        $("#rest-web-tr").append("<h4 style='color: #6f6f6f;'>"+(index+1)+"、"+value.key+"</h4>");
                        $.each(value.value, function(i, v) {
                            $("#rest-web-tr").append("<p style='color: #252525;'>"+"&nbsp&nbsp&nbsp&nbsp"+v+"</p>");
                        });
                    });
                }
    		}, "json");
    	});

    	$("#words").bind("paste", function() {
    		var url = "http://translate.sundabao.com/translate.php";
    		setTimeout(function() {
    		    var word = $("#words").val().trim();
    		    var param = {
        			'word' : word,
        			'from' : $(".btn-primary").attr("id"),
    		    };
        
    		    $.post(url, param, function(data) {
        		    var style_title ={
                        display: 'block',
                        color: '#898989',
                    };

                    if(data.hasOwnProperty('translate')) {
                        $("#translate").html(data.translate);
                    }
                    if(data.hasOwnProperty('basic')) {
                        
                        $("#rest-tr-title").css(style_title);
                        $("#rest-tr").empty();

                        $.each(data.basic, function(index, value) {
                            $("#rest-tr").append("<p style='color: #252525;'>"+value+"</p>");
                        });
                    }
                    if(data.hasOwnProperty("web")) {
                        $("#rest-web-tr-title").css(style_title);
                        $("#rest-web-tr").empty();
                        
                        $.each(data.web, function(index, value) {
                            $("#rest-web-tr").append("<h4 style='color: #6f6f6f;'>"+(index+1)+"、"+value.key+"</h4>");
                            $.each(value.value, function(i, v) {
                                $("#rest-web-tr").append("<p style='color: #252525;'>"+"&nbsp&nbsp&nbsp&nbsp"+v+"</p>");
                            });
                        });
                    }
        		}, "json");
    		});
            
    	});
    });