//เช็ค ASCII String
function isASCII(str) {
    return /^[\x00-\x7F]*$/.test(str);
}
// การใช้งาน ajax แบบ synchronous get แผนกมาเก็บไหวใน get_department
var get_department = $.ajax({
    url: "php/sql_select_department.php",
    type: "GET",
    async: false,
}).responseText;

//Show .delete .edit ทั้งหมด
function edit_delete_show(){
    $("table tbody tr ").find(".delete").show();
    $("table tbody tr ").find(".edit").show();
}
//hide .delete .edit ทั้งหมด
function edit_delete_hide(){
    $("table tbody tr ").find(".delete").not(':eq(0)').hide();
    $("table tbody tr ").find(".edit").not(':eq(0)').hide();
}

//main_admin
$(document).ready(function(){
    var btn_delet_state = 0;
    // search
    $('#search_text').keyup(function(){
        var txt = $(this).val();
        if(txt != ''){
            $.ajax({
                url:"php/ajax_show_select_data_admin.php",
                method:"post",
                data:{search:txt},
                dataType:'text',
                success:function(data){
                    $('#show_select_data').html(data);
                }
            });
        }
        else{
            $.ajax({
                url:"php/ajax_show_select_data_admin.php",
                method:"post",
                data:{search:txt},
                dataType:'text',
                success:function(data){
                    $('#show_select_data').html(data);
                }
            });
        }
    });

    // tabel
    var number_index;
    var actions;
    $.get("php/php_check_length.php", function(data, status){
        number_index = JSON.parse(data);
        $('[data-toggle="tooltip"]').tooltip();
        actions =  "<a class='add'  data-toggle='tooltip'><i class='fas fa-lg fa-user-plus text-success'></i></a>"+
                   "<a class='edit' data-toggle='tooltip' id='"+number_index+"'><i class='fas fa-lg fa-pencil-alt text-warning'></i></a>"+
                   "<a class='delete' data-toggle='tooltip' id='"+number_index+"'><i class='fas fa-lg fa-trash text-danger'></i></a>";
    });

	// Append table with add row form on add new button click
    $(".add-new").click(function(){
        $('#addnewform').modal('show');
    });

    // กดยืนยันการเพิ่มข้อมูล
    $(document).on("click", "#am_add_new_submit", function(){
        var state_add = 0; 
        var empty = false;
        var input = $(this).parents(".modal-content").find('.form-group input , .form-group select');
        input.each(function(i){
			if(!$(this).val()){
				$(this).addClass("error");
                empty = true;
            }
            else{
                $(this).removeClass("error");
            }
        });
        if(!empty){
            if(isASCII($('#am_id').val())){
                if($('#am_password1').val() == $('#am_password2').val()){
                    input.eq(0).removeClass("error");
                    $(this).parents(".modal-content").find('#am_idHelp').removeClass('text-danger').addClass('text-muted');
                    if(isASCII($('#am_password1').val())){
                        $(this).parents(".modal-content").find('input[type="password"]').removeClass('error');
                        $(this).parents(".modal-content").find('#am_idpassword').removeClass('text-danger').addClass('text-muted').html("กรุณาใส่ Password เป็นภาษาอังกฤษหรือตัวเลข");
                        if(isASCII($('#am_email').val())){
                            state_add = 1;
                        }
                        else{
                            $(this).parents(".modal-content").find('input[type="am_email"]').addClass('error');
                            $(this).parents(".modal-content").find('#am_email').removeClass('text-muted').addClass('text-danger').html("กรุณาใส่ Email เป็นภาษาอังกฤษ");
                        }
                    }
                    else{
                        $(this).parents(".modal-content").find('input[type="password"]').addClass('error');
                        $(this).parents(".modal-content").find('#am_idpassword').removeClass('text-muted').addClass('text-danger').html("กรุณาใส่ Password เป็นภาษาอังกฤษหรือตัวเลข");
                    }
                }
                else{
                    $(this).parents(".modal-content").find('input[type="password"]').addClass('error');
                    $(this).parents(".modal-content").find('#am_idpassword').removeClass('text-muted').addClass('text-danger').html("กรุณาใส่ Password ให้เหมือนกัน");
                }
            }
            else{
                input.eq(0).addClass("error");
                $(this).parents(".modal-content").find('#am_idHelp').removeClass('text-muted').addClass('text-danger');
            }
            if(state_add == 1){
                var dataSet = {
                    txtam_id : $('#am_id').val(),
                    txtam_prefix : $('#am_prefix').val(),
                    txtam_firstname : $('#am_firstname').val(),
                    txtam_lastname : $('#am_lastname').val(),
                    txtam_department_id : $('#am_department_id').val(),
                    txtam_leve : $('#am_leve').val(),
                    txtam_email : $('#am_email').val(),
                    txtam_password : $('#am_password1').val(),
                };
                var dataString = JSON.stringify(dataSet);
                console.log(dataString);
                $.ajax({
                    type: "POST",
                    url: "php/ajax_add_admin.php",
                    data: {dataset : dataString},
                    async: false,
                    success : function(data) {
                        if(data[1] == 1){
                            massage_green(data[0]);
                            state_add = 2;
                        }
                        else if(data[1] == 2){
                            input.eq(0).addClass("error");
                            $(this).parents(".modal-content").find('#am_idHelp').removeClass('text-muted').addClass('text-danger').html(data[0]);
                        }
                    },
                    dataType: 'json'
                });
            }
            if(state_add == 2){
                $('#addnewform').modal('hide');
            }
        }
    });

	// Add row on add button click
	$(document).on("click", ".add", function(){
        var this_add = this;
        console.log(this_add);
		var empty = false;
		var input = $(this).parents("tr").find('input[type="text"], select');
        input.each(function(){
			if(!$(this).val()){
				$(this).addClass("error");
                empty = true;
			} else{
                $(this).removeClass("error");
            }
        });
        var dataSet = {
            txtam_id : $('#txtam_id').val(),
            txtam_prefix : $('#txtam_prefix').val(),
            txtam_firstname : $('#txtam_firstname').val(),
            txtam_lastname : $('#txtam_lastname').val(),
            txtam_department_id : $('#txtam_department_id').val(),
            txtam_leve : $('#txtam_leve').val(),
            txtam_email : $('#txtam_email').val()
        };
        var dataString = JSON.stringify(dataSet);
        if(!empty){
            $.post("php/ajax_add_admin.php",{dataset : dataString},function(data) {
                var json_Convert = JSON.parse(data);
                if(json_Convert[1] == 0){
                    massage_red(json_Convert[0]);
                    empty = true;
                }
                else if(json_Convert[1] == 1){
                    massage_green(json_Convert[0]);
                    empty = false;
                }
                else if(json_Convert[1] == 2){
                    massage_red(json_Convert[0]);
                    empty = true;
                }
                $(this).parents("tr").find(".error").first().focus();
                if(!empty){
                    input.each(function(){
                        $(this).parent("td").html($(this).val());
                    });
                    $(this_add).parents("tr").find(".add, .edit").toggle();
                    $(".add-new").removeAttr("disabled");
                    edit_delete_show();
                }
            });
        }
    });

	// Edit row on edit button click
	$(document).on("click", ".edit", function(){
        btn_delet_state = 1;	
        $(this).parents("tr").find("td:not(:last-child)").each(function(i){
            var select_state = 0;
            if(i == "0"){
                var idname = 'txtam_id';
            }
            else if(i == "1"){
                var idname = 'txtam_prefix';
                select_state = 1;
            }
            else if(i == "2"){
                var idname = 'txtam_firstname';
            }
            else if(i == "3"){
                var idname = 'txtam_lastname';
            }
            else if(i == "4"){
                var idname = 'txtam_department_id';
                select_state = 2;
            }
            else if(i == "5"){
                var idname = 'txtam_leve';
            }
            else if(i == "6"){
                var idname = 'txtam_email';
            }
            if(select_state == 0){
                $(this).html("<input type='text' name='updaterec' id='"+idname+"' class='form-control' value='" + $(this).text() + "'>");
            }
            if(select_state == 1){
                $(this).html(
                    '<select class="form-control" name="am_prefix" id="txtam_prefix">'+
                        "<option selected>"+$(this).text()+"</option>"+
                        '<option value="นาย">นาย</option>'+
                        '<option value="นาง">นาง</option>'+
                        '<option value="นางสาว">นางสาว</option>'+
                        '<option value="อาจารย์">อาจารย์</option>'+
                        '<option value="ผู้ช่วยศาสตราจารย์">ผู้ช่วยศาสตราจารย์</option>'+
                        '<option value="รองศาสตราจารย์">รองศาสตราจารย์</option>'+
                        '<option value="ศาสตราจารย์">ศาสตราจารย์</option>'+
                    '</select>'
                );
            }
            if(select_state == 2){
                $(this).html(
                    '<select class="form-control" name="am_department_id" id="txtam_department_id">'+
                        "<option selected>"+$(this).text()+"</option>"+
                        get_department +
                    '</select>'
                );
            }
        });
        $("table tbody tr ").find(".delete , .edit").hide();
        $(this).parents("tr").find(".add, .delete").toggle();
        $(".add-new").attr("disabled", "disabled");
        $(this).parents("tr").find(".add").removeClass("add").addClass("update");
    });

    // Update row on edit button click
    $(document).on("click",".update",function(){
        var update_state = 0;
        var empty = false;
        var input = $(this).parents("tr").find('input[type="text"], select');
        input.each(function(){
			if(!$(this).val()){
                $(this).addClass("error");
                empty = true;
			} else{
                $(this).removeClass("error");
            }
        });
        if(!empty){
            if(isASCII($('#txtam_id').val())){
                console.log("Y");
                var dataSet = {
                    txtam_id : $('#txtam_id').val(),
                    txtam_prefix : $('#txtam_prefix').val(),
                    txtam_firstname : $('#txtam_firstname').val(),
                    txtam_lastname : $('#txtam_lastname').val(),
                    txtam_department_id : $('#txtam_department_id').val(),
                    txtam_leve : $('#txtam_leve').val(),
                    txtam_email : $('#txtam_email').val()
                };
                var dataString = JSON.stringify(dataSet);
                console.log(dataString);
                $.ajax({
                    type: "POST",
                    url: "php/ajax_update_admin.php",
                    data: {dataset : dataString},
                    async: false,
                    success : function(data) {
                        massage_yellow(data);
                        update_state = 1;
                    },
                    dataType: 'json'
                });
            }
            else{
                console.log("N");
                input.eq(0).addClass("error");
                massage_red("กรุณากรอก Admin ID เป็นภาษาอังกฤษหรือตัวเลข");
            }
        }
        if(update_state == 1){
            edit_delete_show();
            $("table tbody tr ").find(".update").hide();
            $(this).parents("tr").find(".error").first().focus();
            input.each(function(){
                $(this).parent("td").html($(this).val());
            });
            $(".add-new").removeAttr("disabled");
            edit_delete_show();
            $(this).parents("tr").find(".update").removeClass("update").addClass("add");
            btn_delet_state = 0;
        }
    });

	// Delete row on delete button click
	$(document).on("click", ".delete", function(){
        console.log(this);
        $(".add-new").removeAttr("disabled");
        var input = $(this).parents("tr").find('input[type="text"], select');
        if(btn_delet_state == 1){
            btn_delet_state = 0;
            massage_red("ยกเลิก");
            edit_delete_show();
            $("table tbody tr ").find(".update").hide();
            $(this).parents("tr").find(".error").first().focus();
            input.each(function(){
                $(this).parent("td").html($(this).val());
            });
            $(".add-new").removeAttr("disabled");
            edit_delete_show();
            $(this).parents("tr").find(".update").removeClass("update").addClass("add");
        }
        else if(btn_delet_state == 0){
            var this_a = this;
            $('#deletModal').modal('show');
            $('#deletModal .modal-footer button#btn_delete_data').on('click',function(){
                var dataSet = {
                    txtam_id : $(this_a).attr("id")
                };
                var dataString = JSON.stringify(dataSet);
                $.ajax({
                    type: "POST",
                    url: "php/ajax_delete_admin.php",
                    data: {dataset : dataString},
                    async: false,
                    success : function(data) {
                        console.log(data);
                        massage_red(data[0]);
                    },
                    dataType: 'json'
                });
                $(this_a).parents("tr").remove();
                $('#deletModal').modal('hide');
            });
        }
        edit_delete_show();
    });
});