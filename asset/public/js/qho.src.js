var qho = {
    check_all:function(){
        var $_is_checked = $('#checkall').is(':checked');
        $('input[type=checkbox].checked').each(function() {
            $(this).attr('checked', $_is_checked);
            $(this).parent().parent().removeClass('highlight');
            if($_is_checked) {
                $(this).parent().parent().addClass('highlight');
            }
        });
    },
    
    check_this :function($_this){
        $($_this).parent().parent().removeClass('warning');
        if($($_this).is(':checked')) {
            $($_this).parent().parent().addClass('warning');
        }
    },
    
    multiple_delete:function(){
        var $a_ids = $('input[type=checkbox]').serializeArray();
        if($a_ids.length == 0) {
            alert('Please choose at least one item to delete.');
        }
        else {
            if(confirm('Are you sure you want to delete?')) {
                $('form#form2').submit();
            }
        }
    },
    
    single_delete:function(link){
        if(confirm('Are you sure you want to delete?')) {
            $(location).attr('href',link);
        }
    }
}
