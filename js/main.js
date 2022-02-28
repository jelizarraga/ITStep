//get job function
function getRecords(){
    var id = document.getElementById('inputSearch').value;
    console.log('Getting data...');
    //create request
    var x = new XMLHttpRequest();
    //prepare request
    if(id != ''){
        x.open('GET', urlController + 'recordController.php?pcId=' + id, true);
    }else{
        x.open('GET', urlController + 'recordController.php', true);
    }
    //send request
    x.send();
    //handle readystate change event
    x.onreadystatechange = function() {
        // check status
        // status : 200=OK, 404=Page not found, 500=server denied access
        // readyState : 4=Back with data
        if(x.status == 200 && x.readyState == 4){
            //show questions
            showRecords(x.responseText);
        }
    }
}

//show job data
function showRecords(data){
    //table
    var table = document.getElementById('dataTable');
    //clear table
    table.innerHTML = '';
    //parse to json
    var JSONdata = JSON.parse(data);
    //get list array
    var devices = JSONdata.record;
    //console log
    console.log(JSONdata);
    //show data
    for(var i = 0; i < devices.length; i++){
        //create tr
        var row = document.createElement('tr');
        row.setAttribute('onClick', 'getDetail(' + devices[i].device.id +')')
        //create PC Number field
        var cellNumber = document.createElement('td')
        if(devices[i].id.length = 3){
            cellNumber.innerHTML = '0' + devices[i].device.id;
        }else{
            cellNumber.innerHTML = devices[i].device.id;
        }
        //create OS field
        var cellUser = document.createElement('td')
        cellUser.innerHTML = devices[i].user.name;
        //create model field
        var cellDepartment = document.createElement('td')
        cellDepartment.innerHTML = devices[i].user.department.department;
        //create type field
        var cellModel = document.createElement('td')
        cellModel.innerHTML = devices[i].device.model;
        //create office field
        var cellType = document.createElement('td')
        cellType.innerHTML = devices[i].device.deviceType.type;
        //create date field
        var cellAssignationDate = document.createElement('td')
        cellAssignationDate.innerHTML = devices[i].assignationDate.date;
        //create ram field
        var cellRam = document.createElement('td')
        cellRam.innerHTML = devices[i].device.ram + ' GB';
        //create edit field
        var cellDetail = document.createElement('td');
        var btnDetail = document.createElement('button');
        btnDetail.className = 'btn btn-primary';
        btnDetail.innerHTML = 'See Detail';
        //add data to table
        table.appendChild(row);
        row.appendChild(cellNumber);
        row.appendChild(cellUser);
        row.appendChild(cellDepartment);
        row.appendChild(cellModel);
        row.appendChild(cellType);
        row.appendChild(cellAssignationDate);
        row.appendChild(cellRam);
        cellDetail.appendChild(btnDetail);
        row.appendChild(cellDetail);
    }
}

function getDetail(id){
    console.log('Getting data...');
    //create request
    var x = new XMLHttpRequest();
    //prepare request
    x.open('GET', urlController + 'recordController.php?pcId=' + id, true);
    //send request
    x.send();
    //handle readystate change event
    x.onreadystatechange = function() {
        // check status
        // status : 200=OK, 404=Page not found, 500=server denied access
        // readyState : 4=Back with data
        if(x.status == 200 && x.readyState == 4){
            //show questions
            showDetails(x.responseText);
        }
    }
}

function showDetails(data){
    document.getElementById('detaildDiv').style.display = 'inline';
    //parse to json
    var JSONdata = JSON.parse(data);
    //get list array
    var records = JSONdata.record;
    //console log
    console.log(JSONdata);
    //show data
    for(var i = 0; i < records.length; i++){
        if(records[i].device.id.length = 3){
            document.getElementById('txtNumber').value = 'femsa0' + records[i].device.id;
        }else{
            document.getElementById('txtNumber').value = 'femsa' + records[i].device.id;
        }
        document.getElementById('txtUser').value = records[i].user.name;
        document.getElementById('txtType').value = records[i].device.deviceType.type;
        document.getElementById('txtCpuDescription').value = records[i].cpuDescription;
        document.getElementById('txtRam').value = records[i].device.ram + ' GB';
        document.getElementById('txtOs').value = 'Windows ' + records[i].device.operativeSystem;
        document.getElementById('txtOSKey').value = records[i].device.opKey;
        document.getElementById('txtOffice').value = records[i].device.office;
        document.getElementById('txtOfficeKey').value = records[i].device.officeKey;
        document.getElementById('txtDepartment').value = records[i].user.department.department;
        document.getElementById('txtPO').value = records[i].device.po;
        document.getElementById('txtSerie').value = records[i].device.serialNumber;
        document.getElementById('txtModel').value = records[i].device.model;
        document.getElementById('txtTag').value = records[i].device.tag;
        document.getElementById('txtDate').value = records[i].assignationDate.date;
        document.getElementById('txtComment').value = records[i].device.comments;
    }
}