@extends('layouts.register')

@section('content')
<div class="login-container">

        <p>Register new User</p>

        <form action="/register" method="POST">
            {{ csrf_field() }}

            <div class="form-group form-group-default" id="emailGroup">
                <label>Your name</label>
                <div class="controls">
                    <input type="text" name="name" id="email" value="" placeholder="Your name" class="form-control" required="">
                </div>
            </div>
            <div class="form-group form-group-default" id="emailGroup">
                <label>E-mail</label>
                <div class="controls">
                    <input type="text" name="email" id="email" value="" placeholder="E-mail" class="form-control" required="">
                </div>
            </div>

            <div class="form-group form-group-default" id="passwordGroup">
                <label>Password</label>
                <div class="controls">
                    <input type="password" name="password" placeholder="Password" class="form-control" required="">
                </div>
            </div>

            <div class="form-group form-group-default" id="passwordGroup">
                <label>Password Confirmation</label>
                <div class="controls">
                    <input type="password" name="password-confirmation" placeholder="Password" class="form-control" required="">
                </div>
            </div>

            <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-right"></div>
                            <div class="col-md-6">
                            <div class="form-check form-check-inline @error('role') is-invalid @enderror">
                                    <input class="form-check-input" type="radio" name="role" id="inlineRadio1" value="3" checked>
                                    <label class="form-check-label" for="inlineRadio1">Writer</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="inlineRadio2" value="4">
                                    <label class="form-check-label" for="inlineRadio2">Agent</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="inlineRadio2" value="Publisher">
                                    <label class="form-check-label" for="inlineRadio2">Publisher</label>
                                </div>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

            <button type="submit" class="btn btn-block login-button">
                <span class="signingin hidden"><span class="voyager-refresh"></span> Logging in...</span>
                <span class="signin">Signup</span>
            </button>

        </form>

        <div style="clear:both"></div>

        
    </div>
@endsection