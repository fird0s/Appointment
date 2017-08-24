<!DOCTYPE html>
<html>
<head>
	<title>Dashboard Appointment</title>
	<meta charset='utf-8' />
	<link rel="stylesheet" href="<?php echo base_url()?>static/node_modules/fullcalendar/dist/fullcalendar.min.css"  type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()?>static/node_modules/fullcalendar/dist/fullcalendar.print.min.css"  type="text/css" media="print">
	<link rel="stylesheet" href="<?php echo base_url()?>static/css/bootstrap.min.css"  type="text/css">
	<script type="text/javascript" src="<?php echo base_url()?>static/node_modules/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>static/node_modules/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>static/node_modules/fullcalendar/dist/fullcalendar.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>static/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>static/js/custom.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			dayClick: function(date, jsEvent, view) {
				$("#myModal").modal()
		        $('#ModalDate').val(date.format('YYYY-MM-DD HH:mm:ss'));

		        // add appointment 
		        jQuery('#save').click(function () {
			    	$.ajax({
			    		type : 'POST',
			    		data : {'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>', appointment: $('#ModalAppointment').val(), date_appointment: $('#ModalDate').val()},
			    		url : "dashboard/add/",
			    		beforeSend: function( xhr ) {
			    			var newEvent = {
				                title: $('#ModalAppointment').val(),
				                start: date.format('YYYY-MM-DD HH:mm:ss')
				            }
			    			$('#calendar').fullCalendar('renderEvent', newEvent);
			    		},
			    		success: function(result){
			    			$('#myModal').modal('toggle'); // hide modal after success insert data 
			    			$("#ModalAppointment").val(''); // clear form
			    			
			    		}
			    	})
			    });

			},
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaDay,listWeek'
			},
			eventClick: function(calEvent, jsEvent, view) {
				$('#modalUpdate').modal();
				$('#ModalAppointmentUpdate').val(calEvent.title)
				$('#ModalDateUpdate').val($.fullCalendar.formatDate(calEvent._start, 'YYYY-MM-DD HH:mm:ss'))

			    // update appointment
			    jQuery('#ModalUpdate').click(function () {
			    	$.ajax({ // ajax for delete appointment
			    		type : 'POST',
			    		data : {'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>', id: calEvent.id, title: $('#ModalAppointmentUpdate').val(), date: $('#ModalDateUpdate').val() },
			    		url : "dashboard/ajaxupdate/",
			    		beforeSend: function( xhr ) {
			    			// before change from server, first change on browser
	        				calEvent.title = $('#ModalAppointmentUpdate').val();
	        				calEvent.start = $('#ModalDateUpdate').val();
						    $('#calendar').fullCalendar('updateEvent', calEvent);
	  					},
			    		success: function(result){ // return from PHP server
			    		}
			    	})
			    });

			    // delete appointment
			    $remove_appoinment = $(this).css('display', '');
				jQuery('#ModalDelete').click(function () {
					$remove_appoinment.css('display', 'none'); 
					$.ajax({ // ajax for delete appointment
			    		type : 'POST',
			    		data : {'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>', id: calEvent.id},
			    		url : "dashboard/ajaxdelete/",
			    		success: function(result){ // return from PHP server
			    		}
			    	})
				});
	    	},
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: 'dashboard/ajaxevent' // get event list from JSON format
		});
	});
	</script>
	<style>
		body{margin:40px 10px;padding:0;font-family:"Lucida Grande",Helvetica,Arial,Verdana,sans-serif;font-size:14px}#calendar{max-width:900px;margin:0 auto}
	</style>
</head>
<body>

	<div class="container">
		<h1 style="text-align: center;">Dashboard</h1><hr>
		<div id='calendar'></div>
	</div>

	<!-- Pop up handler for create appointment -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Add Appointment</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
		        <input type="text" class="form-control" id="ModalAppointment" placeholder="Appointment">
		    </div>
		    <div class="form-group">    
		        <input type="text" class="form-control" id="ModalDate" value="">
		    </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" id="save">Save</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Pop up handler for update/delete appointment-->
	<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Update/Delete Appointment</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
		        <input type="text" class="form-control" id="ModalAppointmentUpdate" placeholder="Appointment">
		    </div>
		    <div class="form-group">    
		        <input type="text" class="form-control" id="ModalDateUpdate" value="">
		    </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" id="ModalDelete" data-dismiss="modal">Delete</button>
	        <button type="button" class="btn btn-primary" id="ModalUpdate" data-dismiss="modal">Update</button>
	      </div>
	    </div>
	  </div>
	</div>


</body>
</html>
