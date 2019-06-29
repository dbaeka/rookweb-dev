var xmlHttp = createXmlHttpRequestObject();

function createXmlHttpRequestObject(){
	var xmlHttp;
	if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}
	else{
		xmlHttp = new ActiveObject("Microsoft.XMLHTTP");
	}
	return xmlHttp;
}


function ratessolution(solution){
	$("#overlayrate").html('<div class="row" style="margin-top: 100px;"><div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3"><div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div><div class="midbxcnt" style="margin-top: 25px;background-color: #fff;padding: 10px 10px;"><div class="imghead" style="text-align: center;color: #4CAF50;margin: 0 auto;font-size: 50px;"><span class="ion ion-ios-lightbulb-outline"></span></div><p style="text-align: center;">Rate this Solution</p><div id="solutionxr" class="ratecntx"></div><div id="ratexbut" class="ratebutbx"></div></div></div></div>').fadeIn(200);
	var options = {
									max_value: 5,
									step_size: 1,
									selected_symbol_type: 'stars',
									initial_value: 0,
									symbols:{
											stars: {
													base: '<span class="ion ion-android-star-outline" style="color: #b4b4b4;margin:0 4px;"></span>',
													hover: '<span class="ion ion-android-star" style="color: #ffbd5b;margin:0 4px;"></span>',
													selected: '<span class="ion ion-android-star" style="color: #FF9800;margin:0 4px;"></span>',
											},
									}
								}

  $("#solutionxr").rate(options);
  $("#solutionxr").on("change", function(ev, data){
    var value = data.to;
    if(value > 0){
    	document.getElementById('ratexbut').innerHTML = '<button onClick="sendrate(\''+solution+'\',\''+value+'\')" style="width: 50%;" class="btn btn-space btn-sm btn-success hover"><i class="icon icon-left mdi mdi-check-all"></i> Submit</button>';
    }
  });
}


function sendrate(solution, rate){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			closepop();
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				if(xmlHttp.responseText == 'done'){
					$('#sol_'+solution).html('Rated: <b style="font-size:20px;">'+rate+'<i class="ion ion-android-star" style="color: #FF9800;"></i></b>');
					swal("Solution Rated!", "The solution has been rated successfully", "success");
				}
				else{
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=ratessolution&solution="+solution+"&rate="+rate);
	}
	else{
		setTimeout(function(){validate()},1000);
	}
}


function validate(){
	var username = $('#username').val();
	if(username.length > 2){
		$('#emg').fadeIn(200).html('checking...');
		if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					if(xmlHttp.responseText == 'done'){
						$('#emg').css("color", "green").fadeIn(200).html('<i class="icon ion-checkmark-round"></i> Username available');
						$('#subcnt').html('<button type="submit" class="btn btn-success waves-effect waves-light" name="subinfo" style="width: 100%;">Submit</button>');
					}
					else{
						$('#emg').css("color", "red").fadeIn(200).html('<i class="icon ion-close"></i> '+xmlHttp.responseText);
						$('#subcnt').html('');
					}
				}
			}
			xmlHttp.send("action=valusername&username="+username);
		}
		else{
			setTimeout(function(){validate()},1000);
		}
	}
	else{
		$('#emg').fadeOut(100).html('');
		$('#subcnt').html('');
	}
}


function activate(){
	loading();
	var code = document.getElementById('code').value;
	if(code == ''){
		$('#overlayload').fadeOut(50);
		swal("Error!", "Activation code required", "error");
		return;
	}

	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					$('#overlayload').fadeOut(50);
					if(xmlHttp.responseText == 'done'){
						swal({
              title: "Account Activated",
              text: "Your account has been activated successfully.",
              type: "success",
              showCancelButton: false,
              confirmButtonText: "Okay"
            }).then(function () {
              window.location.href = "dashboard";
            });
					}
					else{
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=activate&code="+code);
	}
	else{
		setTimeout(function(){activate()},1000);
	}
}


function uploadtask(task){
	$('#taskx').html('<input type="hidden" value="'+task+'" name="task">')
	$('#overlaytask').fadeIn(200);
}


