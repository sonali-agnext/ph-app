function getprivategenvalues(event){
    var inps = document.getElementsByName('private_gen_target[]');
    
    for (var i = 0; i <inps.length; i++) {
        var inp=inps[i];
        var unass;
        var oldval;
        var oldunass;
        var ounass;
        var allunass= document.getElementsByName('private_un_assigned[]');
        for (var ai = 0; ai <allunass.length; ai++) {
            if(ai == i){
                unass = allunass[ai].value;
            }
        }
        var oldunass = document.getElementsByName('old_private_un_assigned[]');
        for (var oai = 0; oai <oldunass.length; oai++) {
            if(oai == i){
                ounass = oldunass[oai].value;
            }
        }
        var old= document.getElementsByName('old_private_gen_target[]');
        for (var oi = 0; oi <old.length; oi++) {
            if(oi == i){
                oldval = old[oi].value;
            }
        }
        //if input value is
        console.log(unass);
        if(unass > 0){
            if(parseFloat(oldval) < parseFloat(inp.value)){
                if((parseFloat(inp.value)-parseFloat(oldval)) <= parseFloat(unass)){
                    var toldunass = parseFloat(inp.value)-parseFloat(oldval);
                    console.log(toldunass);
                    var suboldnew = parseFloat(unass)-toldunass;
                    if(suboldnew > 0){
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="private_un_assigned[]"]').eq(x).val(suboldnew);
                            }
                            
                        }
                    }else{
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="private_un_assigned[]"]').eq(x).val(0);
                            }
                            
                        }
                    }
                }else{
                    swal({
                            title: "Target of unassigned value is exceeded",
                            text: "Please insert valid value",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        })
                    .then((willUpdate) => {
                        if (willUpdate) {
                            event.value = oldval;
                        }else{
                            var id = $("#district_id").val();
                            var year = $('#year').val();
                            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
                            window.location = url;
                        }
                    })
                }
            }
        }else{
            swal("Targets not available to assign", {
                icon: "error",
            });
            var id = $("#district_id").val();
            var year = $('#year').val();
            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
            window.location = url;
        }
    }
}
function getprivatescvalues(event){
    var inps = document.getElementsByName('private_sc_target[]');
    
    for (var i = 0; i <inps.length; i++) {
        var inp=inps[i];
        var unass;
        var oldval;
        var oldunass;
        var ounass;
        var allunass= document.getElementsByName('private_un_assigned[]');
        for (var ai = 0; ai <allunass.length; ai++) {
            if(ai == i){
                unass = allunass[ai].value;
            }
        }
        var oldunass = document.getElementsByName('old_private_un_assigned[]');
        for (var oai = 0; oai <oldunass.length; oai++) {
            if(oai == i){
                ounass = oldunass[oai].value;
            }
        }
        var old= document.getElementsByName('old_private_sc_target[]');
        for (var oi = 0; oi <old.length; oi++) {
            if(oi == i){
                oldval = old[oi].value;
            }
        }
        //if input value is
        console.log(unass);
        if(unass > 0){
            if(parseFloat(oldval) < parseFloat(inp.value)){
                if((parseFloat(inp.value)-parseFloat(oldval)) <= parseFloat(unass)){
                    var toldunass = parseFloat(inp.value)-parseFloat(oldval);
                    var suboldnew = parseFloat(unass)-toldunass;
                    console.log(toldunass);
                    console.log(suboldnew,ounass)
                    if(suboldnew > 0){
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="private_un_assigned[]"]').eq(x).val(suboldnew);
                            }
                            
                        }
                    }else{
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="private_un_assigned[]"]').eq(x).val(0);
                            }
                            
                        }
                    }
                }else{
                    swal({
                            title: "Target of unassigned value is exceeded",
                            text: "Please insert valid value or click on cancel button",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        })
                    .then((willUpdate) => {
                        if (willUpdate) {
                            event.value = oldval;
                        }else{
                            var id = $("#district_id").val();
                            var year = $('#year').val();
                            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
                            window.location = url;
                        }
                    })
                }
            }
        }else{
            swal("Targets not available to assign", {
                icon: "error",
            });
            event.value = oldval;
            var id = $("#district_id").val();
            var year = $('#year').val();
            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
            window.location = url;
        }
    }
}
function getprivatestvalues(event){
    var inps = document.getElementsByName('private_st_target[]');
    
    for (var i = 0; i <inps.length; i++) {
        var inp=inps[i];
        var unass;
        var oldval;
        var oldunass;
        var ounass;
        var allunass= document.getElementsByName('private_un_assigned[]');
        for (var ai = 0; ai <allunass.length; ai++) {
            if(ai == i){
                unass = allunass[ai].value;
            }
        }
        var oldunass = document.getElementsByName('old_private_un_assigned[]');
        for (var oai = 0; oai <oldunass.length; oai++) {
            if(oai == i){
                ounass = oldunass[oai].value;
            }
        }
        var old= document.getElementsByName('old_private_st_target[]');
        for (var oi = 0; oi <old.length; oi++) {
            if(oi == i){
                oldval = old[oi].value;
            }
        }
        //if input value is
        console.log(unass);
        if(unass > 0){
            if(parseFloat(oldval) < parseFloat(inp.value)){
                if((parseFloat(inp.value)-parseFloat(oldval)) <= parseFloat(unass)){
                    var toldunass = parseFloat(inp.value)-parseFloat(oldval);
                    var suboldnew = parseFloat(unass)-toldunass;
                    console.log(toldunass);
                    console.log(suboldnew,ounass)
                    if(suboldnew > 0){
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="private_un_assigned[]"]').eq(x).val(suboldnew);
                            }
                            
                        }
                    }else{
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="private_un_assigned[]"]').eq(x).val(0);
                            }
                            
                        }
                    }
                }else{
                    swal({
                            title: "Target of unassigned value is exceeded",
                            text: "Please insert valid value or click on cancel button",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        })
                    .then((willUpdate) => {
                        if (willUpdate) {
                            event.value = oldval;
                        }else{
                            var id = $("#district_id").val();
                            var year = $('#year').val();
                            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
                            window.location = url;
                        }
                    })
                }
            }
        }else{
            swal("Targets not available to assign", {
                icon: "error",
            });
            event.value = oldval;
            var id = $("#district_id").val();
            var year = $('#year').val();
            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
            window.location = url;
        }
    }
}
function getprivatewomenvalues(event){
    var inps = document.getElementsByName('private_women_target[]');
    
    for (var i = 0; i <inps.length; i++) {
        var inp=inps[i];
        var unass;
        var oldval;
        var oldunass;
        var ounass;
        var allunass= document.getElementsByName('private_un_assigned[]');
        for (var ai = 0; ai <allunass.length; ai++) {
            if(ai == i){
                unass = allunass[ai].value;
            }
        }
        var oldunass = document.getElementsByName('old_private_un_assigned[]');
        for (var oai = 0; oai <oldunass.length; oai++) {
            if(oai == i){
                ounass = oldunass[oai].value;
            }
        }
        var old= document.getElementsByName('old_private_women_target[]');
        for (var oi = 0; oi <old.length; oi++) {
            if(oi == i){
                oldval = old[oi].value;
            }
        }
        //if input value is
        console.log(unass);
        if(unass > 0){
            if(parseFloat(oldval) < parseFloat(inp.value)){
                if((parseFloat(inp.value)-parseFloat(oldval)) <= parseFloat(unass)){
                    var toldunass = parseFloat(inp.value)-parseFloat(oldval);
                    var suboldnew = parseFloat(unass)-toldunass;
                    console.log(toldunass);
                    console.log(suboldnew,ounass)
                    if(suboldnew > 0){
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="private_un_assigned[]"]').eq(x).val(suboldnew);
                            }
                            
                        }
                    }else{
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="private_un_assigned[]"]').eq(x).val(0);
                            }
                            
                        }
                    }
                }else{
                    swal({
                            title: "Target of unassigned value is exceeded",
                            text: "Please insert valid value or click on cancel button",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        })
                    .then((willUpdate) => {
                        if (willUpdate) {
                            event.value = oldval;
                        }else{
                            var id = $("#district_id").val();
                            var year = $('#year').val();
                            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
                            window.location = url;
                        }
                    })
                }
            }
        }else{
            swal("Targets not available to assign", {
                icon: "error",
            });
            event.value = oldval;
            var id = $("#district_id").val();
            var year = $('#year').val();
            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
            window.location = url;
        }
    }
}
function getgenvalues(event){
    var inps = document.getElementsByName('gen_target[]');
    
    for (var i = 0; i <inps.length; i++) {
        var inp=inps[i];
        var unass;
        var oldval;
        var oldunass;
        var ounass;
        var allunass= document.getElementsByName('un_assigned[]');
        for (var ai = 0; ai <allunass.length; ai++) {
            if(ai == i){
                unass = allunass[ai].value;
            }
        }
        var oldunass = document.getElementsByName('old_un_assigned[]');
        for (var oai = 0; oai <oldunass.length; oai++) {
            if(oai == i){
                ounass = oldunass[oai].value;
            }
        }
        var old= document.getElementsByName('old_gen_target[]');
        for (var oi = 0; oi <old.length; oi++) {
            if(oi == i){
                oldval = old[oi].value;
            }
        }
        //if input value is
        console.log(unass);
        if(unass > 0){
            if(parseFloat(oldval) < parseFloat(inp.value)){
                if((parseFloat(inp.value)-parseFloat(oldval)) <= parseFloat(unass)){
                    var toldunass = parseFloat(inp.value)-parseFloat(oldval);
                    console.log(toldunass);
                    var suboldnew = parseFloat(unass)-toldunass;
                    if(suboldnew > 0){
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="un_assigned[]"]').eq(x).val(suboldnew);
                            }
                            
                        }
                    }else{
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="un_assigned[]"]').eq(x).val(0);
                            }
                            
                        }
                    }
                }else{
                    swal({
                            title: "Target of unassigned value is exceeded",
                            text: "Please insert valid value",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        })
                    .then((willUpdate) => {
                        if (willUpdate) {
                            event.value = oldval;
                        }else{
                            var id = $("#district_id").val();
                            var year = $('#year').val();
                            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
                            window.location = url;
                        }
                    })
                }
            }
        }else{
            swal("Targets not available to assign", {
                icon: "error",
            });
            var id = $("#district_id").val();
            var year = $('#year').val();
            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
            window.location = url;
        }
    }
}
function getscvalues(event){
    var inps = document.getElementsByName('sc_target[]');
    
    for (var i = 0; i <inps.length; i++) {
        var inp=inps[i];
        var unass;
        var oldval;
        var oldunass;
        var ounass;
        var allunass= document.getElementsByName('un_assigned[]');
        for (var ai = 0; ai <allunass.length; ai++) {
            if(ai == i){
                unass = allunass[ai].value;
            }
        }
        var oldunass = document.getElementsByName('old_un_assigned[]');
        for (var oai = 0; oai <oldunass.length; oai++) {
            if(oai == i){
                ounass = oldunass[oai].value;
            }
        }
        var old= document.getElementsByName('old_private_sc_target[]');
        for (var oi = 0; oi <old.length; oi++) {
            if(oi == i){
                oldval = old[oi].value;
            }
        }
        //if input value is
        console.log(unass);
        if(unass > 0){
            if(parseFloat(oldval) < parseFloat(inp.value)){
                if((parseFloat(inp.value)-parseFloat(oldval)) <= parseFloat(unass)){
                    var toldunass = parseFloat(inp.value)-parseFloat(oldval);
                    var suboldnew = parseFloat(unass)-toldunass;
                    console.log(toldunass);
                    console.log(suboldnew,ounass)
                    if(suboldnew > 0){
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="un_assigned[]"]').eq(x).val(suboldnew);
                            }
                            
                        }
                    }else{
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="un_assigned[]"]').eq(x).val(0);
                            }
                            
                        }
                    }
                }else{
                    swal({
                            title: "Target of unassigned value is exceeded",
                            text: "Please insert valid value or click on cancel button",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        })
                    .then((willUpdate) => {
                        if (willUpdate) {
                            event.value = oldval;
                        }else{
                            var id = $("#district_id").val();
                            var year = $('#year').val();
                            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
                            window.location = url;
                        }
                    })
                }
            }
        }else{
            swal("Targets not available to assign", {
                icon: "error",
            });
            event.value = oldval;
            var id = $("#district_id").val();
            var year = $('#year').val();
            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
            window.location = url;
        }
    }
}
function getstvalues(event){
    var inps = document.getElementsByName('st_target[]');
    
    for (var i = 0; i <inps.length; i++) {
        var inp=inps[i];
        var unass;
        var oldval;
        var oldunass;
        var ounass;
        var allunass= document.getElementsByName('un_assigned[]');
        for (var ai = 0; ai <allunass.length; ai++) {
            if(ai == i){
                unass = allunass[ai].value;
            }
        }
        var oldunass = document.getElementsByName('old_un_assigned[]');
        for (var oai = 0; oai <oldunass.length; oai++) {
            if(oai == i){
                ounass = oldunass[oai].value;
            }
        }
        var old= document.getElementsByName('old_st_target[]');
        for (var oi = 0; oi <old.length; oi++) {
            if(oi == i){
                oldval = old[oi].value;
            }
        }
        //if input value is
        console.log(unass);
        if(unass > 0){
            if(parseFloat(oldval) < parseFloat(inp.value)){
                if((parseFloat(inp.value)-parseFloat(oldval)) <= parseFloat(unass)){
                    var toldunass = parseFloat(inp.value)-parseFloat(oldval);
                    var suboldnew = parseFloat(unass)-toldunass;
                    console.log(toldunass);
                    console.log(suboldnew,ounass)
                    if(suboldnew > 0){
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="un_assigned[]"]').eq(x).val(suboldnew);
                            }
                            
                        }
                    }else{
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="un_assigned[]"]').eq(x).val(0);
                            }
                            
                        }
                    }
                }else{
                    swal({
                            title: "Target of unassigned value is exceeded",
                            text: "Please insert valid value or click on cancel button",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        })
                    .then((willUpdate) => {
                        if (willUpdate) {
                            event.value = oldval;
                        }else{
                            var id = $("#district_id").val();
                            var year = $('#year').val();
                            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
                            window.location = url;
                        }
                    })
                }
            }
        }else{
            swal("Targets not available to assign", {
                icon: "error",
            });
            event.value = oldval;
            var id = $("#district_id").val();
            var year = $('#year').val();
            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
            window.location = url;
        }
    }
}
function getwomenvalues(event){
    var inps = document.getElementsByName('women_target[]');
    
    for (var i = 0; i <inps.length; i++) {
        var inp=inps[i];
        var unass;
        var oldval;
        var oldunass;
        var ounass;
        var allunass= document.getElementsByName('un_assigned[]');
        for (var ai = 0; ai <allunass.length; ai++) {
            if(ai == i){
                unass = allunass[ai].value;
            }
        }
        var oldunass = document.getElementsByName('old_un_assigned[]');
        for (var oai = 0; oai <oldunass.length; oai++) {
            if(oai == i){
                ounass = oldunass[oai].value;
            }
        }
        var old= document.getElementsByName('old_women_target[]');
        for (var oi = 0; oi <old.length; oi++) {
            if(oi == i){
                oldval = old[oi].value;
            }
        }
        //if input value is
        console.log(unass);
        if(unass > 0){
            if(parseFloat(oldval) < parseFloat(inp.value)){
                if((parseFloat(inp.value)-parseFloat(oldval)) <= parseFloat(unass)){
                    var toldunass = parseFloat(inp.value)-parseFloat(oldval);
                    var suboldnew = parseFloat(unass)-toldunass;
                    console.log(toldunass);
                    console.log(suboldnew,ounass)
                    if(suboldnew > 0){
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="un_assigned[]"]').eq(x).val(suboldnew);
                            }
                            
                        }
                    }else{
                        for (var x = 0; x <allunass.length; x++) {
                            if(x == i){
                                $('input[name="un_assigned[]"]').eq(x).val(0);
                            }
                            
                        }
                    }
                }else{
                    swal({
                            title: "Target of unassigned value is exceeded",
                            text: "Please insert valid value or click on cancel button",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        })
                    .then((willUpdate) => {
                        if (willUpdate) {
                            event.value = oldval;
                        }else{
                            var id = $("#district_id").val();
                            var year = $('#year').val();
                            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
                            window.location = url;
                        }
                    })
                }
            }
        }else{
            swal("Targets not available to assign", {
                icon: "error",
            });
            event.value = oldval;
            var id = $("#district_id").val();
            var year = $('#year').val();
            var url = '/manage-subsidy-district?year='+year+'&district_id='+id;
            window.location = url;
        }
    }
}