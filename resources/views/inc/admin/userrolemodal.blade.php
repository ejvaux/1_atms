<div class="modal hide fade in" role="dialog" id="rolemod" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User Roles</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="roleform"  method="post">
        <input type="hidden" id="iddivcode" name="id">
        <div class="modal-body" style="">
        
            <!-- ____________ FORM __________________ -->
    
            <div class="form-group row">
              <div class="col-6">
                <div class="row">
                  <div class="col-5">
                    <label for="eddivisioncode1" class="col-form-label-sm">DIVISION CODE:</label>                  
                  </div>
                  <div class="col-7">
                    <input id="eddivisioncode1" type="text" class="form-control form-control-sm" name="divisioncode" placeholder="" required>                  
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="row">
                  <div class="col-5">
                    <label for="eddivisionname" class="col-form-label-sm">DIVISION NAME:</label>                  
                  </div>
                  <div class="col-7">
                    <input id="eddivisionname" type="text" class="form-control form-control-sm" name="divisionname" placeholder="">                  
                  </div>
                </div>
              </div>                    
            </div>
            <div class="form-group row">
              <div class="col-6">
                <div class="row">
                  <div class="col-5">
                    <label for="edsapcode" class="col-form-label-sm">SAP DIV CODE:</label>                  
                  </div>
                  <div class="col-7">
                    <input id="edsapcode" type="number" min="0" onkeypress="return isNumberNegative(event)" class="form-control form-control-sm" name="sapcode" placeholder="" required>
                  </div>
                </div>
              </div>                               
            </div>
  
            <!-- ____________ FORM END __________________ -->
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="submit" id="edivcodesubmit"><i class="far fa-save"></i> Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>