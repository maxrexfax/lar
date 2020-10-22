"use strict";
var obj;
var numberOfMessages;
var messagesChecker;
window.onload = function (){
    obj = {

        MarkUserObj : function(id) {
            if(confirm("Really?")) {
                let xhttp;
                xhttp = new XMLHttpRequest();
                let urlcommand = this.getClearUrl()+ '/changeHealthStatus' + "?id="+id;
                console.log('urlcommand=' + urlcommand);
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
                messagesChecker.clearTimeout();
            }
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let res = this.responseText;
                    let resArray = JSON.parse(res);
                    if(resArray.length > numberOfMessages){//incoming message appeared
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
            messagesChecker.clearTimeout();
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
        reloadMessagesObj : function () {
            let textArea = document.getElementById("textToSend");
            this.getAllMessages(textArea.dataset.author_id, textArea.dataset.target_id);
        },
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
            var center = {lat: 47.871633, lng: 35.053650};
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

        getUrlForMap : function () {
            let url = window.location.href;
            url = url.slice(0, url.indexOf("map"));
            return url;
        }
    };
}

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
