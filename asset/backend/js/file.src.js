var file = {
    upload: function(base_url, tables){
        var o_cates = new Object();
        var a_categories = JSON.parse(tables);
        //alert(base_url + 'asset/public/lib/plupload/js/plupload.flash.swf');
        var uploader = $("#uploader").pluploadQueue({
            runtimes : 'flash',
            url : base_url + 'administrator/file/upload',
            max_file_size : '10mb',
            //chunk_size : '1mb',
            unique_names : true,
            multipart: true,
            filters : [
                {title : "Image files", extensions : "jpg,gif,png"},
                {title : "Zip files", extensions : "zip"},
                {title : "Rar files", extensions : "rar"},
                {title : "Text files", extensions : "doc,docx,txt,pdf"},
                {title : "Video files", extensions : "flv,wmv"}
            ],

            // Resize images on clientside if we can
            resize : {width : 320, height : 240, quality : 90},

            // Flash settings
            flash_swf_url : base_url + 'asset/public/lib/plupload/js/plupload.flash.swf',
            init: {
                BeforeUpload: function(up, file){
                    up.settings.multipart_params = {cates: o_cates[file.id]};
                },
                FileUploaded: function(up, file, response){
                    console.log(response);
                }
            }
        });
        $(".plupload_start").livequery(function(){
            //alert($(".plupload_start").length);
        });
        $(".plupload_delete").livequery(function(){
            if($(this).children(".category").length === 0){                
                var options = '';
                var id = $(this).attr('id');
                //alert((o_cates[name] == a_categories[i]) ? selected : null);
                $(a_categories).each(function(i){
                    if(o_cates[id] == a_categories[i]){
                        selected = "selected='selected'";
                    }else{
                        selected = '';
                    }
                    options += "<option value='" + a_categories[i] + "' " + selected + ">" + a_categories[i] + "</option>";
                });
                var html = "<div class='category'><select id='" + id + "'>" + options + "</select></div>";
                $(this).children(".plupload_file_size").after(html);
                o_cates[id] = $("#" + id + " select").val();
                $("select").change(function(){
                    o_cates[$(this).attr('id')] = $(this).val();
                });
            }
        });
    }
}