function watchlist(student, state){
	$('#watchbut').html('<button class="btn btn-light disabled btn-sm">Wait...</button>').prop("disabled", true);

	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					if(xmlHttp.responseText == 'watch'){
						$('#watchbut').html('<button onclick="watchlist('+student+',\'1\')" class="btn btn-warning btn-sm btn-with-icon mg-t-10"><div class="ht-30"><span class="icon wd-30"><i class="ion-android-add" style="font-size: 20px;color: #fff;"></i></span><span class="pd-x-15">Add to Watch List</span></div></button>').prop("disabled", false);
					}
					else if(xmlHttp.responseText == 'unwatch'){
						$('#watchbut').html('<button onclick="watchlist('+student+',\'2\')" class="btn btn-danger btn-sm btn-with-icon mg-t-10"><div class="ht-30"><span class="icon wd-30"><i class="ion-android-close" style="font-size: 20px;color: #fff;"></i></span><span class="pd-x-15">Remove from Watch List</span></div></button>').prop("disabled", false);
					}
					else{
						if(state == '1'){
							$('#watchbut').html('<button onclick="watchlist('+student+',\'1\')" class="btn btn-warning btn-sm btn-with-icon mg-t-10"><div class="ht-30"><span class="icon wd-30"><i class="ion-android-add" style="font-size: 20px;color: #fff;"></i></span><span class="pd-x-15">Add to Watch List</span></div></button>').prop("disabled", false);
						}
						else if(state == '2'){
							$('#watchbut').html('<button onclick="watchlist('+student+',\'2\')" class="btn btn-danger btn-sm btn-with-icon mg-t-10"><div class="ht-30"><span class="icon wd-30"><i class="ion-android-close" style="font-size: 20px;color: #fff;"></i></span><span class="pd-x-15">Remove from Watch List</span></div></button>').prop("disabled", false);
						}
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=watchlist&student="+student);
	}
	else{
		setTimeout(function(){watchlist(student, state)},1000);
	}
}


function sub(company,state){
	$('#subscibe_'+company+'').removeClass("btn-primary btn-danger").prop("disabled", true);
	$('#subscibe_'+company+'').addClass("btn-light disabled").html('Wait...');

	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					if(xmlHttp.responseText == 'subscribe'){
						$('#subscibe_'+company+'').removeClass("btn-light disabled").addClass("btn-primary").prop("disabled", false).html('Subscribe');
					}
					else if(xmlHttp.responseText == 'unsubscribe'){
						$('#subscibe_'+company+'').removeClass("btn-light disabled").addClass("btn-danger").prop("disabled", false).html('Unsubscribe');
					}
					else{
						if(state == '1'){
							$('#subscibe_'+company+'').removeClass("btn-light disabled").addClass("btn-primary").prop("disabled", false).html('Subscribe');
						}
						else if(state == '2'){
							$('#subscibe_'+company+'').removeClass("btn-light disabled").addClass("btn-primary").prop("disabled", false).html('Subscribe');
						}
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=subscribe&company="+company);
	}
	else{
		setTimeout(function(){sub(company,state)},1000);
	}
}


function viewtask(task){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					var data = xmlHttp.responseText.split("|");
					if(data[0] == 'done'){
						$('#overlayload').html(data[1]);
					}
					else{
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=viewtask&task="+task);
	}
	else{
		setTimeout(function(){viewtask(task)},1000);
	}

}


function canceltask(task){
	$('#cancel').removeClass("btn-danger").prop("disabled", true);
	$('#cancel').addClass("btn-light disabled").html('Wait...');

	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					closepop();
					$('#cancel').removeClass("btn-light disabled").prop("disabled", true);
					$('#cancel').addClass("btn-danger").prop("disabled", false).html('Cancel');
					if(xmlHttp.responseText == 'done'){
						swal({
              title: "Task canceled successfully",
              text: "You have successfully canceled the task.",
              type: "success",
              showCancelButton: false,
              confirmButtonText: "Okay"
            }).then(function () {
              window.location.href = "profile";
            });
					}
					else{
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=canceltask&task="+task);
	}
	else{
		setTimeout(function(){canceltask(task)},1000);
	}
}


function begintask(task){
	$('#start').removeClass("btn-warning").prop("disabled", true);
	$('#start').addClass("btn-light disabled").html('Wait...');

	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					closepop();
					$('#start').removeClass("btn-light disabled").prop("disabled", true);
					$('#start').addClass("btn-warning").prop("disabled", false).html('Start Task');
					if(xmlHttp.responseText == 'done'){
						swal({
              title: "Task added successfully",
              text: "You have successfully added a new task.",
              type: "success",
              showCancelButton: false,
              confirmButtonText: "Okay"
            }).then(function () {
              window.location.href = "task?t="+task;
            });
					}
					else{
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=starttask&task="+task);
	}
	else{
		setTimeout(function(){begintask(task)},1000);
	}
}


