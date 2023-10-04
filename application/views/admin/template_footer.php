<!-- BEGIN FOOTER -->

<div class="footer">
	<div class="footer-inner">
			&copy; <?=$this->config->item('title_name')?>
	</div>
	<div class="footer-tools">
		<span class="go-top">
			<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
   <script src="<?=base_url()?>assets/plugins/respond.min.js"></script>
   <script src="<?=base_url()?>assets/plugins/excanvas.min.js"></script> 
   <![endif]-->
<script src="<?=base_url()?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="<?=base_url()?>assets/plugins/tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<!--<script src="<?=base_url()?>assets/metronic/plugins/datetimepicker/jquery.datetimepicker.full.min.js"></script>-->

<script type="text/javascript" src="<?=base_url()?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="<?=base_url()?>assets/plugins/summernote/dist/summernote.js"></script>
<script src="<?=base_url()?>assets/plugins/dropzone/dropzone.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>

<script type="text/javascript" src="<?=base_url()?>assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/data-tables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/data-tables/DT_bootstrap.js"></script>

<!--<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>-->

<script src="<?=base_url()?>assets/scripts/app.js"></script>
<script src="<?=base_url()?>assets/scripts/table-advanced.js?v=2"></script>
<script>
      jQuery(document).ready(function() {    
        App.init();
		TableAdvanced.init();
		 
		var preview = $("#upload-preview");  
		var container= $("div.containerz");
		
		//$(".snapshot_datetime").datepicker();

		$("#shop_img").change(function(event){
				var input = $(event.currentTarget);
				var file = input[0].files[0];
				var reader = new FileReader();
				reader.onload = function(e){
				   image_base64 = e.target.result;
				   preview.html("<img src='"+image_base64+"' style='width:200px;height:200px;padding: 2px;border: 1px solid #D0D0D0;'/><br/>");
				};
			reader.readAsDataURL(file);
		});
		
		$("#form_profile").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			rules: {
				n_password : {
                    minlength : 6
                },
                c_password : {
                    minlength : 6,
                    equalTo : "#n_password"
                }
			},
			messages: {
				n_password : {
                    minlength : 'กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัว'
                },
                c_password : {
                    minlength : 'กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัว',
                    equalTo : "ยืนยันรหัสผ่านไม่ถูกต้อง"
                }
			},
			submitHandler: function( form ) { form.submit(); }
		});
		$(".msgalert").fadeOut(3000);
	
		$("#web_info").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			submitHandler: function(form) {
						
				myDropzone.processQueue();

				setTimeout(function(){
					//if($("#h_image").val()){
						form.submit();
				//}
				},1000)
						
			}
		});
		
		$("#frm_slide").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			submitHandler: function(form) {
						
				myDropzone.processQueue();

				setTimeout(function(){
					//if($("#h_image").val()){
						form.submit();
				//}
				},1000)
						
			}
		});
		

		$('.summernote').summernote({
			height: 300,
			focus: true,
			callbacks: {
				onImageUpload : function(files, editor, welEditable) {
					for(var i = files.length - 1; i >= 0; i--) {
						sendFile(files[i], this);
					}
				}
			} 
		});


        function sendFile(file, el) {
            var form_data = new FormData();
            form_data.append('file', file);
            $.ajax({
                data: form_data,
                type: "POST",
                url: "<?=base_url()?>assets/plugins/summernote/save.php",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    $(el).summernote('editor.insertImage', url);
                }
            });
        }
		

		/*---------------------------------------------------------------*/
		Dropzone.autoDiscover = false;
        
		if ($('#dropzone').length) {
			var myDropzone = new Dropzone("#dropzone",{
				url: "<?=base_url()?>assets/plugins/dropzone/upload.php",
				maxFiles: 1,
				autoProcessQueue: false,
				addRemoveLinks: true,
				init: function() {
					this.on("maxfilesexceeded", function(file){
							this.removeAllFiles();
							this.addFile(file);
						});
					},
					success: function(file, response){
						$("#h_image").val(response);
					}
					
			});
		}
		
		/* DROPZONE */
			
		$('#remove_image_cover').on("click",function(){
			$('#dropzone').show();
			$('#image_cover_show').hide();
		});
			
		$("#frm_content_validate").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			rules: {
				'content_file[]': {
					required: true,
					extension: "pdf"
				}
			},
			messages: {
				'content_file[]': {
				  required: 'กรุณาเลือกไฟล์เอกสาร',
				  extension: "ไฟล์เอกสารต้องเป็นไฟล์นามสกุล .pdf เท่านั้น"
				}
			},
			submitHandler: function(form) {
						
				myDropzone.processQueue();
				setTimeout(function(){
					//if($("#h_image").val()){
						form.submit();
					//}
				},3000)
						
			}
		});


		$("#frm_content").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			submitHandler: function(form) {
						
				myDropzone.processQueue();

				setTimeout(function(){
					//if($("#h_image").val()){
						form.submit();
				//}
				},1000)
						
			}
		});
		
		$("#frm_recom").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			submitHandler: function(form) {
						
				myDropzone.processQueue();
				
				setTimeout(function(){
					//if($("#h_image").val()){
						form.submit();
				//}
				},1000)
						
			}
		});
		
		$("#frm_place").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			rules: {
				place_username: {
					remote: {
						type: "POST",
						url: "<?=base_url()?>assets/plugins/php/ajax.chk_email.php",
						data: {
							place_username: function() {
								return $("#place_username").val();
							}
						}
					}
				}
			},
			messages: {
				place_username :{
					remote:'ผู้ใช้ใช้ซ้ำ'
				}
			},
			submitHandler: function(form) {
				
				myDropzone.processQueue();
				
				setTimeout(function(){
						form.submit();
				},1000)				
			}
		});
		
		$("#frm_place_edit").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			submitHandler: function(form) {
				
				myDropzone.processQueue();
				
				setTimeout(function(){
						form.submit();
				},1000)				
			}
		});
		
		function getAlertNewInbox(){
			$.ajax({
                type: "GET",
                url: "<?=base_url()?>assets/plugins/php/getNewAlert.php?type=ib",
                dataType: "html",
                success: function(msg) {
                    $('.alertInbox').html(msg);
                }
            });
			
			$.ajax({
                type: "GET",
                url: "<?=base_url()?>assets/plugins/php/getNewAlert.php?type=ibl",
                dataType: "html",
                success: function(msg) {
                    $('#inboxList').html(msg);
                }
            });
			
			
		}
		
		setInterval(function(){ 
			getAlertNewInbox();		
		}, 20000);
		
		
		var countf=0;
		$(document).on('click','#btnAddFile', function(e) {
			countf++;
			$.ajax({
				url: '<?=base_url()?>assets/plugins/php/getAddFile.php?count='+countf,
				success: function(data) {
					$("#fList").after(data);
				}
			});	
		});
		$(document).on("click", "#btn-delListFile", function(e) {
			$(this).parent().parent().parent().eq(0).remove();
		}); 
		
		//add
		$('.loadajax').on("click",function(){
			var type =  $(this).attr("datatype");
			var filter =  $(this).attr("datavalue");
			
			$.ajax({
                type: "GET",
                url: "<?=base_url()?>assets/plugins/php/getMemberFilter.php?type="+type+"&filter="+filter,
                dataType: "html",
                success: function(msg) {
                    $('#memberLoad').html(msg);
                }
            });
		});
		
		$('.loadajax2').on("click",function(){
			var type =  $(this).attr("datatype");
			var filter =  $(this).attr("datavalue");
			
			$.ajax({
                type: "GET",
                url: "<?=base_url()?>assets/plugins/php/getMemberFilter2.php?type="+type+"&filter="+filter,
                dataType: "html",
                success: function(msg) {
                    $('#memberLoad').html(msg);
                }
            });
		});
		
		$(document).on("change", "#intro_type", function(e) {
			var stype=$(this).val();
			if(stype==1){
				$('#tcontent').hide();
				$('#timage').show();
			}else if(stype==2){
				$('#tcontent').show();
				$('#timage').hide();
			}else{
				$('#tcontent').hide();
				$('#timage').hide();
			}
		}); 
		
		var count=0;
	
		if($('#countOptions').val()){
			count= $('#countOptions').val();
		}
		$(document).on('click','#btnAddOption', function(e) {
			count++;
			$.ajax({
				url: '<?=base_url()?>/assets/plugins/php/getQuestionOption.php?count='+count,
				success: function(data) {
					$("#fList").after(data);
				}
			});	
		});
		$(document).on("click", "#btnDelOption", function(e) {
			$(this).parent().parent().parent().eq(0).remove();
		}); 
		
		$(".form_datetime").datetimepicker({
			format: "yyyy-mm-dd hh:ii:ss"
		});

		$(".member_status_on").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.update_member_status.php",
				data: "id=" + id + "&is_show=1",
				success: function(msg) {
					$("#member_status2\\[" + id + "\\]").html(msg);
				}
			});
			return false;
		});
			
		$(".member_status_off").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.update_member_status.php",
				data: "id=" + id + "&is_show=-1",
				success: function(msg) {
					$("#member_status2\\[" + id + "\\]").html(msg);
				}
			});
			return false;
		});
		
		$(".member_status_od_on").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.update_member_status2.php",
				data: "id=" + id + "&is_show=1",
				success: function(msg) {
					$("#member_status3\\[" + id + "\\]").html(msg);
				}
			});
			return false;
		});
			
		$(".member_status_od_off").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.update_member_status2.php",
				data: "id=" + id + "&is_show=-1",
				success: function(msg) {
					$("#member_status3\\[" + id + "\\]").html(msg);
				}
			});
			return false;
		});
		
		$(".topic_status_on").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.update_topic.php",
				data: "id=" + id + "&is_show=1",
				success: function(msg) {
					$("#topic_status\\[" + id + "\\]").html(msg);
				}
			});
			return false;
		});
			
		$(".topic_status_off").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.update_topic.php",
				data: "id=" + id + "&is_show=0",
				success: function(msg) {
					$("#topic_status\\[" + id + "\\]").html(msg);
				}
			});
			return false;
		});

		$(document).on('click','.report', function(e) {    
            var post_id = $(this).attr("comment");
			var comment = confirm ("คุณต้องการที่จะแจ้งลบคอมเม้นนี้ ?");
            if(comment){
				$.post( "<?php echo base_url();?>admin/forum_topic/del", { post_id:post_id } ).done(function( data ) {
                    if(data!=""){
                        console.log(data);
                        alert('ระบบได้ทำการลบความเห็นแล้ว');
						$('#comment_'+post_id).remove();	
                    }
                });
				
			}
        });

		var hash = window.location.hash;
		if(hash){
			$(hash).css('background-color','#f3b7b7');
			$(hash).css('padding','10px');

		}
		
		$("#frm_page_validate").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			rules: {
				page_rewrite: {
					remote: {
						type: "POST",
						url: "<?=base_url()?>assets/plugins/php/ajax.chk_pageURL.php",
						data: {
							page_rewrite: function() {
								return $("#page_rewrite").val();
							}
						}
					}
				},
				'content_file[]': {
					required: true,
					extension: "pdf"
				}
				
			},
			messages: {
				page_rewrite :{
					remote:'ยูอาร์แอลของหน้าซ้ำ'
				},
				'content_file[]': {
				  required: 'กรุณาเลือกไฟล์เอกสาร',
				  extension: "ไฟล์เอกสารต้องเป็นไฟล์นามสกุล .pdf เท่านั้น"
				}
				
			},
			submitHandler: function(form) {
						
				myDropzone.processQueue();
				setTimeout(function(){
					form.submit();
				},1000)
						
			}
		});
		
		$("#form_document").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			rules: {

				doc_path: {
				  required: true,
				  extension: "pdf"
				}
				
			},
			messages: {

				doc_path: {
				  required: 'กรุณาเลือกไฟล์เอกสาร',
				  extension: "ไฟล์เอกสารต้องเป็นไฟล์นามสกุล .pdf เท่านั้น"
				}
				
			},
			submitHandler: function( form ) { 
			console.lod('submit');
				form.submit(); 
			}
		});
		
		$('#file_edit').on("click",function(){
			$('#file_open').show();
			$('#file_open_btn').show();
			$('#file_tools').hide();
		});
		
		$(".btn_update_member_status_on").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$("#member_status\\[" + id + "\\]").html('<i class="fa fa-spinner"></i> loading..');
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.updateMemberVerifyStatus.php",
				data: "id=" + id + "&member_verify_status=1",
				success: function(msg) {
					$("#member_status\\[" + id + "\\]").html(msg);
				}
			});
			return false;
			
		});
		$(".btn_update_member_status_off").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$("#member_status\\[" + id + "\\]").html('<i class="fa fa-spinner"></i> loading..');
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.updateMemberVerifyStatus.php",
				data: "id=" + id + "&member_verify_status=-1",
				success: function(msg) {
					$("#member_status\\[" + id + "\\]").html(msg);
				}
			});
			return false;
			
		});
		
		$(".btn_update_blog_status_on").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$("#blog_status\\[" + id + "\\]").html('<i class="fa fa-spinner"></i> loading..');
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.updateBlogStatus.php",
				data: "id=" + id + "&blog_status=1",
				success: function(msg) {
					$("#blog_status\\[" + id + "\\]").html(msg);
				}
			});
			return false;
			
		});
		$(".btn_update_blog_status_off").live("click", function() {
			var id = $(this).attr("href").substring(1);
			$("#blog_status\\[" + id + "\\]").html('<i class="fa fa-spinner"></i> loading..');
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>assets/plugins/php/ajax.updateBlogStatus.php",
				data: "id=" + id + "&blog_status=-1",
				success: function(msg) {
					$("#blog_status\\[" + id + "\\]").html(msg);
				}
			});
			return false;
			
		});
		
		$( "#yt_id" ).keyup(function() {
			var vdoid = $( "#yt_id" ).val();
			var feedurl = '';
			$('#imageloadstatus').show();
			if(vdoid.length >5){
				var feedurl = 'https://www.googleapis.com/youtube/v3/videos?part=id%2C+snippet&id='+vdoid+'&key=AIzaSyBzCp7dmgHIjxtFquX4nNUhJoZ2Uc9-JSI';
				console.log(feedurl);
				$.ajax({
					url: feedurl,
					dataType: "jsonp",
					success: function(data) {
						if(data.pageInfo.totalResults===1){
							/*
							var tmp_tags='';
							if(data.items[0].snippet.tags){
								jQuery.each(data.items[0].snippet.tags, function(index, item) {
									if(index===0){
										tmp_tags =item;
									}else{
										tmp_tags +=','+item;
									}
								});
							}*/
							var t_url='';
							var tmp = data.items[0].snippet.thumbnails.high.url.substr(0,5);
							//console.log(tmp);
							if(tmp=='https')
							{
								t_url=data.items[0].snippet.thumbnails.high.url;
							}else{
								t_url=data.items[0].snippet.thumbnails.standard.url;
							}
							
							$("#yt_name").val(data.items[0].snippet.title);
							$("#yt_detail").html(data.items[0].snippet.description);
							$("#img_preview").html('<img src="'+t_url+'" width="150"/><br/>');
							$("#yt_thumbnail").val(t_url);
							
							
							$("#yt_name").attr("readonly", false);
							$("#yt_detail").attr("readonly", false);
							$('#imageloadstatus').hide();
							$('#btn_submit').prop('disabled', false);
						}else{
							
						}
					}
				});
			}
		});
		
		/*
		function getSnapshot(source, action){
			var tmp='';
			$.getJSON("http://livebox.me/dustdetect/capture/json_capture.php?action="+action+"&callback=?", function(result){
				tmp += '<div class="row">';
				if(result.path){
					$.each(result.path, function (key,value) {
						tmp +='<div class="col-sm-4" style="margin-bottom:15px;position: relative;">';
						tmp +='<span style="position: absolute;background-color: #9dc02d;padding: 2px;color: #fff;">'+value.substr(28,4).substr(0,2)+':'+value.substr(28,4).substr(2,2)+'</span>';
						tmp +='<img src="http://livebox.me/dustdetect/capture/'+value+'" class="img-responsive img-thumbnail"/><label><input type="radio" name="fb" value="'+value+'" /> '+value+'</label></div>';
					});
				}else{
					tmp +='<div class="col-md-12"><p class="text-center"> ไม่พบข้อมูล </p></div>';
				}
				tmp += '</div>';
				$('#snap_display').html(tmp);
			});
		}
		
		
		$('#btn_query2').on( "click", function() {
			getSnapshot(1, $('#dateStart').val());
		});
		*/
		
    });
   </script>
</body>
<!-- END BODY -->
</html>