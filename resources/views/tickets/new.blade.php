@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h1>Create a new ticket</h1>

        <section id="basic-structure">
                    <div class="item-wrapper">
                      <form>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="inputEmail1">Email</label>
                                <input type="email" class="form-control" id="inputEmail1" placeholder="Enter your email">
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail1">Email</label>
                                <input type="email" class="form-control" id="inputEmail1" placeholder="Enter your email">
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail1">Email</label>
                                <input type="email" class="form-control" id="inputEmail1" placeholder="Enter your email">
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword1">Category</label>
                          <select class="form-control" name="category">

                          </select>
                          <input type="password" class="form-control" id="inputPassword1" placeholder="Enter your password">
                        </div>
                        <div class="form-group">
                          <label for="inputPassword1">Message</label>
                          <textarea placeholder="Enter your message" name="message" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Create Ticket</button>
                      </form>
                    </div>
            
        </section> 
    </div>
@endsection