function deletetask(task){
	$('#delete').removeClass("btn-danger").prop("disabled", true);
	$('#delete').addClass("btn-light disabled").html('Wait...');

	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					closepop();
					$('#delete').removeClass("btn-light disabled").prop("disabled", true);
					$('#delete').addClass("btn-danger").prop("disabled", false).html('Start Task');
					if(xmlHttp.responseText == 'done'){
						swal({
              title: "Task deleted successfully",
              text: "You have successfully deleted the task.",
              type: "success",
              showCancelButton: false,
              confirmButtonText: "Okay"
            }).then(function () {
              window.location.href = "company_profile";
            });
					}
					else{
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=deletetask&task="+task);
	}
	else{
		setTimeout(function(){deletetask(task)},1000);
	}
}


function delete_task(task){
	swal({
	  title: 'Are you sure?',
	  text: "This will remove the task",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  deletetask(task);
	})
}


function start_task(task){
	swal({
	  title: 'Are you sure?',
	  text: "This will be added to your task to be completed list",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  begintask(task);
	})
}


function cancel_task(task){
	swal({
	  title: 'Are you sure?',
	  text: "This will remove the task from your to do tasks and prevent you from trying it again",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  canceltask(task);
	})
}



function deleteaccad(ident,x){
	$('#preloader').fadeIn(500).css("background-color", "rgba(255, 255, 255, 0.84)");
	$('#status').fadeIn(500);
	
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					$('#preloader').fadeOut(50);
					$('#status').fadeOut(50);
					var data = xmlHttp.responseText.split("|");
					if(data[0] == 'done'){
						swal({
			            title: "Deleted Successful",
			            text: ident+"'s account has been deleted successfully",
			            type: "success",
			            showCancelButton: false,
			            confirmButtonText: "Okay!"
					        }).then(function () {   
					        	location.reload();
				       	});
					}
					else{
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=deleteacc&account="+ident+"&type="+x);
	}
	else{
		setTimeout(function(){deleteaccad(ident,x)},1000);
	}
}


function deleteuacc(ident,x){
	$('#preloader').fadeIn(500).css("background-color", "rgba(255, 255, 255, 0.84)");
	$('#status').fadeIn(500);
	
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					$('#preloader').fadeOut(50);
					$('#status').fadeOut(50);
					var data = xmlHttp.responseText.split("|");
					if(data[0] == 'done'){
						swal({
			            title: "Deleted Successful",
			            text: x+"'s account has been deleted successfully",
			            type: "success",
			            showCancelButton: false,
			            confirmButtonText: "Okay!"
					        }).then(function () {   
					        	location.reload();
				       	});
					}
					else{
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=deleteuacc&account="+ident);
	}
	else{
		setTimeout(function(){deleteuacc(ident,x)},1000);
	}
}


function adminedit(admin){
	$('#preloader').fadeIn(500).css("background-color", "rgba(255, 255, 255, 0.84)");
	$('#status').fadeIn(500);
	
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					$('#preloader').fadeOut(50);
					$('#status').fadeOut(50);
					var data = xmlHttp.responseText.split("|");
					if(data[0] == 'done'){
						document.getElementById('tinfobx').innerHTML = data[1];
						$(".overlay").fadeIn(200);
					}
					else{
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=editadmin&admin="+admin);
	}
	else{
		setTimeout(function(){adminedit(admin)},1000);
	}
}


function activateuacc(ident,x){
	$('#preloader').fadeIn(500).css("background-color", "rgba(255, 255, 255, 0.84)");
	$('#status').fadeIn(500);
	
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
			xmlHttp.open("POST", "app/actions.php", true);
			xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = function(){
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					$('#preloader').fadeOut(50);
					$('#status').fadeOut(50);
					var data = xmlHttp.responseText.split("|");
					if(data[0] == 'done'){
						swal({
			            title: "Activated Successful",
			            text: x+"'s account has been activated successfully",
			            type: "success",
			            showCancelButton: false,
			            confirmButtonText: "Okay!"
					        }).then(function () {   
					        	location.reload();
				       	});
					}
					else{
						swal("Error!", xmlHttp.responseText, "error");
					}
				}
			}
			xmlHttp.send("action=activateuacc&account="+ident);
	}
	else{
		setTimeout(function(){activateuacc(ident,x)},1000);
	}
}


