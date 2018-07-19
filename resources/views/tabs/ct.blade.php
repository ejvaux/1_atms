<div class="container border-bottom border-left border-right">
    <div class="row pt-3">
        <div class="col-md-12">
            <form id='createticketform' action='{{ action('TicketsController@store') }}' method='POST'>
                @csrf
                <input name="userid" type="hidden" value="{{ Auth::user()->id }}">
                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="" for="ticketnumber">Ticket #:</label>
                        <input type="text" class="form-control" id="ticketnumber" name="ticketnumber" placeholder="" value="{{$ticket_id->id}}" readonly>
                    </div>
                    <div class="col-md-6">                            
                        <label for="username">Name:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="division">Division:</label>
                        <select type="text" class="form-control" id="division" name="division" placeholder="">
                            <option value="">- Select Division -</option>
                            @foreach($divisions as $division)
                                <option value="{{$division->DIVISION_ID}}">{{$division->DIVISION_NAME}}</option>
                            @endforeach
                        </select>
                    </div>                                                       
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="subject">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="">
                    </div>
                    <div class="col-md-3">                            
                        <label for="category">Category:</label>
                        <select type="text" class="form-control" id="category" name="category" placeholder="">
                            <option value="">- Select Category -</option>                            
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="priority">Priority:</label>
                        <select type="text" class="form-control" id="priority" name="priority" placeholder="">
                            <option value="">- Select Priority -</option>
                            @foreach($priorities as $priority)
                                <option value="{{$priority->id}}">{{$priority->name}}</option>
                            @endforeach
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