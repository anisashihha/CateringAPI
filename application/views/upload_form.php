<html>
 
   <head> 
      <title>Upload Form</title> 
   </head>
	
   <body> 
      <?php echo $error;?> 
      <?php //echo form_open_multipart('upload/do_upload');
            echo form_open_multipart('api/user/');?> 
         <input type = "file" name = "avatar" size = "20" /> 
         <br /><br /> 
         <input type = "submit" name="action" value = "upload" /> 
      </form> 
		
   </body>
	
</html>