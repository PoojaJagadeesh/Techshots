require('./bootstrap');
require('./jquery.min');
require('./bootstrap.bundle.min');
require('./jquery.easing.min');
require('./infiniteslidev2');
require('./sb-admin-2.min');

$(function(){
    $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
         }
     });
 });
