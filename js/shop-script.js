$(document).ready(function() {

   $("#newsticker").jCarouselLite({
		vertical: true,
		hoverPause:true,
		btnPrev: "#news-prev",
		btnNext: "#news-next",
		visible: 3,
		auto:3000,
		speed:500
	});
    
  loadcart();

$("#style-grid").click(function(){
    
$("#block-tovar-grid").show();
$("#block-tovar-list").hide();

$("#style-grid").attr("src","/images/icon-grid-active.png");
$("#style-list").attr("src","/images/icon-list.png"); 

$.cookie('select_style','grid');     
});

$("#style-list").click(function(){
    
$("#block-tovar-grid").hide();
$("#block-tovar-list").show();

$("#style-list").attr("src","/images/icon-list-active.png");
$("#style-grid").attr("src","/images/icon-grid.png");

$.cookie('select_style','list');     
});


if ($.cookie('select_style') == 'grid' )
{
$("#block-tovar-grid").show();
$("#block-tovar-list").hide();

$("#style-grid").attr("src","/images/icon-grid-active.png");
$("#style-list").attr("src","/images/icon-list.png");     
}
else
{
$("#block-tovar-grid").hide();
$("#block-tovar-list").show();

$("#style-list").attr("src","/images/icon-list-active.png");
$("#style-grid").attr("src","/images/icon-grid.png");    
}


$("#select-sort").click(function(){   
   $("#sorting-list").slideToggle(200);    
});

$('#block-category > ul > li > a').click(function(){
               	        
            if ($(this).attr('class') != 'active'){
                
			$('#block-category > ul > li > ul').slideUp(400);
            $(this).next().slideToggle(400);
            
                    $('#block-category > ul > li > a').removeClass('active');
					$(this).addClass('active');
                    $.cookie('select_cat', $(this).attr('id'));
                    
				}else
                {
                                   
                    $('#block-category > ul > li > a').removeClass('active');
                    $('#block-category > ul > li > ul').slideUp(400);
                    $.cookie('select_cat', '');   
                }                                  
});

if ($.cookie('select_cat') != '')
{
$('#block-category > ul > li > #'+$.cookie('select_cat')).addClass('active').next().show();
}

if ($.cookie('select_cat') != '')
{
$('#block-category > ul > li > #'+$.cookie('select_cat')).addClass('active').next().show();
}


  $('#genpass').click(function(){
 $.ajax({
  type: "POST",
  url: "/function/genpass.php",
  dataType: "html",
  cache: false,
  success: function(data) {
  $('#reg_pass').val(data);
  }
});
 
}); 



$('#reloadcaptcha').click(function(){
$('#block-captcha > img').attr("src","/reg/reg_captcha.php?r="+ Math.random());
});




 $('.top-auth').toggle(
       function() {
           $(".top-auth").attr("id","active-button");
           $("#block-top-auth").fadeIn(200);
       },
       function() {
           $(".top-auth").attr("id","");
           $("#block-top-auth").fadeOut(200);  
       }
    );
    
    
    
$('#button-pass-show-hide').click(function(){
 var statuspass = $('#button-pass-show-hide').attr("class");
  
    if (statuspass == "pass-show")
    {
       $('#button-pass-show-hide').attr("class","pass-hide");
       
     			            var $input = $("#auth_pass");
			                var change = "text";
			                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;
        
    }else
    {
        $('#button-pass-show-hide').attr("class","pass-show");
        
     			            var $input = $("#auth_pass");
			                var change = "password";
			                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;        
       
    }
    });
    
    
    $("#button-auth").click(function() {
        
 var auth_login = $("#auth_login").val();
 var auth_pass = $("#auth_pass").val();

 
 if (auth_login == "" || auth_login.length > 30 )
 {
    $("#auth_login").css("borderColor","#FDB6B6");
    send_login = 'no';
 }else {
    
   $("#auth_login").css("borderColor","#DBDBDB");
   send_login = 'yes'; 
      }

 
if (auth_pass == "" || auth_pass.length > 15 )
 {
    $("#auth_pass").css("borderColor","#FDB6B6");
    send_pass = 'no';
 }else { $("#auth_pass").css("borderColor","#DBDBDB");  send_pass = 'yes'; }



 if ($("#rememberme").prop('checked'))
 {
    auth_rememberme = 'yes';

 }else { auth_rememberme = 'no'; }


 if ( send_login == 'yes' && send_pass == 'yes' )
 { 
  $("#button-auth").hide();
  $(".auth-loading").show();
    
    $.ajax({
  type: "POST",
  url: "/include/auth.php",
  data: "login="+auth_login+"&pass="+auth_pass+"&rememberme="+auth_rememberme,
  dataType: "html",
  cache: false,
  success: function(data) {

  if (data == 'yes_auth')
  {
      location.reload();
  }else
  {
      $("#message-auth").slideDown(400);
      $(".auth-loading").hide();
      $("#button-auth").show();
      
  }
  
}
});  
}
});

$('#remindpass').click(function(){
    
			$('#input-email-pass').fadeOut(200, function() {  
            $('#block-remind').fadeIn(300);
			});
});

$('#prev-auth').click(function(){
    
			$('#block-remind').fadeOut(200, function() {  
            $('#input-email-pass').fadeIn(300);
			});
});

$('#button-remind').click(function(){
    
 var recall_email = $("#remind-email").val();
 
 if (recall_email == "")
 {
    $("#remind-email").css("borderColor","#FDB6B6");

 }else 
 {
   $("#remind-email").css("borderColor","#DBDBDB");
   
   $("#button-remind").hide();
   $(".auth-loading").show();
    
  $.ajax({
  type: "POST",
  url: "/include/remind-pass.php",
  data: "email="+recall_email,
  dataType: "html",
  cache: false,
  success: function(data) {

  if (data == 'yes')
  {
     $(".auth-loading").hide();
     $("#button-remind").show();
     $('#message-remind').attr("class","message-remind-success").html("На ваш e-mail выслан новый пароль.").slideDown(400);
     
     setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#input-email-pass').show()", 3000);
 
  }else
  {
      $(".auth-loading").hide();
      $("#button-remind").show();
      $('#message-remind').attr("class","message-remind-error").html(data).slideDown(400);
      
  }
  }
}); 
  }
  });

$('#auth-user-info').toggle(
       function() {
           $("#block-user").fadeIn(100);
       },
       function() {
           $("#block-user").fadeOut(100);
       }
    );

$('#logout').click(function(){
    
    $.ajax({
  type: "POST",
  url: "/include/logout.php",
  dataType: "html",
  cache: false,
  success: function(data) {

  if (data == 'logout')
  {
      location.reload();
  }
  
}
}); 
});

$('#input-search').bind('textchange', function () {
                 
 var input_search = $("#input-search").val();

if (input_search.length >= 3 && input_search.length < 150 )
{
 $.ajax({
  type: "POST",
  url: "/include/search.php",
  data: "text="+input_search,
  dataType: "html",
  cache: false,
  success: function(data) {

 if (data > '')
 {
     $("#result-search").show().html(data); 
 }else{
    
    $("#result-search").hide();
 }

      }
}); 

}else
{
  $("#result-search").hide();    
}

});


//Шаблон проверки email на правильность
    function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
    }
 // Контактные данные
  $('#confirm-button-next').click(function(e){   

   var order_fio = $("#order_fio").val();
   var order_email = $("#order_email").val();
   var order_phone = $("#order_phone").val();
   var order_address = $("#order_address").val();
   
 if (!$(".order_delivery").is(":checked"))
 {
    $(".label_delivery").css("color","#E07B7B");
    send_order_delivery = '0';

 }else { $(".label_delivery").css("color","black"); send_order_delivery = '1';

  var formError = $("#form-error");
  formError.css("display","none");
  formError.html("");
  // Проверка ФИО 
 if (order_fio == "" || order_fio.length > 50 )
 {
    $("#order_fio").css("borderColor","#FDB6B6");
   formError.html(formError.html() + "Введите ФИО <br>");
   send_order_fio = '0';
   
 }else { $("#order_fio").css("borderColor","#DBDBDB");  send_order_fio = '1';}

  
 //проверка email
 if (isValidEmailAddress(order_email) == false)
 {
    $("#order_email").css("borderColor","#FDB6B6");
   formError.html(formError.html() + "Введите корректный Email <br>");
  send_order_email = '0';   
 }else { $("#order_email").css("borderColor","#DBDBDB"); send_order_email = '1';}
  
 // Проверка телефона
 
  if (order_phone == "" || order_phone.length > 50)
 {
    $("#order_phone").css("borderColor","#FDB6B6");
   formError.html(formError.html() + "Введите телефон <br>");
    send_order_phone = '0';   
 }else { $("#order_phone").css("borderColor","#DBDBDB"); send_order_phone = '1';}
 
 // Проверка Адреса
 
  if (order_address == "" || order_address.length > 150)
 {
    $("#order_address").css("borderColor","#FDB6B6");
   formError.html(formError.html() + "Введите адрес <br>");
    send_order_address = '0';   
 }else { $("#order_address").css("borderColor","#DBDBDB"); send_order_address = '1';}
  
} 
 // Глобальная проверка
 if (send_order_delivery == "1" && send_order_fio == "1" && send_order_email == "1" && send_order_phone == "1" && send_order_address == "1")
 {
    // Отправляем форму
   return true;
 }
 else{    
    $("#form-error").css("display", "block");
 }

e.preventDefault();

});



$('.add-cart-style-list,.add-cart-style-grid,.add-cart,.random-add-cart').click(function(){
              
 var  tid = $(this).attr("tid");

 $.ajax({
  type: "POST",
  url: "/include/addtocart.php",
  data: "id="+tid,
  dataType: "html",
  cache: false,
  success: function(data) { 
  loadcart();
      }
});

});

function loadcart(){
     $.ajax({
  type: "POST",
  url: "/include/loadcart.php",
  dataType: "html",
  cache: false,
  success: function(data) {
    
  if (data == "0")
  {
  
    $("#block-basket > a").html("Корзина пуста");
	
  }else
  {
    $("#block-basket > a").html(data);

  }  
    
      }
});    
       
}


 function fun_group_price(intprice) {  
    // Группировка цифр по разрядам
  var result_total = String(intprice);
  var lenstr = result_total.length;
  
    switch(lenstr) {
  case 4: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4);
    break;
  }
  case 5: {
  groupprice = result_total.substring(0,2)+" "+result_total.substring(2,5);
    break;
  }
  case 6: {
  groupprice = result_total.substring(0,3)+" "+result_total.substring(3,6); 
    break;
  }
  case 7: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4)+" "+result_total.substring(4,7); 
    break;
  }
  default: {
  groupprice = result_total;  
  }
}  
    return groupprice;
    }


