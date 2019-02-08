
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('notifbox', require('./components/main/Notification.vue'));
Vue.component('sidebar', require('./components/main/Sidebar.vue'));
Vue.component('foot', require('./components/main/Footer.vue'));
Vue.component('usermodal', require('./components/hr/vehicleRequest/RoleModal.vue'));

const app = new Vue({
    el: '#app',
    data:{
        unreadNotifCount1: 0,
        unreadnotifs1: [],
        readnotifs1: [],
        userdata: []
    },
    methods:{
        updatedata: function(urnc,urn/* ,rn */){
            this.unreadNotifCount1 = urnc;
            this.unreadnotifs1 = urn;
            /* this.readnotifs1 = rn; */
        },
        openrolemodal: function(id){
            $.ajax({
                type: 'get',
                url: "/1_atms/public/users/"+id,
                global: false,
                success: function (data) {
                    app.userdata = data                    
                }
            });
            $('#rolemod').modal('show')
        }
    },
    created(){
        Echo.channel('notification.refresh')
        .listen('triggerEvent', (e) => {
            console.log(e);
            $.ajax({
                type: 'get',
                url: "/1_atms/public/ddmenu",
                global: false,
                success: function (data) {
                    $('#notificon').html(data);
                }
            });

        });
        /* Echo.private('notification')
        .listen('NotificationTask', (e) => {
            console.log(e);
        }); */
        Echo.private(`App.User.` + document.head.querySelector('meta[name="userid"]').content)
        .notification((notification) => {
            console.log(notification.type);
            /* $.ajax({
                type: 'get',
                url: "/1_atms/public/ddmenu",
                global: false,
                success: function (data) {
                    $('#notificon').html(data);
                }
            }); */
            
            /* app.unreadNotifCount1 = app.unreadNotifCount1 + 1; */
            
            $.ajax({
                type: 'get',
                url: "/1_atms/public/getunreadnotif",
                global: false,
                success: function (data) {
                    app.unreadNotifCount1++;
                    app.unreadnotifs1 = data;
                    /* alert(typeof data); */
                }
            });            

            const options = {
                body: notification.msg,
                icon: 'http://localhost/1_atms/public/images/ptpi.png',
                data: notification.url,
            };
            notify = new Notification(notification.header,options);
            notify.onclick = function(event) {
                event.preventDefault(); // prevent the browser from focusing the Notification's tab
                window.open(notify.data, '_blank');
            }            
        });        
    }
});

var $ = require("jquery");

window.moment = require('moment');
require('select2');
window.iziToast = require('izitoast');
window.NProgress = require('nprogress');
window.swal = require('sweetalert2');