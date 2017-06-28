$(document).ready( function(){
    //focus mouse on input
    $("#mainInput").focus();
    //valid mainInput
    var objValidator = {
        clickValid: function (regExp,mass) {
            var objForAjax = {};
            for (var i = 0; i < mass.length; i++) {
                if(mass[i].search(regExp) != -1) {
                    objForAjax[i] = mass[i];
                }else {
                    if (i==0) {
                        alert("Неверный формат ссылки");
                        return false;
                    }
                    alert("Неверный формат ссылки №" + (i+1));
                    return false;
                }
            }
            this.ajaxFunc(objForAjax);
        },
        ajaxFunc: function (obj) {
            $.ajax({
                url:"handler",
                type:"GET",
                data: obj,
                success: function (data) {
                    $('#test').html(data);
                }
            })
        }
    }
    $("#form").submit(function (){
        var regExp = /[\s\S]{1,}\.+[\s\S]{2,}/gi;
        var inputValue = $("#mainInput")[0].value.split(' ');
        objValidator.clickValid(regExp,inputValue);
        return false;
    })
});