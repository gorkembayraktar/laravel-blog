@extends('front.layouts.master')
@section('title','İletişim')
@section('image',asset('front/img/home-bg.jpg'))
@section('content')




      <div class="col-lg-8 col-md-10 mx-auto">

        @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @endif

        @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                {{$error}}
            </div>
        @endforeach

        <p>Want to get in touch? Fill out the form below to send me a message and I will get back to you as soon as possible!</p>
        <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
        <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
        <!-- To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
      <form name="sentMessage" id="contactForm" method="POST" action="{{route('contact.post')}}" novalidate>
        @csrf  
        <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Ad soyad</label>
            <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Name" id="name" required data-validation-required-message="Please enter your name.">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Email Adresi</label>
              <input type="email" name="email" value="{{old('email')}}"  class="form-control" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address.">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
              <label>Konu</label>
              <select class="form-control" name="topic" id="">
                  <option value="Bilgi" @if(old('topic') == 'Bilgi') selected @endif>Bilgi</option>
                  <option value="Destek" @if(old('topic') == 'Destek') selected @endif>Destek</option>
                  <option value="Genel" @if(old('topic') == 'Genel') selected @endif>Genel</option>
              </select>
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Mesaj</label>
              <textarea name="message" rows="5" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Please enter a message.">{{old('message')}}</textarea>
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <br>
          <div id="success"></div>
          <button type="submit" class="btn btn-primary" id="sendMessageButton">Send</button>
        </form>
      </div>




@endsection