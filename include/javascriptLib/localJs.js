/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function deletBook(formId, rfiled, value, tableID, rowID, phpFileUrl, divID, method) {
    setValue(rfiled, value);
    var success = new Boolean();
    alert(lightFormPost(formId, success));
    //if(delRow)removeRow(tableID, rowID);    
}

function editMood(fieldId) {
    document.getElementById(fieldId).select();

}
function isElementExist(elementID) {
    var element = document.getElementById(elementID);
    if (typeof(element) != 'undefined' && element != null)
    {
        return true;
    }
    return false;
}
function editBook(formName, lFieldNameArray, rFieldNameArray, rvalues, rFields) {
//  lFieldNameArray
    //for(var i = 0 ; i<rFieldNameArray.length; i++) alert(document.getElementById(rFieldNameArray[i]).value);

    if (lFieldNameArray.length === rFieldNameArray.length) {
        for (var i = 0; i < lFieldNameArray.length; i++)
            if (isElementExist(lFieldNameArray[i]) && isElementExist(rFieldNameArray[i]))
                if (lFieldNameArray[i].indexOf("t") === 0)
                    document.getElementById(rFieldNameArray[i]).value = document.getElementById(lFieldNameArray[i]).innerHTML;
                else
                    exchanged(lFieldNameArray[i], rFieldNameArray[i]);
        if (rFields.length === rvalues.length)
            for (var i = 0; i < rFields.length; i++)
            {
                setValue(rFields[i], rvalues[i]);
            }
        var success = false;
        lightFormPost(formName, success);
    }
    else {
        consol.log("Length Doesn't Match ");
    }
}

function lightFormPost(formId, success) {
    //alert(formId);

    formId = "#" + formId;
    url = $(formId).attr('action');
    data = $(formId).serialize();
    var posting = $.post(url, data)
            .done(function( ) {
        alert("Update Success .... ");
        //      window.location=window.location.protocol + "\\" + window.location.host + "/" + window.location.pathname ;
    })
            .fail(function() {
        alert("System Failure , Try again Later ");
    });

}
function print2Consol(rFieldNameArray) {
    for (var i = 0; i < rFieldNameArray.length; i++)
        if (isElementExist(rFieldNameArray[i]))
            console.log(rFieldNameArray[i] + " = " + document.getElementById(rFieldNameArray[i]).value);
}
function selectCopyMe(rElementId, lElementId, selectedId, action) {
    var remoteElement = document.getElementById(rElementId);
    var localElement = document.getElementById(lElementId);
    var value = remoteElement.innerHTML;
    localElement.innerHTML = "<select id='sbookCategory" + selectedId + "' name='sbookCategory" + selectedId + "'" + action + ">" + value + "</select>";
    var selection = document.getElementById("sbookCategory" + selectedId);
    setSelectValue("sbookCategory" + selectedId, selectedId);
    var patt1 = /[0-9]/g;
    var buttonID = "";
    var lID = ((lElementId).match(patt1));
    for (var i = 0; i < lID.length; i++)
        buttonID += lID[i];
    showDiv("Edit_Book" + parseInt(buttonID));
}
function setSelectValue(id, val) {
    document.getElementById(id).value = val;
}
function checkBoxClicked(id, editButtonID) {
    showDiv('Edit_Book' + editButtonID);
    updateCheckBox(id);
}

function formSub(id) {
    var form = document.forms[id];
    var parameter = form.elements[0].name + "=" + form.elements[0].value;

    for (var i = 1; i < form.length; i++)
        parameter += "&" + form.elements[i].name + "=" + form.elements[i].value;
    return parameter;
}
function showDiv(divId) {
    document.getElementById(divId).style.display = "block";

}
function hideDiv(divId) {
    document.getElementById(divId).style.display = "none";

}
function exchanged(lfid, rfid) {
    // alert(lfid+" -> "+rfid);
    var localElement = document.getElementById(lfid);
    var remoteElement = document.getElementById(rfid);

    remoteElement.value = localElement.value;

    // alert(remoteElement.value +"="+ localElement.value);
}
function setValue(rfid, value) {
    var remoteElement = document.getElementById(rfid);
    remoteElement.value = value;

}
function removeRow(tableID, rowIndex) {

    var i = rowIndex.parentNode.parentNode.rowIndex;
    var element = document.getElementById(tableID);
    element.deleteRow(i);

}
function tableManagment(tableID, cellX, dataX)
{
    var table = document.getElementById(tableID);
    var row = table.insertRow(2);

    for (var i = 0; i < cellX; i++) {
        var cell = row.insertCell(i);

        cell.innerHTML = "" + dataX[i];
    }
}
function divRelation(rDiv, lId) {
    var localElement = document.getElementById(lId).value;
    if (localElement === -1) {
        hideDiv(rDiv);
    }
    else
        showDiv(rDiv);
}
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
function updateText(id) {
    //Get contents off cell clicked
    if (document.getElementById(id).firstChild !== "[object HTMLInputElement]") {
        var content = document.getElementById(id).firstChild.nodeValue;
        //Switch to text input field
        document.getElementById(id).innerHTML = "<input type = 'text' name = '" + id + "' id = '" + id + "' value = '" + content + "'/>";
    }
}

function updateCheckBox(id) {
    //Get contents off cell clicked
    if (document.getElementById(id).firstChild !== "[object HTMLInputElement]") {
        var content = document.getElementById(id).firstChild.nodeValue;
        //Switch to text input field<input type="checkbox" name="is_Hidden" id="is_Hidden" value="1" checked="checked"  
        //      onclick="setHidden(this.id);exchanged(this.id, 'hideBook');"/>
        if (content === "N/A")
        {
            setValue("eIs_Hidden", 0);
            document.getElementById(id).innerHTML = "<input type='checkbox' name='is_Hidden_" + id + "' id='is_Hidden_" + id + "' value='0' onclick=\"setHidden(this.id);exchanged(this.id,'eIs_Hidden');\" />";
        }
        else
        {
            setValue("eIs_Hidden", 1);
            document.getElementById(id).innerHTML = "<input type='checkbox' name='is_Hidden_" + id + "' id='is_Hidden_" + id + "' value='1' onclick=\"setHidden(this.id);exchanged(this.id,'eIs_Hidden');\" checked/>";
        }
    }
}
function disableDive(divId) {
    document.getElementById(divId).style.disable = "disabled";
}
function setHidden(id) {
    var element = document.getElementById(id);
    var val = element.value;
    if (val === "1") {
        element.value = "0";
    }
    else
        element.value = "1";

}


function showjspajax(jspFileUrl, argumentsStr, divId, method) {

    var xmlHttp // declare variable

    if (typeof XMLHttpRequest != "undefined") {
        xmlHttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (xmlHttp == null) {
        alert("Browser does not support XMLHTTP Request")
        return;
    }
    var url = jspFileUrl;
    if (method === "GET")url += "?" + argumentsStr;
    
    xmlHttp.open(method, url, true);

    if (method === "GET") {
        xmlHttp.send(null);
    }
    else {
        xmlHttp.send(argumentsStr);
    }
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState === 4 || xmlHttp.readyState === "complete") {
            document.getElementById(divId).innerHTML = xmlHttp.responseText;
        }
    };



}