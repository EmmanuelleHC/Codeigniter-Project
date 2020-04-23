$(document).ready(function() {
	$("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        enableAllSteps: true,
        enableFinishButton: false,
        enablePagination: false,
        setStep: 0
        /*onStepChanging: function(event, currentIndex, newIndex){
           return true;
        }*/
        /*,
        onFinishing: function(event, currentIndex) {
        	return $('#form-input-branch').form('enableValidation').form('validate');
        },
        onFinished: function (event, currentIndex) {
        	$('#form-input-branch').form('submit', {
                success: function() {
                    $('#content').panel('refresh');
                }
            });
        	return true;
        }*/
    });
});