$('.count-minus').click(function(){

  var iid = $(this).attr("iid");      
 
 $.ajax({
  type: "POST",
  url: "/include/count-minus.php",
  data: "id="+iid,
  dataType: "html",
  cache: false,
  success: function(data) {   
  $("#input-id"+iid).val(data);  
  loadcart();
  
  // переменная с ценной продукта
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  // Цену умножаем на колличество
  result_total = Number(priceproduct) * Number(data);
 
  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" руб");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  
  itog_price();
      }
});
  
});

$('.count-plus').click(function(){

  var iid = $(this).attr("iid");      
  
 $.ajax({
  type: "POST",
  url: "/include/count-plus.php",
  data: "id="+iid,
  dataType: "html",
  cache: false,
  success: function(data) {   
  $("#input-id"+iid).val(data);  
  loadcart();
  
  // переменная с ценной продукта
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  // Цену умножаем на колличество
  result_total = Number(priceproduct) * Number(data);
 
  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" руб");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  
  itog_price();
      }
});
  
});

$('.count-input').keypress(function(e){
    
 if(e.keyCode==13){
	   
 var iid = $(this).attr("iid");
 var incount = $("#input-id"+iid).val();        
 
 $.ajax({
  type: "POST",
  url: "/include/count-input.php",
  data: "id="+iid+"&count="+incount,
  dataType: "html",
  cache: false,
  success: function(data) {
  $("#input-id"+iid).val(data);  
  loadcart();
    
  // переменная с ценной продукта
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  // Цену умножаем на колличество
  result_total = Number(priceproduct) * Number(data);


  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" руб");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  itog_price();

      }
}); 
  }
});

