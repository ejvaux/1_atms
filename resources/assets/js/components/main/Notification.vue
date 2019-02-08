<template>
    <li class="nav-item dropdown" id='notificon'> 
        <a href="#" class="nav-link" data-toggle="dropdown">
            <span> 
                <i class="fa fa-bell nb-size"></i>
                <span v-if="unreadNotifCount" class="badge-pill badge-danger badge-top">{{unreadNotifCount}}</span>
            </span>
        </a>
           <!-- <button @click='updatevalue'>try</button> -->
        <ul class='dropdown-menu'>
            <li class="dropdown-header border-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md">
                            <strong>Notifications</strong>
                        </div>
                        <div class="col-md mr-auto pr-0 m-0 text-right">
                            <span class='font-weight-bold'><a v-bind:href="markallreadlink">Mark all as Read</a></span>
                        </div>
                    </div>
                </div>                
            </li>
            <li>
                <div class="notif-box">
                    <ul class='p-0 notif-box-2'>
                        <div v-if="userNotifCount">
                            <!-- <span>test</span> -->
                            <li v-bind:key="unreadnotif.id" v-for='unreadnotif in unreadnotifs' class='border-bottom border-top p-0'>
                                <a class="dropdown-item notiflink" v-bind:href="'/1_atms/public/markread/' + unreadnotif.id + '/' + unreadnotif.data.mod + '/' + unreadnotif.data.tid">                                
                                    <div class="notice notice-success m-0">
                                        <strong>{{ unreadnotif.data.message }}</strong><br>
                                        {{unreadnotif.data.msg}}<br>
                                        <span class='text-muted notif-lapsed-time'>{{datetimelapse(unreadnotif.created_at)}}</span>
                                    </div>                                                                                                    
                                </a>
                            </li>
                            <li v-bind:key="readnotif.id" v-for='readnotif in readnotifs' class='border-bottom border-top p-0'>
                                <a class="dropdown-item notiflink" v-bind:href="'/1_atms/public/markread/' + readnotif.id + '/' + readnotif.data.mod + '/' + readnotif.data.tid">                                
                                    <div class="notice m-0">
                                        <strong>{{ readnotif.data.message }}</strong><br>
                                        {{readnotif.data.msg}}<br>
                                        <span class='text-muted notif-lapsed-time'>{{datetimelapse(readnotif.created_at)}}</span>
                                    </div>                                                                                                    
                                </a>
                            </li>
                        </div>
                        <div v-else class="text-center text-muted m-3" style='font-size: 1rem;'>
                            <span>No new notification</span>
                        </div>
                    </ul>
                </div>                
            </li>
            <li class=' text-center pt-2 border-top'>
                <a v-bind:href="clearNotifLink" ><span class='font-weight-bold p-0'>Clear notifications</span></a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        props: ['unreadNotifCount','markallreadlink','clearNotifLink','unreadnotifs','readnotifs','userNotifCount'],
        mounted() {
            /* console.log('Component mounted.') */            
        },
        methods:{
            datetimelapse: function(dt){
                var datetime1 = Date.parse(dt);
                var datetime2 = Date.now();
                var sec = datetime2 - datetime1;
                var secs = Math.floor(sec/1000);
                if(secs < 60){
                    return secs + " secs ago";
                }
                else if(secs >= 60 && secs < 3600){
                    var a = Math.floor(secs / 60);            
                    if(a>1){
                        return a + " mins ago";
                    }
                    else{
                        return a + " min ago";
                    }              
                }
                else if(secs >= 3600 && secs < 86400){
                    var a = Math.floor(secs / 3600);
                    if(a>1){
                        return a + " hours ago";
                    }
                    else{
                        return a + " hour ago";
                    } 
                }
                else if(secs >= 86400){
                    var a = Math.floor(secs / 86400);
                    if(a>1){
                        return a + " days ago";
                    }
                    else{
                        return a + " day ago";
                    } 
                }
                /* return secs; */
            },
            updatevalue: function () {
                this.$emit('update');
            }
        },
        beforeMount() {
            this.updatevalue();
        }   
    }
</script>
