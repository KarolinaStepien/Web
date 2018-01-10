function onload2() {
    var cookies = document.cookie;
    //alert(cookies);
    swapStyleSheet(cookies.split("=")[1]);
    var uList = document.createElement('ul');
    var stylesList = ["stylRóżowy.css", "stylNiebieski.css", "stylDomyślny.css"];
    for (var i = 0; i < stylesList.length; i++) {
        var liElem = document.createElement('li');
        liElem.innerHTML = stylesList[i].split(".")[0];
        liElem.setAttribute("styleName", stylesList[i]);
        liElem.addEventListener("click", liOnclick);
        uList.appendChild(liElem);
    }
    document.body.appendChild(uList);
}

document.body.addEventListener("load", onload2, false);

function swapStyleSheet(sheet) {
    document.getElementById("pagestyle").setAttribute("href", sheet);
}

function liOnclick(event) {
    var liElem = event.target;
    var stylename = liElem.getAttribute("styleName");
    swapStyleSheet(stylename);
    document.cookie = "defaultStyle=" + stylename;
}