function  itog_price(){
 
 $.ajax({
  type: "POST",
  url: "/include/itog_price.php",
  dataType: "html",
  cache: false,
  success: function(data) {

  $(".itog-price > strong").html(data);

}
}); 
       
}

$('#button-send-review').click(function(){
                
   var name = $("#name_review").val();
   var good = $("#good_review").val();
   var bad = $("#bad_review").val();
   var comment = $("#comment_review").val();
   var iid = $("#button-send-review").attr("iid");

    if (name != "")
     {
          name_review = '1';
          $("#name_review").css("borderColor","#DBDBDB");
      }else {
           name_review = '0';
           $("#name_review").css("borderColor","#FDB6B6");
      }
                  
    if (good != "")
       {
          good_review = '1';
          $("#good_review").css("borderColor","#DBDBDB");
      }else {
          good_review = '0';
          $("#good_review").css("borderColor","#FDB6B6");
      }
            
    if (bad != "")
     {
          bad_review = '1';
          $("#bad_review").css("borderColor","#DBDBDB");
     }else {
          bad_review = '0';
          $("#bad_review").css("borderColor","#FDB6B6");
     } 
                                         
            
            // Глобальная проверка и отправка отзыва
            
    if ( name_review == '1' && good_review == '1' && bad_review == '1')
      {
         $("#button-send-review").hide();
         $("#reload-img").show();
                  
      $.ajax({
         type: "POST",
         url: "/include/add_review.php",
         data: "id="+iid+"&name="+name+"&good="+good+"&bad="+bad+"&comment="+comment,
         dataType: "html",
         cache: false,
         success: function(data) {
         	$("#button-send-review").show();
         	$("#reload-img").hide();
         	setTimeout(function(){
        	    $.fancybox.close();
         	    $("#name_review").val("");
                $("#good_review").val("");
                $("#bad_review").val("");
                $("#comment_review").val("");
         	}, 1000);
         	var reviewsDiv = $("#reviews_content");
         	reviewsDiv.html(reviewsDiv.html()+data);
         }
         });  
         }         
});

