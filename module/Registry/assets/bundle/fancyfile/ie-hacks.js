/*function focus() {
    Below needs to be cleaned up
    hacky workaround for IE as file inputs have 2 tab stops
    if (isRefocus) {
        $this.parent().addClass('is-focused');
    } else {
        setTimeout(function() {
            fileInput.blur();
            setTimeout(function() {
                fileInput.focus();
            }, 0);
        }, 0);
    }
    isRefocus = !isRefocus;
};

function keydown() { // Good browsers don't need this event
    var keyCode = e.keyCode || e.which;

    if(keyCode == 8 || keyCode == 46){ // backspace || delete
        clearValue();
    }

    if (!e.shiftKey && keyCode === 9) {
        field.prop('disabled',true).attr('data-temp-ie-disabled','true');

        setTimeout(function(){
            $('[data-temp-ie-disabled]').removeAttr('data-temp-ie-disabled').prop('disabled',false).parent().removeClass('is-focused');
        }, 0);
    }

};*/