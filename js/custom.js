$(function() {
    $('#upload_file').submit(function(e) {

        e.preventDefault();
        $.ajaxFileUpload({
            url             :base_url + './Upload/upload_file/', 
            secureuri       :false,
            fileElementId   :'userfile',
            dataType: 'JSON',
            success : function (data)
            {
               var obj = jQuery.parseJSON(data);                
                if(obj['status'] == 'success')
                {
                    alert('sukses');
                    $('#files').html(obj['msg']);
                 }
                else
                 {
                    alert('gagal');
                    $('#files').html('Some failure message');
                  }
            }
        });
        return false;
    });
});