$('#likegood').click(function(){
          
 var tid = $(this).attr("tid");
 
 $.ajax({
  type: "POST",
  url: "/include/like.php",
  data: "id="+tid,
  dataType: "html",
  cache: false,
  success: function(data) {  
  
  if (data == 'no')
  {
    alert('Ваш голос уже засчитан!');
  }  
   else
   {
    $("#likegoodcount").html(data);
   }

}
});
});

/* События на нажатие клавишь только для регистрации! */
	var onlyLetterAllowed = function (eventArgs) {
	    var allowedRegexp = /[A-Za-zА-Яа-яЁё]/;
		if(!allowedRegexp.test(eventArgs.key))
		{
		    return false;
		}
	};
	var telephoneAllowed = function (eventArgs) {
	    var allowedRegexp = /[0-9+()-]/;
		if(!allowedRegexp.test(eventArgs.key))
		{
		    return false;
		}
	};
	
	$('#reg_name').keypress(onlyLetterAllowed);
	$('#reg_surname').keypress(onlyLetterAllowed);
	$('#reg_patronymic').keypress(onlyLetterAllowed);
	$('#reg_phone').keypress(telephoneAllowed);
/* Конец события для регистрации */
});

function anchorScroller(el, duration) {
	if (this.criticalSection) {
		return false;
	}
	
	if ((typeof el != 'object') || (typeof el.href != 'string'))
		return true;
	
	var address = el.href.split('#');
	if (address.length < 2)
		return true;
	
	address = address[address.length-1];
	el = 0;
	
	for (var i=0; i<document.anchors.length; i++) {
		if (document.anchors[i].name == address) {
			el = document.anchors[i];
			break;
		}
	}
	if (el === 0)
		return true;
		
	this.stopX = 0;
	this.stopY = 0;
	do {
		this.stopX += el.offsetLeft;
		this.stopY += el.offsetTop;
	} while (el = el.offsetParent);
	
	this.startX = document.documentElement.scrollLeft || window.pageXOffset || document.body.scrollLeft;
	this.startY = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
	
	this.stopX = this.stopX - this.startX;
	this.stopY = this.stopY - this.startY;
	
	if ( (this.stopX == 0) && (this.stopY == 0) )
		return false;
	
	this.criticalSection = true;
	if (typeof duration == 'undefined')
		this.duration = 500;
	else
		this.duration = duration;
			
	var date = new Date();
	this.start = date.getTime();
	this.timer = setInterval(function () {	
		var date = new Date();
		var X = (date.getTime() - this.start) / this.duration;
		if (X > 1)
			X = 1;
		var Y = ((-Math.cos(X*Math.PI)/2) + 0.5);
		
		cX = Math.round(this.startX + this.stopX*Y);
		cY = Math.round(this.startY + this.stopY*Y);
		
		document.documentElement.scrollLeft = cX;
		document.documentElement.scrollTop = cY;
		document.body.scrollLeft = cX;
		document.body.scrollTop = cY;
		
		if (X == 1) {
			clearInterval(this.timer);
			this.criticalSection = false; 
		}
	}, 10);
	return false;
}

