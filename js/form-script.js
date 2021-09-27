(function($){
    $( document ).ready(function(){
        $("#my_submit").on("click", function (event) {
            //event.preventDefault();
            var url = '<?php echo home_url(); ?>';
            var fd = new FormData();
            var file = $(document).find('input[type="file"]');
            var caption = $(this).find('input[name=image]');
            
            var individual_file = file[0].files[0];

            fd.append("file", individual_file);
            var individual_capt = caption.val();
            fd.append("caption", individual_capt);  

            var title = $(document).find('#title');
            var individual_title = title.val();
            fd.append("title", individual_title);

            var price = $(document).find('#price');
            var individual_price = price.val();
            fd.append("price", individual_price);

            var name = $(document).find('#name');
            var individual_name = name.val();
            fd.append("name", individual_name);

            var email = $(document).find('#email');
            var individual_email = email.val();
            fd.append("email", individual_email);

            var textarea = $(document).find('#textarea');
            var individual_textarea = textarea.val();
            fd.append("textarea", individual_textarea);

            fd.append('action', 'ajax_form');
    
        
            $.ajax({
                url: "/wp-admin/admin-ajax.php",
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loader').html("<p>" + form_script_vars.loading_img_message + "</p>");

                },
                complete: function() {
                    $('#loader').html('');

                },
                success: function (response) {
                
                    $('#submit-ajax').html('hghgh');

                }, 
            });  
           

        });
    });
})(jQuery);

