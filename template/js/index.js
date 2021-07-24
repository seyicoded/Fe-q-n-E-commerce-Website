$(document).ready(function(){
    //document.getElementsByClassName("auto-text").innerHTML = "";
    $(".auto-text").html("");
    var text = "All Your Business Needs";
    var speed = 50;
    var start = 0;
    autotext(text,speed,start);
    
    $(".obj12").on("mouseover",function(){
        //this.classList.toggle("w3-animate-zoom");
    }); 
    $(".obj12").on("mouseout",function(){
        this.classList.toggle("w3-animate-spin");
    });
    
    
    var win_s = $(window).width();
    var doc_s = $(document).width();
    var cont_s = $("#content").width();
    var html_s = $("html").width();
    var body_s = $("body").width();
    
    console.log("window size"+win_s+" , document size"+doc_s +"and content"+cont_s+" and html size "+html_s+" and body size "+body_s);
    
    /*
    $(window).width($("#content").width());
    $(document).width($("#content").width());
    $("html").width($("#content").width());
    */
    
    console.log("window size"+win_s+" , document size"+doc_s +"and content"+cont_s+" and html size "+html_s+" and body size "+body_s);
    
});

function random_color(){
    //#000000        
    var r = Math.floor(Math.random() * 10)+''+Math.floor(Math.random() * 10)+''+Math.floor(Math.random() * 10)+''+Math.floor(Math.random() * 10)+''+Math.floor(Math.random() * 10)+''+Math.floor(Math.random() * 10)+'';
    return ("#"+r);
}                     

function autotext(a,b,c){
    if(c < a.length){
        var ma = "<div class='tag' style='color:"+random_color()+";'>"+a.charAt(c)+"</div>";
        //document.getElementsByClassName("auto-text").innerHTML += ma;
        $(".auto-text").append(ma);
        c++;
        setTimeout(autotext,b , a, b,c);
    }else{

        var a = "Import And Export Service";
        var b = 50;
        var c = 0;
        setTimeout(function(){$(".auto-text").html('');autotext1(a,b,c);},2000);
    }
}
function autotext1(a,b,c){
    if(c < a.length){
        var ma = "<div class='tag' style='color:"+random_color()+";'>"+a.charAt(c)+"</div>";
        //document.getElementsByClassName("auto-text").innerHTML += ma;
        $(".auto-text").append(ma);
        c++;
        setTimeout(autotext1,b , a, b,c);
    }else{

        var a = "Herbal Network Marketing";
        var b = 50;
        var c = 0;
        setTimeout(function(){$(".auto-text").html("");autotext2(a,b,c);},2000);
    }
}
function autotext2(a,b,c){
    if(c < a.length){
        var ma = "<div class='tag' style='color:"+random_color()+";'>"+a.charAt(c)+"</div>";
        //document.getElementsByClassName("auto-text").innerHTML += ma;    
        $(".auto-text").append(ma);    
        c++;
        setTimeout(autotext2,b , a, b,c);
    }else{

        var a = "All Your Business Needs";
        var b = 50;
        var c = 0;                                   
        setTimeout(function(){$(".auto-text").html("");autotext(a,b,c);},2000);
    }
}

function scroll_to_btm(){
    alert("Check Site Footer/Bottom");
}
function modal_about(){
    
}
function more_info(pid){
    $("#more_info_modal").show();
    var srn = $("#more_info_ajax_render");
    
    var aj = createajax();
    var fd = new FormData();
    
    fd.append("load_full_info","true");
    fd.append("pid",pid);
    
    aj.onreadystatechange = function(){
        if(aj.readyState == 4 && aj.status == 200){
            srn.html(aj.responseText);
        }
        if(aj.readyState < 4 && aj.status == 200){
            srn.text("Loading Page Please wait...");
        }
        if(aj.readyState <= 4 && aj.status == 404){
            srn.text("An Error Occur While Loading Page...");
        }
    }
    
    aj.open("POST","ajax/loadproduct.php",true);
    aj.send(fd);
}

var amt = 0;

function buy(name,price){
    $("#buy_modal").show();
    $("input[name='pname']").val(name);
    $("input[name='pprice']").val("N"+price+" for cost of one");
    amt = price;
    $("#amount").text(price);
}

function purchase(){
    var noti = $("#notification");
    noti.html("Initializing Purchase");
    
    var p_name = $("input[name='pname']").val();
    var p_price = $("input[name='pprice']").val();
    var p_quantity = $("input[name='pquantity']").val();
    var u_name = $("input[name='uname']").val();
    var u_phone = $("input[name='uphone']").val();
    var u_email = $("input[name='uemail']").val();
    var u_address = $("textarea[name='uaddress']").val();
    
    //noti.html(p_name+p_price+p_quantity+u_name+u_phone+u_email+u_address);
    
    noti.html("Creating Purchase");
    var aj = createajax();
    var fd = new FormData();
    
    fd.append("purchase","true");
    fd.append("p_name",p_name);
    fd.append("p_price",p_price);
    fd.append("p_quantity",p_quantity);
    fd.append("u_name",u_name);
    fd.append("u_phone",u_phone);
    fd.append("u_email",u_email);
    fd.append("u_address",u_address);
    
    noti.html("Sending Purchase");
    
    aj.onreadystatechange = function(){
        if(aj.readyState == 4 && aj.status == 200){
            noti.html(aj.responseText);
        }
        if(aj.readyState < 4 && aj.status == 200){
            noti.html("Processing Purchase Please Wait");
        }
        if(aj.readyState <= 4 && aj.status == 404){
            noti.html("Sorry Error Connecting to Server");
        }
    }
    
    aj.open("POST","ajax/purchase_product.php",true);
    aj.send(fd);
}

function messageus(){
    var noti = $("#noti-6");
    
    noti.html('Initialising Request');
    var name = $("input[name='cname']").val();
    var email = $("input[name='cemail']").val();
    var tel = $("input[name='ctel']").val();
    var message = $("textarea[name='cmessage']").val();
    
    //noti.html(name+email+tel+message);
    
    noti.html("Creating Request");
    var aj = createajax();
    var fd = new FormData();
    
    fd.append("messageus","true");
    fd.append("name",name);
    fd.append("email",email);
    fd.append("tel",tel);
    fd.append("message",message);
    
    noti.html("Sending...");
    
    aj.onreadystatechange = function(){
        if(aj.readyState == 4 && aj.status == 200){
            noti.html(aj.responseText);
        }
        if(aj.readyState < 4 && aj.status == 200){
            noti.html("Processing Purchase Please Wait");
        }
        if(aj.readyState <= 4 && aj.status == 404){
            noti.html("Sorry Error Connecting to Server");
        }
    }
    
    aj.open("POST","ajax/messageus.php",true);
    aj.send(fd);
}


document.addEventListener("contextmenu",function(e){
    //alert(e.button);    
    if(e.target.nodeName === "IMG"){
        e.preventDefault();
    }
    
},false);