(function ($) {
  var SlideSpeed = 700;
  var TimeOut = 5000;
   
  $(document).ready(function(e) {
    $('.slide').css(
      {"position" : "absolute",
       "top":'0', "left": '0'}).hide().eq(0).show();
    var slideNum = 0;
    var slideTime;
    slideCount = $(".slider-content .slide").size();
    var animSlide = function(arrow){
      clearTimeout(slideTime);
      $('.slide').eq(slideNum).fadeOut(SlideSpeed);
      if(arrow == "next"){
        if(slideNum == (slideCount-1)){slideNum=0;}
        else{slideNum++}
        }
      else if(arrow == "prew")
      {
        if(slideNum == 0){slideNum=slideCount-1;}
        else{slideNum-=1}
      }
      else{
        slideNum = arrow;
        }
      $('.slide').eq(slideNum).fadeIn(SlideSpeed, rotator);
      $(".control-slide.active").removeClass("active");
      $('.control-slide').eq(slideNum).addClass('active');
      }
    var $adderSpan = '';
    $('.slide').each(function(index) {
        $adderSpan += '<span class = "control-slide">' + index + '</span>';
      });
    $(".control-slide:first").addClass("active");
    $('.control-slide').click(function(){
    var goToNum = parseFloat($(this).text());
    animSlide(goToNum);
    });
    var pause = false;
    var rotator = function(){
        if(!pause){slideTime = setTimeout(function(){animSlide('next')}, TimeOut);}
        }
    $('.slide > div h2').hover(	
      function(){clearTimeout(slideTime); pause = true;},
      function(){pause = false; rotator();
      });
    rotator();
  });
  })(jQuery);