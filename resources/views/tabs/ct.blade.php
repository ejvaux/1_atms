<div class="container border-bottom border-left border-right">
    <div class="row pt-3">
        <div class="col-md-12">
            <form>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="" for="ticketnumber">Ticket #:</label>
                        <input type="text" class="form-control" id="ticketnumber" name="ticketnumber" placeholder="" readonly>
                    </div>
                    <div class="col-md-6">                            
                        <label for="username">Name:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="division">Division:</label>
                        <select type="text" class="form-control" id="division" name="division" placeholder="">
                            <option value="">- Select Division -</option>
                        </select>
                    </div>                                                       
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="title">Subject:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="">
                    </div>
                    <div class="col-md-3">                            
                        <label for="category">Category:</label>
                        <select type="text" class="form-control" id="category" name="category" placeholder="">
                            <option value="">- Select Category -</option>
                            <option value="1">Hardware</option>
                            <option value="2">Operating System</option>
                            <option value="3">Application/Systems</option>
                            <option value="4">Network/Internet</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="priority">Priority:</label>
                        <select type="text" class="form-control" id="priority" name="priority" placeholder="">
                            <option value="">- Select Priority -</option>
                            <option value="1">Low</option>
                            <option value="2">Normal</option>
                            <option value="3">Medium</option>
                            <option value="4">High</option>
                            <option value="5">Very High</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="message">Message:</label>
                        <textarea type="text" class="form-control" rows="8" id="message" name="message" placeholder=""></textarea>
                    </div>
                </div>
                <div class="form-group row text-right">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Submit Ticket</button>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>