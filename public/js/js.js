
window.onload = function (){
   // alert('loaded');
}

function markUser(id){
    if(confirm("Really?"))
    {
        let xhttp;
        xhttp = new XMLHttpRequest();
        let urlcommand = getClearUrl()+ '/command' + "?markid="+id;
        //console.log("urlcommand=" + urlcommand);
        xhttp.open("GET", urlcommand, true);
        xhttp.send();
        setTimeout(reloadPage, 1000);
    }
}

function unMarkUser(id){
    if(confirm("Really?")) {
        let xhttp;
        xhttp = new XMLHttpRequest();
        let urlcommand = getClearUrl() + '/command' + "?unmarkid=" + id;
        //console.log("urlcommand=" + urlcommand);
        xhttp.open("GET", urlcommand, true);
        xhttp.send();
        setTimeout(reloadPage, 500);
    }
}

function getClearUrl(){
    let url = window.location.href;
    if(url.indexOf("?")==-1){
        return url;
    }
    else {
        if((url.indexOf("/filter")==-1)){
            url = url.slice(0, url.indexOf("?"));
        }else{
            url = url.slice(0, url.indexOf("/filter"));
        }
        return url;
    }
}

function reloadPage(){
    window.location.reload();
}