function add(){
	$("#overlaytask").fadeIn(200);
}


function deleteuserad(ident,x){
	swal({
	  title: 'Are you sure?',
	  text: "This will delete "+x+"'s account",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  deleteuacc(ident,x);
	})
}


function activateuserad(ident,x){
	swal({
	  title: 'Are you sure?',
	  text: "This will activate "+x+"'s account",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  activateuacc(ident,x);
	})
}


function addeleteacc(ident, x){
	swal({
	  title: 'Are you sure?',
	  text: "This will delete "+ident+"'s account",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  deleteaccad(ident,x);
	})
}


function closetask(){
	$("#overlaytask").fadeOut(200);
}	


function closepop(){
	$("#overlayload").fadeOut(200).html('');
	$("#overlayrate").fadeOut(200);
}	


function loading(){
	$("#overlayload").html('<div class="d-flex ht-300 pos-relative align-items-center mg-t-100"><div class="sk-chasing-dots"><div class="sk-child sk-dot1 bg-gray-800"></div><div class="sk-child sk-dot2 bg-gray-800"></div></div></div>');
	$("#overlayload").fadeIn(200);
}


function edit_prof(){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				var data = xmlHttp.responseText.split("|");
				if(data[0] == 'done'){
					$('#overlayload').html('<form id="form" method="POST" action="" data-parsley-validate enctype="multipart/form-data"><div class="row" style="margin-top:50px;"><div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1"><div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div><div class="card bd-0 shadow-base"><div class="pd-x-25 pd-t-25"><h5 class="text-center">Professional Summary</h5><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Enter Professional Summary</label><textarea id="textarea" class="form-control" name="prof" maxlength="160" rows="4" placeholder="your professional summary goes here..." style="margin-top: 0px; margin-bottom: 0px; height: 123px;" required></textarea></div><hr><div id="taskx"></div><div class="form-group text-center"><button type="submit" name="profsubmit" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button></div></div></div></div></div></form>');
					$('textarea#textarea').maxlength({
            alwaysShow: true,
            warningClass: "badge badge-info",
            limitReachedClass: "badge badge-warning"
					});
					$('#form').parsley();
					$("#textarea").val(data[1]);
				}
				else{
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=editprof");
	}
	else{
		setTimeout(function(){edit_prof()},1000);
	}
}


function edit_work(){
	$('#overlayload').html('<form id="form" method="POST" action="" data-parsley-validate enctype="multipart/form-data"><div class="row" style="margin-top:50px;"><div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1"><div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div><div class="card bd-0 shadow-base"><div class="pd-x-25 pd-t-25"><h5 class="text-center">Work History</h5><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Job Title</label><input type="text" class="form-control" name="jobtitle" style="margin-top: 0px; margin-bottom: 0px;" required></div><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Employer</label><input type="text" class="form-control" name="employer" style="margin-top: 0px; margin-bottom: 0px;" required></div><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Country</label><input type="text" class="form-control" name="country" style="margin-top: 0px; margin-bottom: 0px;" required></div><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Duties</label><textarea id="textarea" class="form-control" name="duties" maxlength="160" rows="4" placeholder="the duties you performed under the job title goes here..." style="margin-top: 0px; margin-bottom: 0px; height: 123px;" required></textarea></div><div class="row"><div class="col-md-6"><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1">Start Month/Year</label><div class="row row-xs"><div class="col-sm-8 mg-t-20 mg-sm-t-0"><select class="form-control select2" name="smonth" required><option label="*-Month-*"></option>   <option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>                          </select></div><div class="col-sm-4"><input type="text" class="form-control" name="syear" data-parsley-type="digits" data-parsley-length="[4, 4]" maxlength="4" placeholder="Year" required></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1">End Month/Year</label><div class="row row-xs">                        <div class="col-sm-8 mg-t-20 mg-sm-t-0"><select class="form-control select2 endedx" name="emonth"><option label="*-Month-*"></option>     <option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select></div><div class="col-sm-4"><input type="text" class="form-control endedx" name="eyear" data-parsley-type="digits" data-parsley-length="[4, 4]" maxlength="4" placeholder="Year"></div><p class="pull-right mg-10"><label class="ckbox"><input type="checkbox" name="current" onchange="currentcheck()" id="currentw"><span>Currently there</span></label></p></div></div></div></div>              <hr><div class="form-group text-center"><button type="submit" name="worksubmit" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button></div></div></div></div></div></form>');					
	$('textarea#textarea').maxlength({
		alwaysShow: true,
		warningClass: "badge badge-info",
		limitReachedClass: "badge badge-warning"
	});
	$('#form').parsley();
	$('#overlayload').fadeIn(500);
}


