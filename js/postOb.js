function ajaxRequest()
{
    try // Non IE Browser?
    {

        var request = new XMLHttpRequest()
    }
    catch(e1)
    {
        try // IE 6+?
        {

            request = new ActiveXObject("Msxml2.XMLHTTP")
        }
        catch(e2)
        {
            try // IE 5?
            {

                request = new ActiveXObject("Microsoft.XMLHTTP")
            }
            catch(e3) // There is no AJAX Support
            {
                request = false
            }
        }
    }
    return request
}
function clicked(lendingName){
    /*params = "lendingName=kjhjjl";
    request = new ajaxRequest();
    request.open("POST", "BUYLENDING.php", true);
    request.setRequestHeader("Content-type",
        "application/x-www-form-urlencoded");
    request.setRequestHeader("Content-length", params.length);
    request.setRequestHeader("Connection", "close");
    request.onreadystatechange = function()
    {
        if (this.readyState == 4)
        {
            if (this.status == 200)
            {
                if (this.responseText != null)
                {

                }
                else alert("Ajax error: No data received")
            }
            else alert( "Ajax error: " + this.statusText)
        }
    }
    request.send(params);*/
    var xhr = new ajaxRequest();
    var params = "lendingName=" + lendingName;
    xhr.open('POST', 'BUYLENDING.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
        }
    }
    xhr.send(params);
    location.href="BUYLENDING.php";

}