"use strict";
var obj;
var numberOfMessages;
var messagesChecker;

obj = {

    MarkUserObj : function(id) {
        if(confirm("Really?")) {
            let xhttp;
            xhttp = new XMLHttpRequest();
            let urlcommand = this.getClearUrl()+ '/changeHealthStatus' + "?id="+id;
            xhttp.open("GET", urlcommand, true);
            xhttp.send();
            setTimeout(this.reloadPage, 1000);
        }
    },

    getClearUrl : function() {
        let url = window.location.href;
        if(url.indexOf("?")==-1) {
            return url;
        } else {
            if((url.indexOf("/filter")==-1)) {
                url = url.slice(0, url.indexOf("?"));
            }else{
                url = url.slice(0, url.indexOf("/filter"));
            }
            return url;
        }
    },

    reloadPage : function() {
        window.location.reload();
    },
//set login to span in modal window and start function getAllMessages
    editModalWindowOutObj : function(author_id, target_id, login, logined_user_id) {
        let spanForLogin = document.getElementById("loginSpan");
        spanForLogin.innerText = login;
        numberOfMessages = 0;
        this.getAllMessages(author_id, target_id);
        //this.startTimerChecker(author_id, target_id);
        messagesChecker = setInterval(function() {
            obj.startTimerChecker(author_id, target_id);
        }, 2000);
    },

    startTimerChecker : function (author_id, target_id){
        let spanNotif = document.getElementById('span_notification');
        let divModalContainer = document.getElementById("modalID");
        if(divModalContainer.style.display=='none'){
            clearInterval(messagesChecker);
            window.location.reload();
        }
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let res = this.responseText;
                let resArray = JSON.parse(res);
                if(resArray.length > numberOfMessages){//incoming message appeared
                    numberOfMessages = resArray.length;
                    spanNotif.innerText = "New message at " + obj.printDate();
                    obj.reloadMessagesObj();
                }else{
                    spanNotif.innerText = resArray.length + " messages at " + obj.printDate();
                }
            }
        };
        let url = this.getClearUrl() + '/show?target_id=' + target_id;
        xhttp.open("GET", url, true);
        xhttp.send();
    },

    stopTimerObj : function (){
        clearInterval(messagesChecker);
        window.location.reload();
    },