function edit_education(){
	$('#overlayload').html('<form id="form" method="POST" action="" data-parsley-validate enctype="multipart/form-data"><div class="row" style="margin-top:50px;"><div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1"><div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div><div class="card bd-0 shadow-base"><div class="pd-x-25 pd-t-25"><h5 class="text-center">Education Information</h5><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">School Name</label><input type="text" class="form-control" name="sname" style="margin-top: 0px; margin-bottom: 0px;" required></div><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">School Location</label><input type="text" class="form-control" name="sloc" style="margin-top: 0px; margin-bottom: 0px;" required></div><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Degree</label><select class="form-control select2" name="degree" data-placeholder="Select your Degree" required><option label="Select your Degree"></option><option value="High School Diploma">High School Diploma</option><option value="GED">GED</option><option value="Associate of Arts">Associate of Arts</option><option value="Associate of Science">Associate of Science</option><option value="Associate of Applied Science">Associate of Applied Science</option><option value="Bachelor of Arts">Bachelor of Arts</option><option value="Bachelor of Science">Bachelor of Science</option><option value="BBA">BBA</option><option value="Master of Arts">Master of Arts</option><option value="Master of Science">Master of Science</option><option value="MBA">MBA</option><option value="J.D.">J.D.</option><option value="M.D.">M.D.</option><option value="Ph.D.">Ph.D.</option></select></div><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Field of Study</label><input type="text" class="form-control" name="field" style="margin-top: 0px; margin-bottom: 0px;" required></div><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Year of Completion</label><input type="text" class="form-control endedx" name="cyear" data-parsley-type="digits" data-parsley-length="[4, 4]" maxlength="4" placeholder="Year" required></div><hr><div class="form-group text-center"><button type="submit" name="edusubmit" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button></div></div></div></div></div></form>');
	$('#form').parsley();
	$('#overlayload').fadeIn(500);
}


function edit_skills(){
	$('#overlayload').html('<form id="form" method="POST" action="" data-parsley-validate enctype="multipart/form-data"><div class="row" style="margin-top:50px;"><div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1"><div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div><div class="card bd-0 shadow-base"><div class="pd-x-25 pd-t-25"><h5 class="text-center">My Skills</h5><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Skill</label><input type="text" class="form-control" name="skill" style="margin-top: 0px; margin-bottom: 0px;" required></div><hr><div class="form-group text-center"><button type="submit" name="skillsubmit" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button></div></div></div></div></div></form>');
	$('#form').parsley();
	$('#overlayload').fadeIn(500);
}


function edit_comms(){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				var data = xmlHttp.responseText.split("|");
				if(data[0] == 'done'){
					$('#overlayload').html('<form id="form" method="POST" action="" data-parsley-validate enctype="multipart/form-data"><div class="row" style="margin-top:50px;"><div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1"><div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div><div class="card bd-0 shadow-base"><div class="pd-x-25 pd-t-25"><h5 class="text-center">Community Service</h5><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Enter Community Service</label><textarea id="textarea" class="form-control" name="comms" maxlength="160" rows="4" placeholder="your community service goes here..." style="margin-top: 0px; margin-bottom: 0px; height: 123px;" required></textarea></div><hr><div id="taskx"></div><div class="form-group text-center"><button type="submit" name="commsubmit" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button></div></div></div></div></div></form>');
					$('textarea#textarea').maxlength({
            alwaysShow: true,
            warningClass: "badge badge-info",
            limitReachedClass: "badge badge-warning"
					});
					$('#form').parsley();
					$("#textarea").val(data[1]);
				}
				else{
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=editcomms");
	}
	else{
		setTimeout(function(){edit_comms()},1000);
	}
}



