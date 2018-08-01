<div class="container">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" id="bc_viewticket">My Tickets</a></li>
                    <li class="breadcrumb-item">Create Ticket</li>
                    {{-- <li class="breadcrumb-item">Data</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    <div class="row pt-1">
        <div class="col-md-12">
            <form id='createticketform'>
                @csrf
                <input name="userid" type="hidden" value="{{ Auth::user()->id }}">                
                <input type="hidden" id="username" name="username" placeholder="" value="{{ Auth::user()->name }}" readonly>
                
                <div class="form-group row">
                    <div class="col-md-5">
                        <label for="subject">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="" >
                    </div>                    
                    <div class="col-md-2">
                        <label for="priority">Priority:</label>
                        <select type="text" class="form-control" id="priority" name="priority" placeholder="" >
                            <option value="">- Select Priority -</option>
                            @foreach($priorities as $priority)
                                <option value="{{$priority->id}}">{{$priority->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">                            
                        <label for="category">Category:</label>
                        <select type="text" class="form-control" id="category" name="category" placeholder="" >
                            <option value="">- Select Category -</option>                            
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="department">Department:</label>
                        <select type="text" class="form-control" id="department" name="department" placeholder="" >
                            <option value="">- Select Department -</option>
                            @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="message">Description:</label>
                        <textarea type="text" class="form-control" rows="8" id="message" name="message" placeholder="" ></textarea>
                    </div>
                </div>
                <div class="form-group row text-right">
                    <div class="col">
                        <button type='submit' class="btn btn-primary" id="saveTicketButton">Submit Ticket</button>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>