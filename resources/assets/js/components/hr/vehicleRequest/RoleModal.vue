<template>
    <div class="modal hide fade in" tabindex="-1" role="dialog" id="rolemod">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Edit User Roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="roleform"  method="post">
                <input type="hidden" id="userid" name="id" :value='loggeduserid'>
                <div class="modal-body" style="">
                
                    <!-- ____________ FORM __________________ -->

                    <div class='container'>                        
                        <div class='row'>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                        <span class='font-weight-bold'>SYSTEM</span>
                                    </div>
                                    <div class="card-body container">
                                        <div class='row'>
                                            <div class='col-md'>
                                                <!-- <span>{{userd.name}}</span>
                                                <span>{{JSON.stringify(userd)}}</span> -->
                                                <input id='' v-model='userd.admin' :disabled="loggeduserid == userd.id" :checked='userd.admin' :true-value="1" :false-value="0" type='checkbox'><span class='ml-3'>Admin</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                        <span class='font-weight-bold'>MIS</span>
                                    </div>
                                    <div class="card-body container">
                                        <div class='row'>
                                            <div class='col-md'>
                                                <input id='' v-model='userd.tech' :checked='userd.tech' :true-value="1" :false-value="0" type='checkbox'><span class='ml-3'>Tech</span>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md'>
                                                <input id='' v-model='userd.req_approver' :checked='userd.req_approver' :true-value="1" :false-value="0" type='checkbox'><span class='ml-3'>CCTV Approver</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class="card">
                                    <div class="card-header">
                                        <span class='font-weight-bold'>HR</span>
                                    </div>
                                    <div class="card-body container">
                                        <div class='row'>
                                            <div class="col-md">
                                                <label class=''>Vehicle Request:</label>
                                            </div>
                                            <div class='col-md'>                                                
                                                <select id='vehicle_approve' class='' v-model="userd.hrvr_approval_type">
                                                    <option value='0'>-Select type-</option>
                                                    <option v-bind:key="approvaltype.id" v-for='approvaltype in approvaltypes' :value='approvaltype.id'>{{approvaltype.name}}</option>                                                    
                                                </select>
                                                <select v-if='userd.hrvr_approval_type == 1 || userd.hrvr_approval_type == 2' id='vehicle_approve_dept' class='' v-model="userd.hrvr_approval_dept">
                                                    <option value="0">-Select department-</option>
                                                    <option v-bind:key="department.id" v-for='department in departments' :value="department.id">{{department.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <!-- ____________ FORM END __________________ -->
                
                </div>
                <div class="modal-footer">
                <button v-on:click='updateuserdata(userd.id)' type="button" class="btn btn-primary" name="submit" id=""><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['userd','approvaltypes','loggeduserid','departments'],
        data() {
            return {                
                
        userdata: []
            };
        },
        mounted() {
            /* console.log('Component mounted.') */
        },
        methods: {
            updateuserdata: function(val){
                $.ajax({
                    type: 'PUT',
                    url	: '/1_atms/public/users/'+val,
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "admin": this.userd.admin,
                        "tech": this.userd.tech,
                        "req_approver": this.userd.req_approver,
                        "hrvr_approval_type": this.userd.hrvr_approval_type,
                        "hrvr_approval_dept": this.userd.hrvr_approval_dept,
                    }, 
                    datatype: 'JSON',       
                    success: function(success_data) {
                            iziToast.success({
                                    message: success_data,
                                    position: 'topCenter',
                                    timeout: 2000
                            });
                            $('#rolemod').modal('hide')
                    },
                    error: function(data){
                    var errors = data.responseJSON;
                            var msg = '';
                            $.each(errors['errors'], function( index, value ) {
                                    msg += value +"<br>"
                            });
                            iziToast.warning({
                                    message: msg,
                                    position: 'topCenter',
                                    timeout: 5000
                            });
                    }
                });
            }
        }/* ,
        watch: {
            userd: function (value) {
                if(value.hrvr_approval_type != 1 || value.hrvr_approval_type != 2){
                    this.userd.hrvr_approval_dept = 0
                }            
            }
        } */
    }
</script>
