@extends('layouts.niftyassistant')

@section('title', 'Support')

@section('content')

    <div class="card col-md-6 mx-auto">
            <div class="auth-form">
                <h4 class="text-center mb-4">Contact Us</h4>
                @include('flash::message')
                <div class="alert alert-warning">
                    <i class="fa fa-lightbulb-o"></i>
                    <strong> Do you need any help?  </strong>
                    Just contact us
                </div>
                <form action="{{ route('niftyassistant.support.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="mb-1"><strong>Subject</strong></label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter Subject of your Message" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-1"><strong>Message</strong></label>
                        <textarea class="form-control" name="message" rows="5" required></textarea>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </div>
                </form>
            </div>
    </div>

@endsection
