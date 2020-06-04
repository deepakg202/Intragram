$('input[name="method_select"]').on('click', ()=>{
    var lst = ["urlImage", "localImage"];
    var selected = $("input[name='method_select']:checked").val();
    
    for(var i in lst)
    {
        if(lst[i]==selected)
            $('#'+lst[i]).prop('disabled', false);
        else
            $('#'+lst[i]).prop('disabled', true);
    }
    
});
