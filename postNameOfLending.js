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

    location.href="BUYLENDING.php";

}