/**
 * Created by chelo on 04-06-2020.
 */
$(function(){
   //get the click of the create button
   $('#modalButton').click(function (){
       $('#modal').modal('show').find('#modalContent').load($(this).attr('value'));
   });
});

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}