//get JSON response with all messages
    getAllMessages : function (author_id, target_id) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let res = this.responseText;
                obj.printAllMessagesObj(author_id, target_id, res, author_id);
            }
        };
        let url = this.getClearUrl() + '/show?target_id=' + target_id;
        xhttp.open("GET", url, true);
        xhttp.send();
    },

    //This func. take json string with messages and print them in modal window
    printAllMessagesObj : function(author_id, target_id, jsonText, logined_user_id) {
        let resArray = JSON.parse(jsonText);
        numberOfMessages = resArray.length;
        let resHtml = '';
        for (let i = 0; i < resArray.length; i ++) {
            resHtml+='<div class="msg_class ';
            if (resArray[i]['author_id'] == logined_user_id) {
                resHtml+='float-right"';
            } else {
                resHtml+='float-left"';
            }
            resHtml+='>' +
                        '<p class="msg-date"><i>From ' + resArray[i]['message_date'] + '</i></p>' +
                        '<p class="msg-text">' + resArray[i]['text'] + '</p>' +
                    '</div>'
        }
        document.getElementById("msgList").innerHTML = resHtml;
        let textArea = document.getElementById("textToSend");
        textArea.setAttribute("data-target_id", target_id);
        textArea.setAttribute("data-author_id", author_id);
    },
    //Send message from textarea to controllers action create
    sendNewMessageObj : function () {
        let textArea = document.getElementById("textToSend");
        let xhttp = new XMLHttpRequest();
        let url = this.getClearUrl() + '/create?target_id=' + textArea.dataset.target_id + "&author_id=" + textArea.dataset.author_id + "&text=" + textArea.value;
        xhttp.open("GET", url, true);
        xhttp.send();
        setTimeout(function() {
            obj.getAllMessages(textArea.dataset.author_id, textArea.dataset.target_id);
        }, 300);
    },
    //if new message incomes this func start 'getAllMessages' func to reload list of messages in modal window
    reloadMessagesObj : function () {
        let textArea = document.getElementById("textToSend");
        this.getAllMessages(textArea.dataset.author_id, textArea.dataset.target_id);
    },
    //func insert user data from select input to modal window
    prepareDataToWriteMessageObj : function (author_id) {
        let selectInput = document.getElementById('selectNewUser');
        this.editModalWindowOutObj(author_id, selectInput.options[selectInput.selectedIndex].value, selectInput.options[selectInput.selectedIndex].text, 0);
    },

    printDate : function(){
    var currentdate = new Date();
    var datetime = currentdate.getFullYear() + "."
        + (currentdate.getMonth()+1)  + "."
        + currentdate.getDate() + "-"
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();
    return datetime;
    },
    /*Javascript for map of cities*/
    getAllCitiesObj : function() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let res = this.responseText;
                let resArray = JSON.parse(res);
                obj.loadMap(resArray);
            }
        };
        let url = this.getClearUrl() + 'list';
        xhttp.open("GET", url, true);
        xhttp.send();
    },

    loadMap : function (locations) {
        let count;
        var center;
        if (locations.length==1) {
            center = {lat:  locations[0]['lat'], lng:  locations[0]['lon']};
        }else{
            let arrLatLon = this.findCenter(locations);
            center = {lat:  arrLatLon[0], lng:  arrLatLon[1]};
        }
        var mapOptions = {
            mapTypeId: 'roadmap',
            zoom: 5,
            center: center
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var contentString = [];
        let markers = [];
        var infowindow = [];
        for (count = 0; count < locations.length; count++) {
            markers[count] = [locations[count]['name'], locations[count]['lat'], locations[count]['lon'], locations[count]['description']];
            contentString[count] = '<div class="info_content">' +
            '<h3><a href="'+ this.getUrlForMap() +'filter?citiessearch=' + locations[count]['id'] +'" target="_blank" >' +
            locations[count]['name'] +
            '</a></h3>' +
            '<p>' +
            locations[count]['description'] +
            '</p></div>';
            infowindow[count] = new google.maps.InfoWindow({
                content: contentString[count],
                maxWidth: 400
            }, markers[count]);
        }

        // Display multiple markers on a map
        for(let i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            markers[i] = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
            });
            markers[i].addListener("click", ()=>infowindow[i].open(map, markers[i]))
        }
    },

    findCenter : function (locations)
    {
        let avgLatLon = [];
        let latSum =0.0, lonSum = 0.0;
        for(let i = 0; i < locations.length; i++){
            latSum += parseFloat(locations[i]['lat']);
            lonSum += parseFloat(locations[i]['lon']);
        }
        avgLatLon[0] = latSum/locations.length;
        avgLatLon[1] = lonSum/locations.length;
        return avgLatLon;
    },

    getUrlForMap : function () {
        let url = window.location.href;
        url = url.slice(0, url.indexOf("map"));
        return url;
    },

    showMapToChooseCityObj : function (){
        let arrLatLon = [];
        let latValue = 45.55;
        let lonValue = 35.55;
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 5,
            center: {lat: parseFloat(latValue), lng: parseFloat(lonValue)}
        };
        var map = new google.maps.Map(document.getElementById('map-city'), mapOptions);
        map.addListener("click", (mapsMouseEvent) => {
            arrLatLon = JSON.parse(JSON.stringify(mapsMouseEvent.latLng.toJSON()));
            document.getElementById('inp-city-lat').value = Number(arrLatLon['lat']).toFixed(6);
            document.getElementById('inp-city-lon').value = Number(arrLatLon['lng']).toFixed(6);
        });
    },

    /*showMessagesQuantityObj : function (){
        let tdMsgQuantity = document.getElementsByClassName("msg_quantity");
        for(let i = 0; i < tdMsgQuantity.length; i++){
            tdMsgQuantity[i].setAttribute("id", i);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let res = this.responseText;
                    obj.findMesQuantityForTwoUsers(res);
                }
            };
            let url = this.getClearUrl() + '/showCount?target_id=' + tdMsgQuantity[i].dataset.target_id + '&author_id=' + tdMsgQuantity[i].dataset.author_id + '&id=' + i;
            xhttp.open("GET", url, true);
            xhttp.send();
        }
    },*/

    findMesQuantityForTwoUsers(res){
        let tmpArr = res.split(":");
        document.getElementById(tmpArr[0]).innerText = tmpArr[1];
    },

    getClientIpObj : function (){
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let res = this.responseText;
                let resArray = JSON.parse(res);
                obj.sendClientIpToServer(resArray['ip']);
                document.getElementById('client_ip').value = resArray['ip'];
            }
        };
        let url = 'https://api.ipify.org/?format=json';
        xhttp.open("GET", url, true);
        xhttp.send();
    },

    sendClientIpToServer(res) {
        let xhttp = new XMLHttpRequest();
        let url = this.getClearUrl();
        let data = '?client_ip=' + res;
        xhttp.open("GET", url + data, true);
        xhttp.send();
    }
};

function getClientIp() {
    obj.getClientIpObj();
}

function showMapToChooseCity(){
    obj.showMapToChooseCityObj();
}

/*function showMessagesQuantity(){
    obj.showMessagesQuantityObj();
}*/

function MarkUser(id) {
    obj.MarkUserObj(id);
}

function markUser(id) {
    obj.markUserObj(id);
}

function unMarkUser(id) {
    obj.unMarkUserObj(id);
}

function editModalWindowOut(author_id, target_id, login, logined_user_id) {
    obj.editModalWindowOutObj(author_id, target_id, login, logined_user_id);
}

function sendNewMessage() {
    obj.sendNewMessageObj();
}

function reloadMessages() {
    obj.reloadMessagesObj();
}

function prepareDataToWriteMessage(author_id) {
    obj.prepareDataToWriteMessageObj(author_id);
}

function stopTimer() {
    obj.stopTimerObj();
}

function getAllCities() {
    obj.getAllCitiesObj();
}

$(document).ready(function() {
    let blHeader = $('.accord_header');
    let blockContent = $('.accord_content');

    let activeId;
    $(blockContent).slideUp(10);
    $(document).on('click', '.accord_header', function(e) {
        $(blockContent).slideUp(500);
        $(blHeader).css('border-radius', '20px 20px 20px 20px');
        if (!$(this).next().is(":visible")) {
            $(this).css('border-radius', '20px 20px 0 0');
            $(this).next().slideDown(500);
        }
    });
});

window.addEventListener("load", function(event) {
    console.log("window.addEventListener (load) worked in js.js");
});