function edit_hobby(){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				var data = xmlHttp.responseText.split("|");
				if(data[0] == 'done'){
					$('#overlayload').html('<form id="form" method="POST" action="" data-parsley-validate enctype="multipart/form-data"><div class="row" style="margin-top:50px;"><div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1"><div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div><div class="card bd-0 shadow-base"><div class="pd-x-25 pd-t-25"><h5 class="text-center">Hobbies and Interests</h5><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Enter Hobbies and Interests</label><textarea id="textarea" class="form-control" name="hobby" maxlength="160" rows="4" placeholder="your hobbies and interests goes here..." style="margin-top: 0px; margin-bottom: 0px; height: 123px;" required></textarea></div><hr><div id="taskx"></div><div class="form-group text-center"><button type="submit" name="hobsubmit" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button></div></div></div></div></div></form>');
					$('textarea#textarea').maxlength({
            alwaysShow: true,
            warningClass: "badge badge-info",
            limitReachedClass: "badge badge-warning"
					});
					$('#form').parsley();
					$("#textarea").val(data[1]);
				}
				else{
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=edithobby");
	}
	else{
		setTimeout(function(){edit_hobby()},1000);
	}
}


function delinfo(type, tag){
	swal({
	  title: 'Are you sure?',
	  text: "This infomation will be delete from your CV",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  delcvinfo(type,tag);
	})
}


function delcvinfo(type,tag){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				closepop();
				if(xmlHttp.responseText == 'done'){
					swal("CV Updated", "Your CV has been updated successfully", "success");
					$('#'+type+'_'+tag).fadeOut(200).remove();
				}
				else{
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=delcvinfo&type="+type+"&tag="+tag);
	}
	else{
		setTimeout(function(){delcvinfo(type,tag)},1000);
	}
}


function edit_info(){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				$('#overlayload').html(xmlHttp.responseText);					
				$('#form').parsley();
			}
		}
		xmlHttp.send("action=editinfo");
	}
	else{
		setTimeout(function(){edit_info()},1000);
	}
}

var t;
var state = 'p';

function process_transaction(){
	$('#overlayload').fadeIn(200);
	$("#pay").fadeOut(20).prop('disabled', true);
	var ptype = document.getElementById('ptype').value;
  var wallet = document.getElementById('wallet').value;
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				var data = xmlHttp.responseText.split("|");
				if(data[0] == 'done'){
					var invoice = data[1];
					t = setInterval(function(){ state = check_invoice(invoice); }, 5000);									
				}else{
					$('#overlayload').fadeOut(200);
					$("#pay").fadeIn(20).prop('disabled', false);
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=payment&ptype="+ptype+"&wallet="+wallet);
	}
	else{
		setTimeout(function(){process_transaction()},1000);
	}
}

function check_invoice(invoice){
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				state = xmlHttp.responseText;
				if(state == 's'){
					clearInterval(t);
					swal({
						title: "Transaction Successful!",
						text: "Your subscription payment was successful",
						type: "success",
						showCancelButton: false,
						confirmButtonText: "Okay"
					}).then(function () {
						window.location.href = "dashboard";
					});
				}else if(state == 'f'){
					clearInterval(t);
					$('#overlayload').fadeOut(200);
					$("#pay").fadeIn(20).prop('disabled', false);
					swal("Error!", "Transaction failed", "error");
				}else if(state != 'p'){
					clearInterval(t);
					$('#overlayload').fadeOut(200);
					$("#pay").fadeIn(20).prop('disabled', false);
					swal("Error!", state, "error");
				}
			}
		}
		xmlHttp.send("action=checkpayment&invoice="+invoice);
	}
	else{
		setTimeout(function(){check_invoice(invoice)},1000);
	}
}


function addInternship(){
	$('#overlaytask').fadeIn(200);
	$( ".datepicker" ).datepicker();
}


function viewapplicant(applicant){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				var data = xmlHttp.responseText.split("|");
				if(data[0] == 'done'){
					$('#overlayload').html(data[1]);
				}
				else{
					closepop();
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
			
		}
		xmlHttp.send("action=viewapplicant&student="+applicant);
	}
	else{
		setTimeout(function(){viewapplicant(applicant)},1000);
	}
}


function acceptapplicant(applicant){
	swal({
	  title: 'Are you sure?',
	  text: "You are about to accept this applicant for an internship with your company",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  acceptstudent(applicant);
	})

}


