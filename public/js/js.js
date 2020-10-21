"use strict";
var obj;
window.onload = function (){
    obj = {
        markUserObj : function(id) {
            if(confirm("Really?")) {
                let xhttp;
                xhttp = new XMLHttpRequest();
                let urlcommand = this.getClearUrl()+ '/changeHealthStatus' + "?markid="+id;
                xhttp.open("GET", urlcommand, true);
                xhttp.send();
                setTimeout(this.reloadPage, 1000);
            }
        },

        unMarkUserObj : function(id) {
            if(confirm("Really?")) {
                let xhttp;
                xhttp = new XMLHttpRequest();
                let urlcommand = this.getClearUrl() + '/changeHealthStatus' + "?unmarkid=" + id;
                xhttp.open("GET", urlcommand, true);
                xhttp.send();
                setTimeout(this.reloadPage, 500);
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

        editModalWindowOutObj : function(author_id, target_id, login, logined_user_id) {
            let spanForLogin = document.getElementById("loginSpan");
            spanForLogin.innerText = login;
            this.getAllMessages(author_id, target_id);
        },

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
        }
    };
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
