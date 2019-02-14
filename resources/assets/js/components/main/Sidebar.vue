<template>
    <div class="card m-0 p-0 labelfontbold" style="font-size:.85rem; height:100%">                              
        <nav class="card-body m-0 pl-1 mr-0 pr-0">
            <ul class="list-group list-group-flush">
                <li class="list-group-item noborder"><i class="fas fa-chart-line mr-2"></i><a class='sidetab' href='/1_atms/public/dashboard'>DASHBOARD</a>
                    <ul v-if='isadmintech' class="list-group list-group-flush">
                        <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/it/rp/today'>TICKETS</a><span class="badge-pill badge-info"></span></li>
                        <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/it/rp/ctoday'>CCTV REVIEWS</a><span class="badge-pill badge-info"></span></li>
                    </ul>
                </li>
                <li v-if='isadmin' class="list-group-item noborder"><i class="fa fa-lock mr-2"></i><span class='sidetab'>ADMIN</span>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/admin/role'>ROLES</a><span class="badge-pill badge-info"></span></li>
                        <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/admin/export'>EXPORT</a>
                            <span class="badge-pill badge-info">
                                
                            </span>
                        </li>
                    </ul>
                </li>          
                <li class="list-group-item noborder"><i class="fa fa-desktop mr-2"></i><span class='sidetab'>MIS</span>
                    <ul class="list-group list-group-flush">                        
                        <div v-if='isadmin'>
                            <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/it/al'>TICKETS</a>
                                <span class="badge-pill badge-danger">{{openticket}}</span>
                            </li>                            
                        </div>
                        <div v-else>
                            <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/it/lt'>TICKETS</a>
                                <span class="badge-pill badge-danger">{{queuedticket}}</span>
                            </li>
                        </div>
                        <li class="list-group-item noborder d-flex justify-content-between align-items-center">
                            <a class='sidetab' href='/1_atms/public/cr/crl'>CCTV REVIEWS</a>
                            <span class="badge-pill badge-danger">
                                <div v-if='isadmin'>
                                    {{approvedreviews}}
                                </div>
                                <div v-else>
                                    <div v-if='istech'>
                                        {{queuedreviews}}
                                    </div>                                    
                                </div>        
                            </span>
                        </li>                        
                    </ul>
                </li>
                <!-- <li class="list-group-item noborder"><i class="fas fa-users mr-2"></i><span class='sidetab'>HR</span>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/hr/vrl'>VEHICLE REQUEST</a>
                            <span class="badge-pill badge-danger">
                                {{vr_approval}}
                            </span>
                            <span class="badge badge-info" style='font-size:.8rem'>&#8656; New</span>
                        </li>                        
                    </ul>
                </li> -->
                <!-- <li class="list-group-item noborder"><a class='sidetab' href='#'>PURCHASING</a>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/comingsoon'>PURCHASE REQUEST</a><span class="badge badge-info"></span></li>
                        <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/comingsoon'>OTHER REQUEST</a><span class="badge badge-info"></span></li>
                        <li class="list-group-item noborder d-flex justify-content-between align-items-center"><a class='sidetab' href='/1_atms/public/comingsoon'>OTHERS</a><span class="badge badge-info"></span></li>
                    </ul>
                </li> -->
            </ul>                              
        </nav>                       
    </div>
</template>

<script>
    export default {
        props:[
            'isadmin',
            'istech',
            'openticket',
            'queuedticket',
            'approvedreviews',
            'queuedreviews',
            'forapprovalreviews',
            'vr_approval'
        ],
        computed:{
            isadmintech: function() {
                if(this.isadmin || this.istech){
                    return true
                }
            }
        },
        mounted() {
            /* console.log('Component mounted.') */
        }
    }
</script>