function delstudent(student){
	swal({
	  title: 'Are you sure?',
	  text: "You are about to delete this student, along with all their solutions",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  deletestudent(student);
	})
}


function deletestudent(student){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				closepop();
				if(xmlHttp.responseText == 'done'){
					swal({
						title: "Deleted",
						text: "Student has been deleted successfully",
						type: "success",
						showCancelButton: false,
						confirmButtonText: "Okay"
					}).then(function () {
						location.reload();
					});
				}
				else{
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=delete_student&student="+student);
	}
	else{
		setTimeout(function(){deletestudent(student)},1000);
	}
}



function delcomp(company){
	swal({
	  title: 'Are you sure?',
	  text: "You are about to delete this company, along with all their tasks and solutions",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  deletecomp(company);
	})

}



function deletecomp(company){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				closepop();
				if(xmlHttp.responseText == 'done'){
					swal({
						title: "Deleted",
						text: "Company has been deleted successfully",
						type: "success",
						showCancelButton: false,
						confirmButtonText: "Okay"
					}).then(function () {
						location.reload();
					});
				}
				else{
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=delete_company&company="+company);
	}
	else{
		setTimeout(function(){deletecomp(company)},1000);
	}
}



function acceptstudent(applicant){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				closepop();
				if(xmlHttp.responseText == 'done'){
					swal({
						title: "Accepted",
						text: "Applicant accepted successfully",
						type: "success",
						showCancelButton: false,
						confirmButtonText: "Okay"
					}).then(function () {
						location.reload();
					});
				}
				else{
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=acceptstudent&applicant="+applicant);
	}
	else{
		setTimeout(function(){acceptstudent(applicant)},1000);
	}
}


function checkInternship(){
	$("#overlayrate").html('<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 mg-t-100"><div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div><div class="card bd-0 shadow-base"><div class="pd-x-25 pd-t-25" id="moreinfobx"><h5 class="text-center">Check Internship Acceptance Code</h5><div class="form-group"><label class="d-block tx-11 tx-medium tx-spacing-1 text-center">Code</label><input type="text" class="form-control text-center" id="code" style="margin-top: 0px; margin-bottom: 0px;"></div><hr><div class="form-group text-center"><button class="btn btn-success mg-b-10" onclick="check_applicant_code()" style="width: 40%;">Check</button></div></div></div></div>');
	$("#overlayrate").fadeIn(200);
}


function check_applicant_code(){
	var code = document.getElementById('code').value;
	if(code == ''){
		$('#overlayload').fadeOut(50);
		swal("Error!", "Internship Acceptance code required", "error");
		return;
	}
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		$("#overlayrate").html('<div class="d-flex ht-300 pos-relative align-items-center mg-t-100"><div class="sk-chasing-dots"><div class="sk-child sk-dot1 bg-gray-800"></div><div class="sk-child sk-dot2 bg-gray-800"></div></div></div>');
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				var data = xmlHttp.responseText.split("|");
				if(data[0] == 'done'){
					$('#overlayrate').html('<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 mg-t-100"><div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div><div class="card bd-0 shadow-base"><div class="pd-x-25 pd-t-25">'+data[1]+'</div></div></div>');
				}
				else{
					closepop();
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
			
		}
		xmlHttp.send("action=check_applicant_code&code="+code);
	}
	else{
		setTimeout(function(){check_applicant_code()},1000);
	}
}


function applytointern(internship){
	swal({
	  title: 'Are you sure?',
	  text: "You are about to apply for an internship with this company",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then(function () {
	  applyintern(internship);
	})
}


function applyintern(internship){
	loading();
	if(xmlHttp.readyState == 0 || xmlHttp.readyState == 4){
		xmlHttp.open("POST", "app/actions.php", true);
		xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200){
				closepop();
				if(xmlHttp.responseText == 'done'){
					swal({
						title: "Accepted",
						text: "Applicant accepted successfully",
						type: "success",
						showCancelButton: false,
						confirmButtonText: "Okay"
					}).then(function () {
						location.reload();
					});
				}
				else{
					swal("Error!", xmlHttp.responseText, "error");
				}
			}
		}
		xmlHttp.send("action=applytointern&internship="+internship);
	}
	else{
		setTimeout(function(){applyintern(internship)},1000);
	}
}