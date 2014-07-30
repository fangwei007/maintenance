$(function() {
    //add indicators and hovers to submenu parents
//    $("#main-menu").find("li").each(function() {
//        if ($(this).find("ul").length > 0) {
//            //show subnav on hover 
//            $(this).mouseenter(function() {  
//                $(this).find(".main-menu-dropdown").stop(true, true).slideDown();  
//            });  
//
//            //hide submenus on exit 
//            $(this).mouseleave(function() {  
//                $(this).find(".main-menu-dropdown").stop(true, true).slideUp();  
//            }); 
//        }  
//    });
    // sign up popup window
    $('#sign-up').click(function (e) {
        e.preventDefault();
        $('#sign-up-modal').modal('show');
    });
    
    // sign in popup window
    $('#sign-in').click(function (e) {
        e.preventDefault();
        $('#sign-in-modal').modal('show');
    });
    
    // sign in popup window
    $('.log-in').click(function (e) {
        e.preventDefault();
        $('#sign-in-modal').modal('show');
    });
    
    // show sign up popup window in sign in page
    $('#no-sign-up').click(function (e) {
        e.preventDefault();
        $('#sign-in-modal').modal('hide');
        $('#sign-up-modal').modal('show');
    });
    
    $('#sign-up-form').submit(function(){
        $("#signup-btn").button('loading'); //set the text to signing up
	$.post($('#sign-up-form').attr('action'), $('#sign-up-form').serialize(), function( data ) {
            if(data.st === 0){
                $('#validation-email-error').html(data.email);
                $('#validation-nickname-error').html(data.nickname);
                $('#validation-password-error').html(data.password);
                $('#validation-passconf-error').html(data.passconf);
                $("#signup-btn").button('reset'); //reset button
            }
            
            if(data.st === 1){
                location.reload();
            }			
	}, 'json');
	return false;			
   });
   
    $('#sign-in-form').submit(function(){
        $("#login-btn").button('loading'); //set the text to logging
	$.post($('#sign-in-form').attr('action'), $('#sign-in-form').serialize(), function( data ) {
            if(data.st === 0){
                $('#validation-in-email-error').html(data.email);
                $('#validation-in-password-error').html(data.password);
                if(data.error)$('#validation-in-error').addClass('error-msg').html(data.error);
                $("#login-btn").button('reset'); //reset button
            }
            if(data.st === 1){
                location.reload();        
            }			
	}, 'json');
	return false;			
    });
   
    $('#submit-comment-form').submit(function(){	
	$.post($(this).attr('action'), $(this).serialize(), function( data ) {
            console.log(data);
            if(data.st === 0){
                popup_msg(data.error,'center-alert-msg').appendTo('#submit-comment-form').delay(4000).fadeOut();
            }
            if(data.st === 1){
                popup_msg('回复成功','center-suc-msg').appendTo('#submit-comment-form').delay(1000).fadeOut();
                $('#submit-comment-form textarea').val('');
                $('.comment-content').load(get_base_url()+'/comments/show_comments/' + data.postID + '/' + data.type);
            }			
	}, 'json');
	return false;			
    });  
   
});

//show the back to top button
$(window).scroll(function() {
    if ($(this).scrollTop() > 500) {
        $('#to-top').stop(true, true).fadeIn();
    } else {
        $('#to-top').stop(true, true).fadeOut();
    }
});


//follow users
function follow(userID, e, status){
    $(e).removeAttr('onclick'); //make sure users won't trigger this function multiple times
    var pathname = get_base_url() + "/profile/follow";
    $.ajax({
        type: 'post',
        url: pathname,
        data: {user_id:userID, status:status},
        success: function(data) {
            var responseData = jQuery.parseJSON(data);
            if(responseData.st === 0){
                //failed
                console.log('follow inserted failed');
            }
            if(responseData.st === 1){
                //success
                if(responseData.fn === 'follow'){
                    //change element to unfollow status
                    $(e).attr("onclick","follow('" + responseData.userID + "',this,1)").addClass('button-title').removeClass('button-title-danger').text(responseData.text);

                }else{
                    //change element to follow status
                    $(e).attr("onclick","follow('" + responseData.userID + "',this,0)").addClass('button-title-danger').removeClass('button-title').text(responseData.text);
                }
            }
            
        }
    });
}

/*
 * Author: Wei Fang
 * Date: Mar. 9th
 * Function: 添加收藏
 */

function watch_list(postID, e, status, postType){
    $(e).removeAttr('onclick'); //make sure users won't trigger this function multiple times
    var pathname = get_base_url() + "/profile/watch_list";
    $.ajax({
        type: 'post',
        url: pathname,
        data: {post_id:postID, status:status, post_type: postType},
        success: function(data) {
            var responseData = jQuery.parseJSON(data);
            if(responseData.st === 0){
                //failed
                console.log('watch list inserted failed');
            }
            if(responseData.st === 1){
                //success
                if(responseData.fn === 'stow'){
                    //change element to unstow status
                    $(e).attr("onclick","watch_list('" + responseData.postID + "',this,1,'" + responseData.postType +"')").addClass('button-title').removeClass('button-title-danger').text(responseData.text);

                }else{
                    //change element to stow status
                    $(e).attr("onclick","watch_list('" + responseData.postID + "',this,0,'" + responseData.postType +"')").addClass('button-title-danger').removeClass('button-title').text(responseData.text);
                }
            }
            
        }
    });
}

//function to show the view using ajax
function display_view(selector, viewPath, intervalTime){
    if(!intervalTime){intervalTime = 300000;}
    ajax_load_view(selector, viewPath);
    setInterval(function(){ajax_load_view(selector, viewPath)},intervalTime);
}

function ajax_load_view(selector, viewPath){
    var pathname = get_base_url() + viewPath;
    $.ajax({
        type: 'post',
        url: pathname,
        dataType: "html",
        success: function(data) {
            //success
            $(selector).html(data);
        }
    });
}

function delete_comment(commentID, type, postID){
    var pathname = get_base_url() + "/comments/delete_comment";
    $.ajax({
        type: 'post',
        url: pathname,
        data: {comment_id:commentID},
        success: function(data) {
            var responseData = jQuery.parseJSON(data);
            if(responseData.st === 1){
                //success
                popup_msg('删除成功','center-suc-msg').appendTo('#submit-comment-form').delay(1000).fadeOut();
                $('.comment-content').load(get_base_url()+'/comments/show_comments/'+postID+ '/'+type);
            }
            
        }
    });
}

function show_reply_area(commentID){
    $("#reply-"+commentID).slideToggle();
}

function reply_comment(commentID){
    $('#submit-comment-form-'+commentID).submit(function(){	
	$.post($(this).attr('action'), $(this).serialize(), function( data ) {
            if(data.st === 0){
                popup_msg(data.error,'center-alert-msg').appendTo('#submit-comment-form').delay(4000).fadeOut();
            }
            if(data.st === 1){
                popup_msg('回复成功','center-suc-msg').appendTo('#submit-comment-form').delay(1000).fadeOut();
//                $('#submit-comment-form textarea').val('');
                $('.comment-content').load(get_base_url()+'/comments/show_comments/' + data.postID + '/' + data.type);
            }			
	}, 'json');
	return false;			
   });
}

function popup_msg(text, className){
    var msg = $("<div>").addClass(className).text(text);
    return msg;
}

function get_base_url(){
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var url = (pathArray[3]!=="bridgeous") ? protocol + '//' + host : protocol + '//' + host + '/' + pathArray[3];
    return url;
}